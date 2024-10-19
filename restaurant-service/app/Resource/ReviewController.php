<?php

namespace App\Resource;

use App\Service\Interface\ReviewServiceInterface;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    private $reviewService;

    public function __construct(ReviewServiceInterface $reviewService) 
    {
        $this->reviewService = $reviewService;
    }

    public function register(Request $request) 
    {
        return response()->json(
            $this->reviewService->register($request), 201
        );
    }   

    public function get_reviews_by_restaurant_id($restaurant_id) 
    {
        return response()->json(
            $this->reviewService->get_reviews_by_restaurant_id($restaurant_id), 200
        );
    }

    public function update(Request $request) 
    {
        return response()->json(
            $this->reviewService->update($request), 200
        );
    }

    public function delete($id) 
    {
        return response()->json(
            $this->reviewService->delete($id), 200
        );
    }
}