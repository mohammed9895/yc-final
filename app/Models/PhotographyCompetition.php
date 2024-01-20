<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotographyCompetition extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'images' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
