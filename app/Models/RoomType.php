<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'details', 'price'];
    function roomtypeimages(){
        return $this->hasMany(RoomTypeImage::class,'room_type_id');
    }
}
