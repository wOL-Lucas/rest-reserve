<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

class MenuItem extends Model
{
    protected $fillable = [
        "menu_id",
        "name",
        "description",
        "price",
        "image_url"
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}