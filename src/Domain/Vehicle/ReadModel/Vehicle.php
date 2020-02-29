<?php

namespace Domain\Vehicle\ReadModel;

use Cydrickn\DDD\Common\Domain\ValueObject\DomainIdInterface;
use Cydrickn\DDD\Common\ReadModel\AbstractReadModel;
use Cydrickn\DDD\Common\Serializer\Serializable;
use Domain\Vehicle\Event\AbstractVehicleEvent;
use Domain\Vehicle\Event\VehicleWasCreated;
use Domain\Vehicle\Event\VehicleWasDeleted;
use Domain\Vehicle\Event\VehicleWasUpdated;
use Domain\Vehicle\VehicleBrand;
use Domain\Vehicle\VehicleId;
use Domain\Vehicle\Vehicle as VehicleDomain;
use Domain\Vehicle\VehicleModel;
use Domain\Vehicle\VehicleRegistrationNumber;


class Vehicle extends AbstractReadModel
{

    private DomainIdInterface $id;
    private VehicleRegistrationNumber $registrationNumber;
    private VehicleBrand $brand;
    private VehicleModel $model;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $lastUpdate;

    public static function deserialize(array $data): Serializable
    {
        $instance = new static;
        $instance->id = VehicleId::fromString($data[VehicleDomain::FILED_ID]);
        $instance->registrationNumber = new VehicleRegistrationNumber($data[VehicleDomain::FILED_VEHICLE_REGISTRATION_NUMBER]);
        $instance->brand = new VehicleBrand($data[VehicleDomain::FILED_VEHICLE_BRAND]);
        $instance->model = new VehicleModel($data[VehicleDomain::FILED_VEHICLE_MODEL]);
        $instance->createdAt = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s',$data[VehicleDomain::FILED_CREATED_AT],new \DateTimeZone('UTC'));
        $instance->lastUpdate = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s',$data[VehicleDomain::FILED_LAST_UPDATE],new \DateTimeZone('UTC'));

        return $instance;
    }

    public function serialize(): array
    {
        return [
            VehicleDomain::FILED_ID => $this->id->toString(),
            VehicleDomain::FILED_VEHICLE_REGISTRATION_NUMBER => $this->registrationNumber->toString(),
            VehicleDomain::FILED_VEHICLE_BRAND => $this->brand->toString(),
            VehicleDomain::FILED_VEHICLE_MODEL => $this->model->toString(),
            VehicleDomain::FILED_CREATED_AT => $this->createdAt->format('Y-m-d H:i:s'),
            VehicleDomain::FILED_LAST_UPDATE => $this->lastUpdate->format('Y-m-d H:i:s'),
        ];
    }

    public function applyVehicleWasCreated(VehicleWasCreated $event): void
    {
        $this->applyFromEvent($event);
    }

    public function applyVehicleWasDeleted(VehicleWasDeleted $event): void
    {
        $this->applyFromEvent($event);
    }

    public function applyVehicleWasUpdated(VehicleWasUpdated $event): void
    {
        $this->applyFromEvent($event);
    }

    private function applyFromEvent(AbstractVehicleEvent $abstractVehicleEvent)
    {
        $this->registrationNumber = $abstractVehicleEvent->getVehicleRegistrationNumber();
        $this->brand = $abstractVehicleEvent->getVehicleBrand();
        $this->model = $abstractVehicleEvent->getVehicleModel();
        $this->model = $abstractVehicleEvent->getVehicleModel();
        $this->createdAt = $abstractVehicleEvent->getCreatedAt();
        $this->lastUpdate = $abstractVehicleEvent->getLastUpdate();
        $this->id = $abstractVehicleEvent->getId();
    }

    /**
     * @return VehicleRegistrationNumber
     */
    public function getRegistrationNumber(): VehicleRegistrationNumber
    {
        return $this->registrationNumber;
    }

    /**
     * @return VehicleBrand
     */
    public function getBrand(): VehicleBrand
    {
        return $this->brand;
    }

    /**
     * @return VehicleModel
     */
    public function getModel(): VehicleModel
    {
        return $this->model;
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

    public function getId(): string
    {
        return $this->id;
    }
}
