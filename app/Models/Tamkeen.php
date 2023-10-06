<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamkeen extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'social_media_accounts' => 'array',
        'other_skill' => 'array',
        'clients_worked_with' => 'array',
        'achievements' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
