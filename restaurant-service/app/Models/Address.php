<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;

class Address extends Model
{
    protected $fillable = [
        "restaurant_id",
        "street",
        "zip_code",
        "neighborhood",
        "state",
        "city",
        "country",
        "complement",
        "number"
    ];

    public function restaurant() 
    {
        return $this->belongsTo(Restaurant::class);
    }
}