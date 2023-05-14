<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hall extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = [];

    public $translatable = ['name', 'description', 'conditions'];

    protected $casts = [
        'conditions' => 'array',
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
