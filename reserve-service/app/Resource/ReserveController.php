<?php

namespace App\Resource;

use App\Service\Interface\ReserveServiceInterface;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    private $reserveService;

    public function __construct(ReserveServiceInterface $reserveService)
    {
        $this->reserveService = $reserveService;
    }

    public function registerReserve(Request $request)
    {
        return response()->json($this->reserveService->registerReserve($request), 201);
    }

    public function cancelReserve($id)
    {
        return response()->json($this->reserveService->cancelReserve($id), 200);
    }

    public function findByUserId($userId)
    {
        return response()->json($this->reserveService->findByUserId($userId), 200);
    }

    public function findByRestaurantId($restaurantId)
    {
        return response()->json($this->reserveService->findByRestaurantId($restaurantId), 200);
    }
}