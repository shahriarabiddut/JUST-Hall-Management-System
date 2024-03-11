<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomIssue extends Model
{
    use HasFactory;
    function allocatedseat()
    {
        return $this->belongsTo(AllocatedSeats::class, 'allocated_seat_id');
    }
    function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
    function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }
    function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
