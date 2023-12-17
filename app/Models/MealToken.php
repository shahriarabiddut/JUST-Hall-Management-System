<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealToken extends Model
{
    use HasFactory;
    function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
