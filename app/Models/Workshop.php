<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Filament\Models\Contracts\FilamentUser;
use Guava\FilamentDrafts\Concerns\HasDrafts;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workshop extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = [];

    public $translatable = ['title', 'slug', 'description', 'conditions', 'cover', 'questions'];

    protected $casts = [
        'conditions' => 'array',
        'questions' => 'array',
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function path()
    {
        return $this->belongsTo(Path::class, 'path_id', 'id');
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendees::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluate::class);
    }
}
