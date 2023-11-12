<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    function students(){
        return $this->belongsTo(Student::class,'student_id');
    }
    function staff(){
        return $this->belongsTo(Staff::class,'staff_id');
    }
}
