<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Workshop;

class WorkshopsList extends Component
{
    public $workshops;
    public $path_id;

    public function mount($path_id)
    {
        $this->$path_id = $path_id;
    }

    public function render()
    {
        $this->workshops = Workshop::all()->where('status', '=', 1)->where('path_id', $this->path_id);
        return view('livewire.frontend.workshops-list');
    }
}
