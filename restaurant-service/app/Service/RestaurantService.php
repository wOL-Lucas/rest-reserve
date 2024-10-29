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
    
        $restaurant->restaurantImages = $this->registerImages($request, $restaurant);

        return $restaurant;
    }

    public function find($id)
    {
        $restaurant = $this->restaurantRepository->with(['address', 'review', 'restaurantImages'])->find($id);
        $formatedImages = [];

        foreach($restaurant->restaurantImages as $image) {
            $formatedImages[] = [
                'image_url' => url('storage/' . $image->image_url),
                'is_main' => $image->is_main
            ];
        }
        unset ($restaurant->restaurantImages);
        $restaurant->restaurant_images = $formatedImages;
        return $restaurant;
    }

    public function get_all()
    {
        $restaurants = $this->restaurantRepository->with('restaurantImages')->get();

        foreach ($restaurants as $restaurant) {
            $mainImage = $restaurant->restaurantImages()->where('is_main', true)->first();
            $restaurant->main_image_url = url('storage/' . $mainImage->image_url);
        }
        foreach ($restaurants as $restaurant) {
            unset($restaurant->restaurantImages);
        }
        return $restaurants;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $restaurant = $this->restaurantRepository->find($request->id);
        $restaurant->update($request->all());
        
        return $restaurant;
    }

    public function delete($id)
    {
        return $this->restaurantRepository->destroy($id);
    }

    private function registerImages(Request $request, Restaurant $restaurant)
    {
        $registeredImages = [];

        $this->validateImage($request, 'main_image');
        $imagePath = $this->getImagePath($request, 'main_image');

        $restaurant->restaurantImages()->create([
            'image_url' => $imagePath,
            'is_main' => true
        ]);

        $registeredImages[] = [
            'image_url' => url('storage/' . $imagePath),
            'is_main' => true
        ];

        $expectedFields = [
            'name', 
            'description',
            'user_id',
            'main_image',
            'address'
        ];
        $additionalFields = array_diff_key($request->all(), array_flip($expectedFields));

        if (!empty($additionalFields)) {
            foreach ($additionalFields as $key => $value) {
                $this->validateImage($request, $key);
                $imagePath = $this->getImagePath($request, $key);

                $restaurant->restaurantImages()->create([
                    'image_url' => $imagePath,
                    'is_main' => false
                ]);

                $registeredImages[] = [
                    'image_url' => url('storage/' . $imagePath),
                    'is_main' => false
                ];
            }
        }

        return $registeredImages;
    }

    private function validateImage(Request $request, String $key) 
    {
        $validator = Validator::make($request->all(), [
            $key => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

    }

    private function getImagePath(Request $request, String $key)
    {
        $imagePath = null;
        if ($request->hasFile($key)) {
            $image = $request->file($key);
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('restaurant_images', $imageName, 'public');
        }

        return $imagePath;
    }
}