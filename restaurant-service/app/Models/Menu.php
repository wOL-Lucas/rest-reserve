<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;
use App\Models\MenuItem;

class Menu extends Model
{
    protected $fillable = [
        "restaurant_id",
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function menuItem() 
    {
        return $this->hasMany(MenuItem::class);
    }
}