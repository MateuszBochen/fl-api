<?php

namespace Domain\Vehicle;

use Cydrickn\DDD\Common\Domain\AbstractDomain;
use Cydrickn\DDD\Common\EventSourcing\EventSourceInterface;
use Cydrickn\DDD\Common\EventSourcing\EventSourceTrait;
use Domain\Vehicle\Event\VehicleWasCreated;
use Domain\Vehicle\Event\VehicleWasDeleted;
use Domain\Vehicle\Exceptions\InvalidIdException;


final class Vehicle extends AbstractDomain implements EventSourceInterface
{
    use EventSourceTrait;

    const FILED_ID = 'id';
    const FILED_VEHICLE_REGISTRATION_NUMBER = 'registration_number';
    const FILED_VEHICLE_BRAND = 'brand';
    const FILED_VEHICLE_MODEL = 'model';
    const FILED_CREATED_AT = 'created_at';
    const FILED_LAST_UPDATE = 'last_update';

    private VehicleRegistrationNumber $vehicleRegistrationNumber;
    private VehicleBrand $vehicleBrand;
    private VehicleModel $vehicleModel;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $lastUpdate;

    public function getAggregateRootId(): string
    {
        if ($this->isEmptyId()) {
            throw new InvalidIdException('Id cannot be blank');
        }

        return $this->id()->toString();
    }

    protected function applyVehicleWasCreatedEvent(VehicleWasCreated $event): void
    {
        $this->id = $event->getId();
        $this->vehicleRegistrationNumber = $event->getVehicleRegistrationNumber();
        $this->vehicleBrand = $event->getVehicleBrand();
        $this->vehicleModel = $event->getVehicleModel();
        $this->createdAt = $event->getCreatedAt();
        $this->lastUpdate = $event->getLastUpdate();
    }

    protected function applyVehicleWasDeletedEvent(VehicleWasDeleted $event): void
    {
        $this->id = $event->getId();
        $this->vehicleRegistrationNumber = $event->getVehicleRegistrationNumber();
        $this->vehicleBrand = $event->getVehicleBrand();
        $this->vehicleModel = $event->getVehicleModel();
        $this->createdAt = $event->getCreatedAt();
        $this->lastUpdate = $event->getLastUpdate();
    }

    /**
     * @return VehicleRegistrationNumber
     */
    public function getVehicleRegistrationNumber(): VehicleRegistrationNumber
    {
        return $this->vehicleRegistrationNumber;
    }

    /**
     * @return VehicleBrand
     */
    public function getVehicleBrand(): VehicleBrand
    {
        return $this->vehicleBrand;
    }

    /**
     * @return VehicleModel
     */
    public function getVehicleModel(): VehicleModel
    {
        return $this->vehicleModel;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getLastUpdate(): \DateTimeImmutable
    {
        return $this->lastUpdate;
    }
}
