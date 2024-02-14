<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    function food()
    {
        return $this->belongsTo(Food::class, 'food_item_id');
    }
    function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    function token()
    {
        return $this->hasOne(MealToken::class, 'order_id', 'id');
    }
}
