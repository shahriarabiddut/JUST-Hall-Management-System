<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodTimeHall extends Model
{
    use HasFactory;
    function food_time()
    {
        return $this->belongsTo(FoodTime::class, 'food_time_id');
    }
    function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}
