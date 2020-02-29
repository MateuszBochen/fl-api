<?php

namespace Domain\Vehicle\ReadModel;

use Cydrickn\DDD\Common\ReadModel\ReadModelRepositoryInterface;
use Domain\Vehicle\VehicleId;


interface VehicleRepositoryInterface extends ReadModelRepositoryInterface
{
    public function findIdByRegistrationNumber(string $registrationNumber): ?VehicleId;
}
