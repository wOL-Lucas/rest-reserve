<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;

class Review extends Model
{
    protected $fillable = [
        "user_id",
        "user_name",
        "restaurant_id",
        "review",
        "rating"
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}