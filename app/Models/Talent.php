<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Talent extends Model
{
    use HasFactory;

    protected $table = 'talents';

    protected $guarded = [];

    protected $casts = [
        'social_media_links' => 'array',
        'certificates' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function talentType()
    {
        return $this->belongsTo(TalentType::class, 'talent_type_id', 'id');
    }

    public function talent_requests(): HasMany
    {
        return $this->hasMany(TalentRequest::class);
    }
}
