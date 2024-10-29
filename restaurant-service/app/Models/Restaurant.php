<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RestaurantImage;
use App\Models\Review;
use App\Models\Address;

class Restaurant extends Model
{
    protected $fillable = [
        "name",
        "description",
        "user_id",
        "average_rating"
    ];

    public function restaurantImages()
    {
        return $this->hasMany(RestaurantImage::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
}