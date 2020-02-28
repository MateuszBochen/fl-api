<?php


namespace App\Query\Vehicle;

use Cydrickn\DDD\Common\Query\AbstractQueryHandler;
use Domain\Vehicle\Exceptions\VehicleIdDoesNotExistsException;
use Domain\Vehicle\ReadModel\VehicleRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;


class VehicleHandler extends AbstractQueryHandler implements MessageSubscriberInterface
{
    private VehicleRepositoryInterface $vehicleRepository;

    public static function getHandledMessages(): iterable
    {
        yield GetVehicle::class;
        yield GetAllVehicle::class;
    }

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    protected function handleGetVehicle(GetVehicle $command)
    {
        $result = $this->vehicleRepository->find($command->getVehicleId());

        if ($result === null) {
            throw new VehicleIdDoesNotExistsException(sprintf('Vehicle id "%s" does not exists', $command->vehicleId()));
        }

        if ($command->isReturnAsArray()) {
            return $result->serialize();
        }

        return $result;
    }

    protected function handleGetAllVehicle(GetAllVehicle $command): array
    {
        $iterator = $this->vehicleRepository->findAll();

        if ($command->isReturnAsArray()) {
            $iterator->setReturnAsArray();
        }

        $result = [];
        foreach ($iterator as $data) {
            $result[] = $data;
        }

        return $result;
    }
}
