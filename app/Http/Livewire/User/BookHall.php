<?php

namespace App\Http\Livewire\User;

use App\Models\Hall;
use Livewire\Component;

class BookHall extends Component
{
    public $halls;
    public function mount()
    {
        $halls = Hall::all()->where('status', 1);
        $this->halls = $halls;
    }
    public function render()
    {
        return view('livewire.user.book-hall');
    }
}
