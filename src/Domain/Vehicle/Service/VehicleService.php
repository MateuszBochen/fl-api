<?php


namespace Domain\Vehicle\Service;

use Domain\Vehicle\Event\VehicleWasCreated;
use Domain\Vehicle\Event\VehicleWasDeleted;
use Domain\Vehicle\Exceptions\VehicleIdDoesNotExistsException;
use Domain\Vehicle\Exceptions\VehicleRegistrationNumberAlreadyExistsException;
use Domain\Vehicle\ReadModel\VehicleRepositoryInterface;
use Domain\Vehicle\Vehicle;
use Domain\Vehicle\VehicleBrand;
use Domain\Vehicle\VehicleId;
use Domain\Vehicle\VehicleModel;
use Domain\Vehicle\VehicleRegistrationNumber;


class VehicleService
{
    private VehicleRepositoryInterface $vehicleReadModelRepository;

    public function __construct(VehicleRepositoryInterface $vehicleReadModelRepository)
    {
        $this->vehicleReadModelRepository = $vehicleReadModelRepository;
    }

    public function createVehicle(
        VehicleId $vehicleId,
        VehicleRegistrationNumber $vehicleRegistrationNumber,
        VehicleBrand $vehicleBrand,
        VehicleModel $vehicleModel
    ): Vehicle
    {
        if ($this->vehicleReadModelRepository->findIdByRegistrationNumber($vehicleRegistrationNumber->toString()) !== null) {
            throw new VehicleRegistrationNumberAlreadyExistsException(sprintf('VehicleRegistrationNumber %s already exists', $vehicleRegistrationNumber->toString()));
        }

        $event = new VehicleWasCreated(
            $vehicleId,
            $vehicleRegistrationNumber,
            $vehicleBrand,
            $vehicleModel,
            new \DateTimeImmutable('now', new \DateTimeZone('UTC')),
            new \DateTimeImmutable('now', new \DateTimeZone('UTC'))
        );

        $vehicle = new Vehicle();
        $vehicle->applyEvent($event);

        return $vehicle;
    }

    public function deleteVehicle(VehicleId $vehicleId)
    {
        $vehicle = $this->vehicleReadModelRepository->find($vehicleId);

        if (!$vehicle) {
            throw new VehicleIdDoesNotExistsException($vehicleId);
        }

        $this->vehicleReadModelRepository->remove($vehicleId);

        $event = new VehicleWasDeleted(
            $vehicleId,
            $vehicle->getRegistrationNumber(),
            $vehicle->getBrand(),
            $vehicle->getModel(),
            $vehicle->getCreatedAt(),
            new \DateTimeImmutable('now', new \DateTimeZone('UTC'))
        );

        $vehicle = new Vehicle();
        $vehicle->applyEvent($event);

        return $vehicle;
    }
}
