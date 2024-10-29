<?php

namespace App\Resource;

use App\Service\Interface\RestaurantServiceInterface;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    private $restaurantService;

    public function __construct(RestaurantServiceInterface $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function register(Request $request)
    {
        return response()->json(
            $this->restaurantService->register($request), 201
        );
    }

    public function find($id)
    {
        return response()->json(
            $this->restaurantService->find($id), 200
        );
    }

    public function get_all()
    {
        return response()->json(
            $this->restaurantService->get_all(), 200
        );
    }

    public function update(Request $request)
    {
        return response()->json(
            $this->restaurantService->update($request), 200
        );
    }

    public function delete($id)
    {
        return response()->json(
            $this->restaurantService->delete($id), 204
        );
    }
}