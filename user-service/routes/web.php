<?php

use App\Resource\AuthController;
use App\Resource\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UserController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);