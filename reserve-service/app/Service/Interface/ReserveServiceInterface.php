<?php

namespace App\Service\Interface;

use Illuminate\Http\Request;

interface ReserveServiceInterface
{
    public function registerReserve(Request $request);
    public function cancelReserve($id);
    public function findByUserId($userId);
    public function findByRestaurantId($restaurantId);
}