<?php

namespace App\Service\Interface;

use Illuminate\Http\Request;

interface RestaurantServiceInterface
{
    public function register(Request $request);
    
    public function find($id);

    public function get_all();

    public function update(Request $request);

    public function delete(Request $request, $id);
}