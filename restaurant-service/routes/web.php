<?php

use App\Resource\AddressController;
use App\Resource\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::post('/restaurant', [RestaurantController::class, 'register']);

Route::post('/address', [AddressController::class, 'register']);