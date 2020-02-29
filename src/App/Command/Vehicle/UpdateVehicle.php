<?php

namespace App\Command\Vehicle;

use Cydrickn\DDD\Common\Command\CommandInterface;
use Domain\Vehicle\VehicleId;


class UpdateVehicle
{
    private VehicleId $vehicleId;
    private string $registrationNumber;
    private string $brand;
    private string $model;

    public function __construct(VehicleId $vehicleId, string $registrationNumber, string $brand, string $model)
    {
        $this->vehicleId = $vehicleId;
        $this->registrationNumber = $registrationNumber;
        $this->brand = $brand;
        $this->model = $model;
    }

    /**
     * @return VehicleId
     */
    public function getVehicleId(): VehicleId
    {
        return $this->vehicleId;
    }

    /**
     * @return string
     */
    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }
}
