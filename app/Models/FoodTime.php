<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodTime extends Model
{
    use HasFactory;
    function food()
    {
        return $this->hasMany(Food::class, 'food_time_id');
    }
    function hall()
    {
        return $this->hasMany(FoodTimeHall::class, 'hall_id');
    }
}
