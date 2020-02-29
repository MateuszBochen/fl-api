<?php

namespace UI\Http\Api\Request;

use Symfony\Component\HttpFoundation\Request;

class UpdateVehicleRequest
{
    private string $id;

    private string $registrationNumber;

    private string $brand;

    private string $model;

    public static function createFromRequest(Request $request): self
    {

        $data = array_merge_recursive($request->request->all(), json_decode($request->getContent(), true));

        $instance = new static;
        $instance->id = $request->get('id');
        $instance->registrationNumber = $data['registration_number'];
        $instance->brand = $data['brand'];
        $instance->model = $data['model'];

        return $instance;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
