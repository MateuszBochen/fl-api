<?php


namespace App\Command\Vehicle;


use Cydrickn\DDD\Common\Command\AbstractCommandHandler;
use Domain\Vehicle\Repository\VehicleRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class VehicleHandler extends AbstractCommandHandler implements MessageSubscriberInterface
{

    /**
     * @inheritDoc
     */
    public static function getHandledMessages(): iterable
    {
        yield NewVehicle::class;
    }

    public function __construct(
        VehicleRepositoryInterface $userRepository,
        UserService $userService
    ) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }
}