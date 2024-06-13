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
    function student()
    {
        return $this->belongsTo(Student::class, 'rollno', 'rollno');
    }
    function food()
    {
        return $this->belongsTo(Food::class, 'food_name', 'food_name');
    }
    function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}
