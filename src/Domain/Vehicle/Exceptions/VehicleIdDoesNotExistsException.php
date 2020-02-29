<?php


namespace Domain\Vehicle\Exceptions;


use Throwable;

class VehicleIdDoesNotExistsException extends \RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Vehicle not found '.$message, $code, $previous);
    }
}
