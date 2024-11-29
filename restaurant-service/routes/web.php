<?php

use App\Resource\AddressController;
use App\Resource\MenuController;
use App\Resource\RestaurantController;
use App\Resource\ReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('/restaurant')->group(function () {
    Route::post('/', [RestaurantController::class, 'register']);
    Route::get('/{id}', [RestaurantController::class, 'find']);
    Route::get('/', [RestaurantController::class, 'get_all']);
    Route::patch('/', [RestaurantController::class, 'update']);
    Route::delete('/{id}', [RestaurantController::class, 'delete']);
});

Route::prefix('/address')->group(function () {
    Route::post('/', [AddressController::class, 'register']);
    Route::patch('/', [AddressController::class, 'update']);
    Route::delete('/{id}', [AddressController::class, 'delete']);
    Route::get('/restaurant/{restaurant_id}', [AddressController::class, 'find_by_restaurant_id']);
});

Route::prefix('/review')->group(function () {
    Route::post('/', [ReviewController::class, 'register']);
    Route::get('/restaurant/{restaurant_id}', [ReviewController::class, 'get_reviews_by_restaurant_id']);
    Route::patch('/', [ReviewController::class, 'update']);
    Route::delete('/{id}', [ReviewController::class, 'delete']);
});

Route::prefix('/menu')->group(function () {
    Route::post('/', [MenuController::class, 'register']);
    Route::delete('/{id}', [MenuController::class, 'delete']);
    Route::delete('/item/{id}', [MenuController::class, 'deleteItem']);
    Route::post('/item', [MenuController::class, 'addItem']);
});