<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    protected $fillable = [
        "user_id",
        "restaurant_id",
        "reservation_date",
        "reservation_time",
        "number_of_people",
        "status",
        "observation",
    ];

}