<?php

namespace UI\Http\Api\Controller;

use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UI\Http\Api\Request\CreateVehicleRequest;
use UI\Http\Api\Request\GetAllVehicleRequest;
use UI\Http\Api\Request\GetVehicleRequest;
use UI\Http\Api\Request\DeleteVehicleRequest;
use UI\Http\Bus\RequestBus;

/**
 *
 * @Route("/vehicle")
 */
class VehicleController extends AbstractController
{
    /**
     * @Route("/create", methods={"POST"})
     * @SWG\Tag(name="Vehicle")
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     @SWG\Schema(
     *         @SWG\Property(property="registartion_number", type="string"),
     *         @SWG\Property(property="brand", type="string"),
     *         @SWG\Property(property="model", type="string"),
     *     )
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Vehicle Created an account",
     *     @SWG\Schema(
     *         @SWG\Property(property="id", type="string"),
     *         @SWG\Property(property="registartion_number", type="string"),
     *         @SWG\Property(property="brand", type="string"),
     *         @SWG\Property(property="model", type="string"),
     *         @SWG\Property(property="create_at", type="string")
     *     )
     * )
     * @SWG\Response(
     *     response=422,
     *     description="Validation failed",
     *     @SWG\Schema(
     *         @SWG\Property(property="message", type="string", example="Invalid Input"),
     *         @SWG\Property(property="errors", type="object"),
     *     )
     * )
     * @param Request $request
     * @param RequestBus $bus
     * @return Response
     */
    public function createVehicle(Request $request, RequestBus $bus): Response
    {
        $createVehicleRequest = CreateVehicleRequest::createFromRequest($request);

        return $bus->handle($createVehicleRequest);
    }

    /**
     * @Route("/get", methods={"GET"})
     * @SWG\Tag(name="Vehicle")
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="string"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="OK"
     * )
     * @param Request $request
     * @param RequestBus $bus
     * @return Response
     */
    public function getSpecificVehicle(Request $request, RequestBus $bus): Response
    {
        $getVehicleRequest = GetVehicleRequest::createFromRequest($request);

        return $bus->handle($getVehicleRequest);
    }

    /**
     * @Route("/delete", methods={"DELETE"})
     * @SWG\Tag(name="Vehicle")
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="string"
     * )
     * @SWG\Response(
     *     response=204,
     *     description="No Content"
     * )
     * @param Request $request
     * @param RequestBus $bus
     * @return Response
     */
    public function deleteVehicle(Request $request, RequestBus $bus): Response
    {
        $getVehicleRequest = DeleteVehicleRequest::createFromRequest($request);

        return $bus->handle($getVehicleRequest);
    }

    /**
     * @Route("/all", methods={"GET"})
     * @SWG\Tag(name="Vehicle")
     * @SWG\Response(
     *     response=200,
     *     description="OK"
     * )
     * @param Request $request
     * @param RequestBus $bus
     * @return Response
     */
    public function getAllVehicle(Request $request, RequestBus $bus): Response
    {
        $getVehicleAllRequest = GetAllVehicleRequest::createFromRequest($request);

        return $bus->handle($getVehicleAllRequest);
    }
}
