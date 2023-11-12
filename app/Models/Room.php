<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'room_type_id'];
    function RoomType(){
        return $this->belongsTo(RoomType::class,'room_type_id');
    }
    function allocatedseats(){
        return $this->hasMany(AllocatedSeats::class,'room_id');
    }
}
