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


final class VehicleWasDeleted extends AbstractVehicleEvent
{
}
