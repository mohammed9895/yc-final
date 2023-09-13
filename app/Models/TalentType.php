<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TalentType extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];
    protected $guarded = [];

    public function talents()
    {
        return $this->hasMany(Talent::class);
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
