<?php

namespace App\Service\Interface;

use Illuminate\Http\Request;

interface ReserveServiceInterface
{
    public function registerReserve(Request $request);
    public function cancelReserve(Request $request, $id);
    public function getAll(Request $request);
    public function findByUserId(Request $request, $userId);
    public function findByRestaurantId(Request $request, $restaurantId);
}
