<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    function foodtime()
    {
        return $this->belongsTo(FoodTime::class, 'food_time_id');
    }
    function food_time_hall()
    {
        return $this->belongsTo(FoodTimeHall::class, 'food_time_id', 'food_time_id');
    }
    function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}
