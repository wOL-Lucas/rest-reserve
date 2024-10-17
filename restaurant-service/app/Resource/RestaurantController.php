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
}