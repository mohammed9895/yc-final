<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TalentRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function talent(): belongsTo
    {
        return $this->belongsTo(Talent::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
