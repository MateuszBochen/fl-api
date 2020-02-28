<?php

namespace UI\Http\Api\Request;

/**
 * Description of GetAllVehicleRequest
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class GetAllVehicleRequest
{
    public static function createFromRequest(\Symfony\Component\HttpFoundation\Request $request): self
    {
        return new static;
    }
}
