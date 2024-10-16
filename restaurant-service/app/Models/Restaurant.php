<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RestaurantImage;

class Restaurant extends Model
{
    protected $fillable = [
        "name",
        "user_id",
        "average_rating"
    ];

    public function restaurantImage()
    {
        return $this->hasMany(RestaurantImage::class);
    }
}