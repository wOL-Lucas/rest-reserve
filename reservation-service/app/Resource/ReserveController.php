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
        return $this->reserveService->registerReserve($request);
    }

    public function cancelReserve(Request $request, $id)
    {
        return $this->reserveService->cancelReserve($request, $id);
    }

    public function findByUserId(Request $request, $userId)
    {
        return $this->reserveService->findByUserId($request, $userId);
    }

    public function findByRestaurantId(Request $request, $restaurantId)
    {
        return $this->reserveService->findByRestaurantId($request, $restaurantId);
    }

    public function getAll(Request $request)
    {
        return $this->reserveService->getAll($request);
    }
}
