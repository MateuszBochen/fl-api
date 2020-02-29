<?php

namespace App\Command\Vehicle;


use Cydrickn\DDD\Common\Command\AbstractCommandHandler;
use Domain\Vehicle\Exceptions\VehicleIdDoesNotExistsException;
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
        yield DeleteVehicle::class;
        yield UpdateVehicle::class;
    }

    public function __construct(
        VehicleRepositoryInterface $vehicleRepository,
        VehicleService $vehicleService
    ) {
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleService = $vehicleService;
    }

    /**
     * @param CreateVehicle $command
     */
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

    /**
     * @param UpdateVehicle $command
     */
    protected function handleUpdateVehicle(UpdateVehicle $command): void
    {
        $vehicle = $this->vehicleService->updateVehicle(
            $command->getVehicleId(),
            new VehicleRegistrationNumber($command->getRegistrationNumber()),
            new VehicleBrand($command->getBrand()),
            new VehicleModel($command->getModel())
        );

        if (!$this->vehicleRepository->exists($vehicle->id())) {
            $this->vehicleRepository->store($vehicle);
        }
    }

    /**
     * @param DeleteVehicle $deleteVehicleCommand
     * @author Mateusz Bochen
     */
    protected function handleDeleteVehicle(DeleteVehicle $deleteVehicleCommand)
    {
        $vehicle = $this->vehicleService->deleteVehicle($deleteVehicleCommand->getVehicleId());

        $this->vehicleRepository->store($vehicle);
    }
}
