<?php

namespace Domain\Vehicle\ReadModel;

use Cydrickn\DDD\Common\EventStore\EventMessage;
use Cydrickn\DDD\Common\ReadModel\AbstractReadModelEventHandler;
use Domain\Vehicle\Event\VehicleWasCreated;
use Domain\Vehicle\Event\VehicleWasDeleted;
use Domain\Vehicle\Event\VehicleWasUpdated;


class VehicleEventSubscriber extends AbstractReadModelEventHandler
{
    /**
     * @var VehicleRepositoryInterface
     */
    private VehicleRepositoryInterface $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function handleVehicleWasCreated(EventMessage $message): void
    {
        $vehicle = new Vehicle();
        $vehicle->apply($message->payload());

        $this->vehicleRepository->save($vehicle);
    }

    public function handleVehicleWasDeleted(EventMessage $message): void
    {
        $vehicle = new Vehicle();
        $vehicle->apply($message->payload());

        $this->vehicleRepository->remove($vehicle->getId());
    }

    public function handleVehicleWasUpdated(EventMessage $message): void
    {
        $vehicle = new Vehicle();
        $vehicle->apply($message->payload());

        $this->vehicleRepository->update($vehicle);
    }

    public static function supports(EventMessage $event): bool
    {
        $supportedClases = [
            VehicleWasCreated::class,
            VehicleWasDeleted::class,
            VehicleWasUpdated::class,
        ];

        return in_array(get_class($event->payload()), $supportedClases);
    }
}
