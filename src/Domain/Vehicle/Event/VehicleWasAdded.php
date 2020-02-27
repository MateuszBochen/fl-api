<?php


namespace Domain\Vehicle\Event;

use Cydrickn\DDD\Common\Domain\Event\DomainEventInterface;
use Domain\Vehicle\Vehicle;
use Domain\Vehicle\VehicleBrand;
use Domain\Vehicle\VehicleModel;
use Domain\Vehicle\VehicleRegistrationNumber;

class VehicleWasAdded implements DomainEventInterface
{
    private int $id;
    private VehicleRegistrationNumber $registrationNumber;
    private VehicleBrand $brand;
    private VehicleModel $model;
    private \DateTimeImmutable $createDate;
    private \DateTimeImmutable $lastUpdate;

    /**
     * VehicleWasAdded constructor.
     * @param int $id
     * @param VehicleRegistrationNumber $registrationNumber
     * @param VehicleBrand $brand
     * @param VehicleModel $model
     * @param \DateTimeImmutable $createDate
     * @param \DateTimeImmutable $lastUpdate
     */
    public function __construct(int $id, VehicleRegistrationNumber $registrationNumber, VehicleBrand $brand, VehicleModel $model, \DateTimeImmutable $createDate, \DateTimeImmutable $lastUpdate)
    {
        $this->id = $id;
        $this->registrationNumber = $registrationNumber;
        $this->brand = $brand;
        $this->model = $model;
        $this->createDate = $createDate;
        $this->lastUpdate = $lastUpdate;
    }

    public static function deserialize(array $data): \Cydrickn\DDD\Common\Serializer\Serializable
    {
        return new static(
            $data[Vehicle::FILED_ID],
            new VehicleRegistrationNumber($data[Vehicle::FILED_REGISTRATION_NUMBER]),
            new VehicleBrand($data[Vehicle::FILED_BRAND]),
            new VehicleModel($data[Vehicle::FILED_MODEL]),
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data[Vehicle::FILED_CRATE_DATE], new \DateTimeZone('UTC')),
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data[Vehicle::FILED_LAST_UPDATE], new \DateTimeZone('UTC')),
        );
    }

    public function serialize(): array
    {
        return [
            Vehicle::FILED_ID => $this->id,
            Vehicle::FILED_REGISTRATION_NUMBER => $this->registrationNumber->toString(),
            Vehicle::FILED_BRAND => $this->brand->toString(),
            Vehicle::FILED_MODEL => $this->model->toString(),
            Vehicle::FILED_CRATE_DATE => $this->createDate->format('Y-m-d H:i:s'),
            Vehicle::FILED_LAST_UPDATE => $this->lastUpdate->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
    public function getCreateDate(): \DateTimeImmutable
    {
        return $this->createDate;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getLastUpdate(): \DateTimeImmutable
    {
        return $this->lastUpdate;
    }
}
