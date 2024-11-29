<?php

namespace App\Service\Interface;

use Illuminate\Http\Request;

interface AddressServiceInterface
{
    public function register(Request $request);

    public function update(Request $request);

    public function delete(Request $request, $id);

    public function find_by_restaurant_id(Request $request, $restaurant_id);
}