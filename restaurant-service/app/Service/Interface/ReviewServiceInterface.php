<?php

namespace App\Service\Interface;

use Illuminate\Http\Request;

interface ReviewServiceInterface
{
    public function register(Request $request);

    public function get_reviews_by_restaurant_id($restaurant_id);

    public function update(Request $request);

    public function delete(Request $request, $id);
}