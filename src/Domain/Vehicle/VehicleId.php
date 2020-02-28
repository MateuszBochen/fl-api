<?php


namespace Domain\Vehicle;

use Cydrickn\DDD\Common\Domain\ValueObject\DomainId;
use Ramsey\Uuid\Uuid;

class VehicleId extends DomainId
{
    final public static function generate(): self
    {
        return self::fromString(Uuid::uuid4()->toString());
    }
}
