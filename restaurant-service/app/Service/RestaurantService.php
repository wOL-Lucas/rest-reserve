<?php

namespace App\Service;

use App\Models\Restaurant;
use App\Service\Interface\RestaurantServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantService implements RestaurantServiceInterface
{
    private $restaurantRepository;

    function __construct(Restaurant $restaurantRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
    }

    public function register(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|int',
            'address.street' => 'required|string',
            'address.zip_code' => 'required|string|max:8',
            'address.neighborhood' => 'required|string',
            'address.state' => 'required|string|max:2',
            'address.city' => 'required|string',
            'address.country' => 'required|string',
            'address.complement' => 'nullable|string',
            'address.number' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $restaurant = $this->restaurantRepository->create(
            $request->only([
                'name',
                'description',
                'user_id'
            ])
        );

        $address = $request->input('address');
        $restaurant->address()->create($address);
        
        return $restaurant;
    }
}