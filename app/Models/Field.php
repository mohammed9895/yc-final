<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Field extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = [];

    public $translatable = ['name'];

    public function company()
    {
        return $this->belongsTo(Compnay::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancers::class);
    }
}
