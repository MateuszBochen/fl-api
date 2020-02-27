<?php


namespace UI\Http\Api\Handler;


use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Command\Vehicle\NewVehicle;
use App\Query\Vehicle\GetVehicleByRegistrationNumber;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Domain\User\Exceptions\UsernameAlreadyExistsException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use UI\Http\Api\Request\CreateVehicleRequest;

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

    /**
     * @inheritDoc
     */
    public static function getHandledMessages(): iterable
    {
        yield CreateVehicleRequest::class;
    }

    public function __construct(CommandBus $commandBus, QueryBus $queryBus, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->logger = $logger;
    }

    public function handleCreateVehicleRequest(CreateVehicleRequest $request): JsonResponse
    {

        $httpCode = JsonResponse::HTTP_CREATED;
        $result = [];

        try {
            $command = new NewVehicle(
                $request->getRegistrationNumber(),
                $request->getBrand(),
                $request->getModel()
            );

            $this->commandBus->handle($command);

            $query = new GetVehicleByRegistrationNumber($request->getRegistrationNumber());
            $query->setResponseAsArray();
            $result = $this->queryBus->handle($query);
        } catch (UniqueConstraintViolationException $ex) {
            $result = ['message' => 'The user is not unique', 'errors' => []];
            $httpCode = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
            $this->logger->error($ex->getMessage(), ['exception' => $ex]);
        } catch (UsernameAlreadyExistsException $ex) {
            $result = ['message' => 'Invalid Request', 'errors' => ['username' => $ex->getMessage()]];
            $httpCode = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        }

        return new JsonResponse($result, $httpCode);
    }
}