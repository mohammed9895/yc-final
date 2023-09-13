<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'schedule',
        'workshop_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
    ];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendees::class);
    }
}
