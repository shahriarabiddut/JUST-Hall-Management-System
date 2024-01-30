<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocatedSeats extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'position',
    ];
    use HasFactory;
    function students()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }
    function rooms()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
