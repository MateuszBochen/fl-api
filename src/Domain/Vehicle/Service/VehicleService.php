<?php


namespace Domain\Vehicle\Service;


use Domain\Vehicle\ReadModel\VehicleRepositoryInterface;

class VehicleService
{
    private VehicleRepositoryInterface $vehicleRepositoryInterface;

    public function __construct(VehicleRepositoryInterface $vehicleRepositoryInterface)
    {
        $this->vehicleRepositoryInterface = $vehicleRepositoryInterface;
    }

    public function addVehicle()
    {

    }
}
