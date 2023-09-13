<?php

namespace App\Http\Livewire\Manjam;

use App\Models\Talent;
use Livewire\Component;

class Talents extends Component
{
    public $talents_1;

    public function render()
    {
        $this->talents_1 = Talent::paginate(4)->where('status', 2);
//        $talents_2 = Talent::paginate(4)->where('status', 2);
//        $talents_3 = Talent::paginate(4)->where('status', 2);
//        $talents_4 = Talent::paginate(4)->where('status', 2);
        return view('livewire.manjam.talents');
    }
}
