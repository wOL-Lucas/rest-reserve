<?php

use App\Resource\AuthController;
use App\Resource\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('', [UserController::class, 'register']);
    Route::get('', [UserController::class, 'list']);
    Route::get('/{id}', [UserController::class, 'listById']);
});

Route::post('/login', [AuthController::class, 'login']);