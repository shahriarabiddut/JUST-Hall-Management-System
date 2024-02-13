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
        'hall_id',
    ];

    public $timestamps = true;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->setCreatedAt($model->freshTimestamp()->setTimezone('GMT+6'));
        });

        static::updating(function ($model) {
            $model->setUpdatedAt($model->freshTimestamp()->setTimezone('GMT+6'));
        });
    }
    use HasFactory;
    function students()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }
    function rooms()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}
