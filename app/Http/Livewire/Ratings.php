<?php

namespace App\Http\Livewire;

use App\Models\Rating;
use Livewire\Component;

class Ratings extends Component
{
    public function render()
    {
        return view('livewire.ratings')->layout('layouts.book');
    }

    public function submitRating($rating)
    {
        // Save the rating
        Rating::create([
            'rating' => $rating
        ]);

        session()->flash('rating', 'شكراً لتقييمك');
    }
}
