<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;
    function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
