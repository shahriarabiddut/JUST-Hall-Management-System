<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoFoodOrder extends Model
{
    use HasFactory;
    function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
    function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }
}
