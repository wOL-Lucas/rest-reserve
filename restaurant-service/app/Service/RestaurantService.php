<?php

namespace App\Service;

use App\Models\Restaurant;
use App\Service\Interface\RestaurantServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        Log::info('Register method called');

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

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
            'address.number' => 'required|int',
            // 'main_image' => 'required'
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

        // $this->registerImages($request, $restaurant);

        return response()->json($this->restaurantRepository->find($restaurant->id)->load(['address', 'restaurantImages']), 201);
    }


    public function find($id)
    {
        $restaurant = $this->restaurantRepository->with(['address', 'review', 'restaurantImages', 'menu.menuItem'])->find($id);

        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        return response()->json($restaurant, 200);
    }


    public function get_all()
    {
        $restaurants = $this->restaurantRepository->with('restaurantImages')->get();

        // foreach ($restaurants as $restaurant) {
        //     $restaurant->main_image_url = $restaurant->restaurantImages()->where('is_main', true)->first()->image_url;
        //     unset($restaurant->restaurantImages);
        // }

        return response()->json($restaurants, 200);
    }


    public function update(Request $request)
    {

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

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

        return response()->json($restaurant, 200);
    }


    public function delete(Request $request, $id)
    {

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $this->restaurantRepository->destroy($id);

        return response()->json(['message' => 'Restaurant deleted'], 200);
    }


    private function registerImages(Request $request, Restaurant $restaurant)
    {

        $this->validateImage($request, 'main_image');
        $imagePath = $this->getImagePath($request, 'main_image');

        $restaurant->restaurantImages()->create([
            'image_url' => $imagePath ? url('storage/' . $imagePath) : null,
            'is_main' => true
        ]);

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
                    'image_url' => $imagePath ? url('storage/' . $imagePath) : null,
                    'is_main' => false
                ]);
            }
        }

        return $restaurant;
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

    private function validatePermission(Request $request, String $requiredRole)
    {

        Log::info('validatePermission method called');

        $token = trim($request->bearerToken());

        Log:info($token);

        if (!$token) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $response = Http::post('http://user-service:8081/validate-token', [
            'token' => $token,
            'requiredRole' => $requiredRole
        ]);

        Log::info('Response from user-service: ' . $response->body());

        $status = $response->json()['message'];

        Log::info($status);

        return $status === 'AUTHORIZED';
    }
}
