<?php

namespace App\Command\Vehicle;


use Cydrickn\DDD\Common\Command\AbstractCommandHandler;
use Domain\Vehicle\Repository\VehicleRepositoryInterface;
use Domain\Vehicle\Service\VehicleService;
use Domain\Vehicle\VehicleBrand;
use Domain\Vehicle\VehicleModel;
use Domain\Vehicle\VehicleRegistrationNumber;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;


class VehicleHandler extends AbstractCommandHandler implements MessageSubscriberInterface
{
    /**
     * @var VehicleRepositoryInterface
     */
    private VehicleRepositoryInterface $vehicleRepository;

    /**
     * @var VehicleService
     */
    private VehicleService $vehicleService;

    public static function getHandledMessages(): iterable
    {
        yield CreateVehicle::class;
    }

    public function __construct(
        VehicleRepositoryInterface $vehicleRepository,
        VehicleService $vehicleService
    ) {
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleService = $vehicleService;
    }

    protected function handleCreateVehicle(CreateVehicle $command): void
    {
        $vehicle = $this->vehicleService->createVehicle(
            $command->getVehicleId(),
            new VehicleRegistrationNumber($command->getRegistrationNumber()),
            new VehicleBrand($command->getBrand()),
            new VehicleModel($command->getModel())
        );

        $this->vehicleRepository->store($vehicle);
    }
}
