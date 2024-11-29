<?php

use App\Resource\ReserveController;
use Illuminate\Support\Facades\Route;

Route::post('/reserves', [ReserveController::class, 'registerReserve']);
Route::put('/reserves/{id}', [ReserveController::class, 'cancelReserve']);
Route::get('/reserves/user/{userId}', [ReserveController::class, 'findByUserId']);
Route::get('/reserves/restaurant/{restaurantId}', [ReserveController::class, 'findByRestaurantId']);
