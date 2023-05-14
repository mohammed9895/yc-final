<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Workshop;

class WorkshopsList extends Component
{
    public $workshops;

    public function render()
    {
        $this->workshops = Workshop::all()->where('status', '=', 1);
        return view('livewire.user.workshops-list');
    }
}
