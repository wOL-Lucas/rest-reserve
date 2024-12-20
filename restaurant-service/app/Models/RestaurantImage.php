<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;

class RestaurantImage extends Model
{
    protected $fillable = [
        "restaurant_id",
        "image_url",
        "is_main"
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}