<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Support extends Model
{
    public $timestamps = true;
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->setCreatedAt($model->freshTimestamp()->setTimezone('GMT+6'));
    //     });

    //     static::updating(function ($model) {
    //         $model->setUpdatedAt($model->freshTimestamp()->setTimezone('GMT+6'));
    //     });
    // }

    use HasFactory;
    function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }
    function staff()
    {
        return $this->belongsTo(Staff::class, 'repliedby');
    }
    function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}
