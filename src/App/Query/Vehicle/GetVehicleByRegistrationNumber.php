<?php


namespace App\Query\Vehicle;


class GetVehicleByRegistrationNumber
{
    private string $registrationNumber;

    /**
     * GetVehicleByRegistrationNumber constructor.
     * @param string $registrationNumber
     */
    public function __construct(string $registrationNumber)
    {
        $this->registrationNumber = $registrationNumber;
    }

    /**
     * @return string
     */
    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }
}
