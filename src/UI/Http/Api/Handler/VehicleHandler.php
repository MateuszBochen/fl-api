<?php



namespace UI\Http\Api\Handler;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Command\Vehicle\CreateVehicle;
use App\Command\Vehicle\DeleteVehicle;
use App\Command\Vehicle\UpdateVehicle;
use App\Query\Vehicle\GetAllVehicle;
use App\Query\Vehicle\GetVehicle;
use Domain\Vehicle\Exceptions\VehicleIdDoesNotExistsException;
use Domain\Vehicle\Exceptions\VehicleRegistrationNumberAlreadyExistsException;
use Domain\Vehicle\VehicleId;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use UI\Http\Api\Request\CreateVehicleRequest;
use UI\Http\Api\Request\GetAllVehicleRequest;
use UI\Http\Api\Request\GetVehicleRequest;
use UI\Http\Api\Request\DeleteVehicleRequest;
use UI\Http\Api\Request\UpdateVehicleRequest;

class VehicleHandler extends AbstractHandler implements MessageSubscriberInterface
{
    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    /**
     * @var QueryBus
     */
    private QueryBus $queryBus;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public static function getHandledMessages(): iterable
    {
        yield CreateVehicleRequest::class;
        yield GetVehicleRequest::class;
        yield GetAllVehicleRequest::class;
        yield DeleteVehicleRequest::class;
        yield UpdateVehicleRequest::class;
    }

    public function __construct(CommandBus $commandBus, QueryBus $queryBus, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->logger = $logger;
    }

    public function handleCreateVehicleRequest(CreateVehicleRequest $request): JsonResponse
    {
        $vehicleId = VehicleId::generate();
        $httpCode = JsonResponse::HTTP_CREATED;

        try {
            $command = new CreateVehicle(
                $vehicleId,
                $request->getRegistrationNumber(),
                $request->getBrand(),
                $request->getModel()
            );
            $this->commandBus->handle($command);

            $query = new GetVehicle($vehicleId->toString());
            $query->setResponseAsArray();
            $result = $this->queryBus->handle($query);

        } catch (VehicleRegistrationNumberAlreadyExistsException $ex) {
            $result = ['message' => 'Invalid Request', 'errors' => ['registration number' => $ex->getMessage()]];
            $httpCode = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        }

        return new JsonResponse($result, $httpCode);
    }

    public function handleGetVehicleRequest(GetVehicleRequest $request): JsonResponse
    {
        $userId = $request->id();

        $query = new GetVehicle($userId);
        $query->setResponseAsArray();

        try {
            $result = $this->queryBus->handle($query);
            array_forget($result, 'password');

            return new JsonResponse($result);
        } catch (VehicleIdDoesNotExistsException $ex) {
            return new JsonResponse(['message' => $ex->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }
    }

    public function handleGetAllVehicleRequest(GetAllVehicleRequest $request): JsonResponse
    {
        $query = new GetAllVehicle();
        $query->setResponseAsArray();

        $result = $this->queryBus->handle($query);
        return new JsonResponse($result);
    }


    /**
     * @param DeleteVehicleRequest $request
     * @return JsonResponse
     * @author Mateusz Bochen
     */
    public function handleDeleteVehicleRequest(DeleteVehicleRequest $request): JsonResponse
    {
        $vehicleId = new VehicleId($request->getId());

        try {
            $command = new DeleteVehicle($vehicleId);
            $this->commandBus->handle($command);
        } catch (VehicleIdDoesNotExistsException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([]); // delete method should return empty content
    }

    /**
     * @param UpdateVehicleRequest $request
     * @return JsonResponse
     * @author Mateusz Bochen
     */
    public function handleUpdateVehicleRequest(UpdateVehicleRequest $request): JsonResponse
    {
        $vehicleId = new VehicleId($request->getId());

        try {
            $command = new UpdateVehicle(
                $vehicleId,
                $request->getRegistrationNumber(),
                $request->getBrand(),
                $request->getModel(),
            );

            $this->commandBus->handle($command);
        } catch (VehicleIdDoesNotExistsException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }

        $query = new GetVehicle($vehicleId->toString());
        $query->setResponseAsArray();
        return new JsonResponse($this->queryBus->handle($query));
    }
}
