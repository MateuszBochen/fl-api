<?php

namespace Domain\Vehicle\ReadModel;

use Cydrickn\DDD\Common\EventStore\EventMessage;
use Cydrickn\DDD\Common\ReadModel\AbstractReadModelEventHandler;
use Domain\Vehicle\Event\VehicleWasCreated;


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

    public static function supports(EventMessage $event): bool
    {
        $supportedClases = [
            VehicleWasCreated::class,
        ];

        return in_array(get_class($event->payload()), $supportedClases);
    }
}
