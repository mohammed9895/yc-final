<?php

namespace App\Http\Livewire\Instructor;

use Livewire\Component;
use App\Models\Workshop;
use Illuminate\Support\Facades\Auth;

class MyWorkshopsList extends Component
{
    public $workshops;

    public function render()
    {
        $this->workshops = Workshop::all()->where('status', '=', 1)->where('user_id', Auth::id());
        return view('livewire.instructor.my-workshops-list');
    }
}
