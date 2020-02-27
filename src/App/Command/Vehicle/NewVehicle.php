<?php


namespace App\Command\Vehicle;


class NewVehicle
{
    private string $registrationNumber; // registration_number
    private string $brand;
    private string $model;

    /**
     * NewVehicle constructor.
     * @param string $registrationNumber
     * @param string $brand
     * @param string $model
     */
    public function __construct(string $registrationNumber, string $brand, string $model)
    {
        $this->registrationNumber = $registrationNumber;
        $this->brand = $brand;
        $this->model = $model;
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
