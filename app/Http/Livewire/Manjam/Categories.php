<?php

namespace App\Http\Livewire\Manjam;

use App\Models\TalentType;
use Livewire\Component;

class Categories extends Component
{

    public function render()
    {
        $talent_types = TalentType::withCount('talents')->paginate(6);
        ray($talent_types);
        return view('livewire.manjam.categories', compact('talent_types'));
    }
}
