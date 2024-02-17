<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;
    function provost()
    {
        return $this->hasMany(Staff::class, 'hall_id')->where('type', 'provost');
    }
    function aprovost()
    {
        return $this->hasMany(Staff::class, 'hall_id')->where('type', 'aprovost');
    }
    function admin()
    {
        return $this->belongsTo(Admin::class, 'createdby');
    }
}
