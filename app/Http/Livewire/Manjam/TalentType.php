<?php

namespace App\Http\Livewire\Manjam;

use Livewire\Component;

class TalentType extends Component
{
    public \App\Models\TalentType $talent_type;

    public function mount($talent_type)
    {
        $this->talent_type = $talent_type;
    }

    public function render()
    {
        return view('livewire.manjam.talent-type');
    }
}
