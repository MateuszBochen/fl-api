<?php


namespace Domain\Vehicle;


use Cydrickn\DDD\Common\Domain\AbstractDomain;
use Cydrickn\DDD\Common\EventSourcing\EventSourceInterface;
use Cydrickn\DDD\Common\EventSourcing\EventSourceTrait;
use Domain\User\Exceptions\InvalidIdException;
use Domain\Vehicle\Event\VehicleWasAdded;

final class Vehicle extends AbstractDomain implements EventSourceInterface
{
    use EventSourceTrait;

    const FILED_ID = 'id';
    const FILED_REGISTRATION_NUMBER = 'registration_number';
    const FILED_BRAND = 'brand';
    const FILED_MODEL = 'model';
    const FILED_CRATE_DATE = 'create_date';
    const FILED_LAST_UPDATE = 'last_update';

    private VehicleRegistrationNumber $registrationNumber;
    private VehicleBrand $brand;
    private VehicleModel $model;
    private \DateTimeImmutable $createDate;
    private \DateTimeImmutable $lastUpdate;

    public function getAggregateRootId(): string
    {
        if ($this->isEmptyId()) {
            throw new InvalidIdException('Id cannot be blank');
        }

        return $this->id;
    }

    protected function applyVehicleWasAddedEvent(VehicleWasAdded $event): void
    {
        $this->id = $event->getId();
        $this->registrationNumber = $event->getRegistrationNumber();
        $this->brand = $event->getBrand();
        $this->model = $event->getModel();
        $this->createDate = $event->getCreateDate();
        $this->lastUpdate = $event->getLastUpdate();
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
