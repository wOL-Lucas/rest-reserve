<?php

namespace App\Service;

use App\Models\Restaurant;
use App\Models\Review;
use App\Service\Interface\ReviewServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReviewService implements ReviewServiceInterface
{
    private $reviewRepository; 
    private $restaurantRepository;

    public function __construct(Review $reviewRepository, Restaurant $restaurantRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->restaurantRepository = $restaurantRepository;
    }


    public function register(Request $request)
    {

        if (!$this->validatePermission($request, 'user')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }
        
        $restaurant = $this->restaurantRepository->find($request->restaurant_id);

        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        $review = $this->reviewRepository->create($request->all());

        $this->updateRestaurantRating($restaurant->id);

        return response()->json($review, 201);
    }

    public function get_reviews_by_restaurant_id($restaurant_id)
    {
        return response()->json($this->reviewRepository->where('restaurant_id', $restaurant_id)->get(), 200);
    }

    public function update(Request $request)
    {

        if (!$this->validatePermission($request, 'user')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $review = $this->reviewRepository->find($request->id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->update($request->all());

        $this->updateRestaurantRating($review->restaurant_id);

        return response()->json($review, 200);
    }

    public function delete(Request $request, $id)
    {

        if (!$this->validatePermission($request, 'user')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $review = $this->reviewRepository->find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->delete();

        $this->updateRestaurantRating($review->restaurant_id);

        return response()->json(['message' => 'Review deleted'], 200);
    }

    private function updateRestaurantRating($restaurant_id)
    {
        $restaurant = $this->restaurantRepository->find($restaurant_id);
        $reviews = $this->reviewRepository->where('restaurant_id', $restaurant_id)->get();
        if ($reviews->count() > 0) {
            $restaurant->average_rating = $reviews->avg('rating');
        } else {
            $restaurant->average_rating = 0;
        }
        
        $restaurant->save();
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