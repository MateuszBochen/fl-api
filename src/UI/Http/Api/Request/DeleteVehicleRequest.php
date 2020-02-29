<?php



namespace UI\Http\Api\Request;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of DeleteVehicleRequest
 *
 * @author Mateusz Bochen
 */
class DeleteVehicleRequest
{
    private $id;

    public static function createFromRequest(Request $request): self
    {
        $instance = new DeleteVehicleRequest();
        $instance->id = $request->get('id');

        return $instance;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
