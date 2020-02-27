<?php


namespace Domain\Vehicle\Repository;


use Domain\Vehicle\Vehicle;

interface VehicleRepositoryInterface
{
    public function get(int $id): Vehicle;

    public function store(Vehicle $vehicle): void;

    public function exists(Vehicle $vehicle): bool;
}
