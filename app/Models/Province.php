<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function state()
    {
        return $this->hasMany(State::class);
    }

    public function users()
    {
        return $this->hasOne(User::class);
    }

    public function trainingApplication()
    {
        return $this->hasOne(TrainingApplication::class);
    }
}
