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
        return $this->restaurantService->register($request);
    }

    public function find($id)
    {
        return $this->restaurantService->find($id);
    }

    public function get_all()
    {
        return $this->restaurantService->get_all();
    }

    public function update(Request $request)
    {
        return $this->restaurantService->update($request);
    }

    public function delete(Request $request, $id)
    {
        return $this->restaurantService->delete($request, $id);
    }
}