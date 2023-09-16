<?php

namespace App\Http\Livewire\Manjam;

use App\Models\Talent;
use App\Models\TalentRequest;
use Livewire\Component;

class Statistics extends Component
{
    public int $talents_count;
    public int $talent_type_count;
    public int $talent_request_count;

    public function mount()
    {
        $this->talents_count = Talent::where('status', 2)->count();
        $this->talent_type_count = \App\Models\TalentType::count();
        $this->talent_request_count = TalentRequest::count();
    }

    public function render()
    {
        return view('livewire.manjam.statistics');
    }
}
