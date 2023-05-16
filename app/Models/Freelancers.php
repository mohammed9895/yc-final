<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Freelancers extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'profile_file' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id', 'id');
    }
}
