<?php

namespace App\Service\Interface;

use Illuminate\Http\Request;

interface RestaurantServiceInterface
{
    public function register(Request $request);
}