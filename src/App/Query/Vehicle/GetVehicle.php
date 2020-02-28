<?php

namespace App\Query\Vehicle;

use App\Query\Common\Query;

class GetVehicle extends Query
{
    private string $vehicleId;

    public function __construct(string $vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }

    /**
     * @return string
     */
    public function getVehicleId(): string
    {
        return $this->vehicleId;
    }
}
