<?php

namespace App\Service;

use App\Models\Restaurant;
use App\Models\Review;
use App\Service\Interface\ReviewServiceInterface;
use Illuminate\Http\Request;

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
        $restaurant = $this->restaurantRepository->find($request->restaurant_id);

        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        $review = $this->reviewRepository->create($request->all());

        $this->updateRestaurantRating($restaurant->id);

        return $review;
    }

    public function get_reviews_by_restaurant_id($restaurant_id)
    {
        return $this->reviewRepository->where('restaurant_id', $restaurant_id)->get();
    }

    public function update(Request $request)
    {
        $review = $this->reviewRepository->find($request->id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->update($request->all());

        $this->updateRestaurantRating($review->restaurant_id);

        return $review;
    }

    public function delete($id)
    {
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
        $restaurant->average_rating = $reviews->avg('rating');
        
        $restaurant->save();
    }   
}