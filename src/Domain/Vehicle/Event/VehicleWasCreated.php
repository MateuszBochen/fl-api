<?php

namespace Domain\Vehicle\Event;

use Cydrickn\DDD\Common\Domain\Event\DomainEventInterface;
use Cydrickn\DDD\Common\Domain\ValueObject\DomainIdInterface;
use Cydrickn\DDD\Common\Serializer\Serializable;
use Domain\Vehicle\Vehicle;
use Domain\Vehicle\VehicleBrand;
use Domain\Vehicle\VehicleId;
use Domain\Vehicle\VehicleModel;
use Domain\Vehicle\VehicleRegistrationNumber;


final class VehicleWasCreated implements DomainEventInterface
{
    private DomainIdInterface $id;
    private VehicleRegistrationNumber $vehicleRegistrationNumber;
    private VehicleBrand $vehicleBrand;
    private VehicleModel $vehicleModel;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $lastUpdate;

    public function __construct(
        DomainIdInterface $id,
        VehicleRegistrationNumber $vehicleRegistrationNumber,
        VehicleBrand $vehicleBrand,
        VehicleModel $vehicleModel,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $lastUpdate
    )
    {
        $this->id = $id;
        $this->vehicleRegistrationNumber = $vehicleRegistrationNumber;
        $this->vehicleBrand = $vehicleBrand;
        $this->vehicleModel = $vehicleModel;
        $this->createdAt = $createdAt;
        $this->lastUpdate = $lastUpdate;
    }

    public function serialize(): array
    {
        return [
            Vehicle::FILED_ID => $this->id->toString(),
            Vehicle::FILED_VEHICLE_REGISTRATION_NUMBER => $this->vehicleRegistrationNumber->toString(),
            Vehicle::FILED_VEHICLE_BRAND => $this->vehicleBrand->toString(),
            Vehicle::FILED_VEHICLE_MODEL => $this->vehicleModel->toString(),
            Vehicle::FILED_CREATED_AT => $this->createdAt->format('Y-m-d H:i:s'),
            Vehicle::FILED_LAST_UPDATE => $this->lastUpdate->format('Y-m-d H:i:s'),
        ];
    }

    public static function deserialize(array $data): Serializable
    {
        return new static(
            VehicleId::fromString($data[ Vehicle::FILED_ID]),
            new VehicleRegistrationNumber($data[Vehicle::FILED_VEHICLE_REGISTRATION_NUMBER]),
            new VehicleBrand($data[Vehicle::FILED_VEHICLE_BRAND]),
            new VehicleModel($data[Vehicle::FILED_VEHICLE_MODEL]),
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data[Vehicle::FILED_CREATED_AT], new \DateTimeZone('UTC')),
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data[Vehicle::FILED_LAST_UPDATE], new \DateTimeZone('UTC'))
        );
    }

    /**
     * @return DomainIdInterface
     */
    public function getId(): DomainIdInterface
    {
        return $this->id;
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
