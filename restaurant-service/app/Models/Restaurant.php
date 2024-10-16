<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RestaurantImage;
use App\Models\Review;

class Restaurant extends Model
{
    protected $fillable = [
        "name",
        "description",
        "user_id",
        "average_rating"
    ];

    public function restaurantImage()
    {
        return $this->hasMany(RestaurantImage::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }
}