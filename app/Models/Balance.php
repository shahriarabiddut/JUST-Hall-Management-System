<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;
    function students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}
