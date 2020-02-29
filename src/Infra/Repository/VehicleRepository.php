<?php

namespace Infra\Repository;

use Domain\Vehicle\Repository\VehicleRepositoryInterface;
use Domain\Vehicle\Vehicle;
use Domain\Vehicle\VehicleId;

/**
 * Description of VehicleRepository
 *
 * @author Mateusz Bochen
 */
class VehicleRepository extends AbstractEventSourceRepository implements VehicleRepositoryInterface
{
    public function exists(VehicleId $id): bool
    {
        return $this->sourceExists($id->toString());
    }

    public function get(VehicleId $id): Vehicle
    {
        return $this->getSource($id->toString());
    }

    public function store(Vehicle $vehicle): void
    {
        $this->saveSource($vehicle);
    }

    protected function getAggregateClass(): string
    {
        return Vehicle::class;
    }

    protected function getAggregateType(): string
    {
        return 'vehicle';
    }
}
