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
        return $this->reviewService->register($request);
    }   

    public function get_reviews_by_restaurant_id($restaurant_id) 
    {
        return $this->reviewService->get_reviews_by_restaurant_id($restaurant_id);
    }

    public function update(Request $request) 
    {
        return $this->reviewService->update($request);
    }

    public function delete(Request $request, $id) 
    {
        return $this->reviewService->delete($request, $id);
    }
}