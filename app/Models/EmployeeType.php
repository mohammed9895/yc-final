<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeType extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
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
