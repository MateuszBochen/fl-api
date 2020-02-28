<?php



namespace UI\Http\Api\Request;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of GetVehicleRequest
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class GetVehicleRequest
{
    private $id;

    public static function createFromRequest(Request $request): self
    {
        $instance = new GetVehicleRequest();
        $instance->id = $request->get('id');

        return $instance;
    }

    public function id(): string
    {
        return $this->id;
    }
}
