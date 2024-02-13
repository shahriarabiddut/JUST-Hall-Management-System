<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $attributes = ['ms' => '0',];
    protected $fillable = ['rollno', 'name', 'email', 'password', 'mobile', 'address', 'photo', 'dept', 'session', 'hall_id'];
    public $table = 'users';
    function rooms()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    function allocatedRoom()
    {
        return $this->hasOne(AllocatedSeats::class, 'user_id');
    }
    function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}
