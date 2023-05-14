<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AboutPageSetting extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = [];

    public $translatable = ['title', 'statistics'];

    protected $casts = [
        'statistics' => 'array',
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
