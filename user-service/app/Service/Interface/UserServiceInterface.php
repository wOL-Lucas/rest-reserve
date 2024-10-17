<?php

namespace App\Service\Interface;

use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function register(Request $request);
    public function list(Request $request);
    public function listById(Request $request);
}