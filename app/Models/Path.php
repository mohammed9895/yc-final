<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Path extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = [];

    public $translatable = ['name', 'description', 'icon'];


    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }
}
