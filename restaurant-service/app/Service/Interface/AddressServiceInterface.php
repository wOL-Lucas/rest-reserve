<?php

namespace App\Service\Interface;

use Illuminate\Http\Request;

interface AddressServiceInterface
{
    public function register(Request $request);
}