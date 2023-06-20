<?php

namespace App\Http\Livewire\User;

use App\Models\Place;
use Livewire\Component;
use App\Models\Workshop;

class WorkshopsList extends Component
{
    public $workshops;
    public $places;

    public $place = '';

    public function mount() {
        $this->places = Place::all();
        $this->workshops = Workshop::all()->where('status', '=', 1);
    }


    public function render()
    {
        return view('livewire.user.workshops-list');
    }

    public function change_place(){
        $this->workshops = Workshop::all()->where('place_id', $this->place)->where('status', '=', 1);
    }
}
