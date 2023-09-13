<?php

namespace App\Http\Controllers\Frontend\Manjam;

use App\Http\Controllers\Controller;
use App\Models\TalentType;

class CategoriesController extends Controller
{
    public function index()
    {
        $talent_types = \App\Models\TalentType::withCount('talents')->get();
        return view('frontend.manjam.categories', compact('talent_types'));
    }

    public function show(TalentType $talentType)
    {
        $talents = $talentType::with('talents');
        return view('frontend.manjam.category', compact('talentType'));
    }
}
