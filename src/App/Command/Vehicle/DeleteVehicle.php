<?php

namespace App\Command\Vehicle;


use Domain\Vehicle\VehicleId;

/**
 * delete vehicle command
 */
class DeleteVehicle
{
    private VehicleId $vehicleId;

    public function __construct(VehicleId $vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }

    /**
     * @return VehicleId
     */
    public function getVehicleId(): VehicleId
    {
        return $this->vehicleId;
    }
}
