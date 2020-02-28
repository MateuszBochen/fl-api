<?php

namespace App\Bus;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBus implements \Cydrickn\DDD\Common\Query\QueryBusInterface
{
    use HandleTrait {
        handle as traitHandle;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function handle($message)
    {
        return $this->traitHandle($message);
    }
}
