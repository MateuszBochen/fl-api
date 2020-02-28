<?php



namespace UI\Http\Api\Handler;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Command\Vehicle\CreateVehicle;
use App\Query\Vehicle\GetAllVehicle;
use App\Query\Vehicle\GetVehicle;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Domain\Vehicle\Exceptions\VehicleIdDoesNotExistsException;
use Domain\Vehicle\Exceptions\VehiclenameAlreadyExistsException;
use Domain\Vehicle\Exceptions\VehicleRegistrationNumberAlreadyExistsException;
use Domain\Vehicle\VehicleId;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use UI\Http\Api\Request\CreateVehicleRequest;
use UI\Http\Api\Request\GetAllVehicleRequest;
use UI\Http\Api\Request\GetVehicleRequest;

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

        } catch (UniqueConstraintViolationException $ex) {
            $result = ['message' => 'The user is not unique', 'errors' => []];
            $httpCode = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
            $this->logger->error($ex->getMessage(), ['exception' => $ex]);
        } catch (VehicleRegistrationNumberAlreadyExistsException $ex) {
            $result = ['message' => 'Invalid Request', 'errors' => ['username' => $ex->getMessage()]];
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

        $result = array_map(function ($user) {
            array_forget($user, 'password');

            return $user;
        }, $this->queryBus->handle($query));

        return new JsonResponse($result);
    }
}
