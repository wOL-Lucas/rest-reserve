<?php

namespace App\Service\Interface;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function login(Request $request);
    public function validateToken(Request $request);
}