<?php


namespace Domain\Vehicle\Repository;

use Domain\Vehicle\Vehicle;
use Domain\Vehicle\VehicleId;


interface VehicleRepositoryInterface
{
    public function get(VehicleId $id): Vehicle;

    public function store(Vehicle $vehicle): void;

    public function exists(VehicleId $id): bool;
}
