<?php

namespace App\Http\Livewire\Manjam;

use App\Models\TalentRequest;
use LivewireUI\Modal\ModalComponent;

class TalentRequestModel extends ModalComponent
{
    public int $talent_id;
    public int $user_id;
    public string $reason;

    public function mount(int $talent_id)
    {
        $this->talent_id = $talent_id;
        $this->user_id = auth()->id();
    }

    public function render()
    {
        return view('livewire.manjam.talent-request-model');
    }

    public function request()
    {
        $talent_request = TalentRequest::where('user_id', $this->user_id)->where('talent_id',
            $this->talent_id)->count();
        if ($talent_request > 0) {
            session()->flash('error', 'You already have sent request');
        } elseif (!auth()->id()) {
            session()->flash('error', 'You have to be logged in to send request');
        } else {
            TalentRequest::create([
                'user_id' => $this->user_id,
                'talent_id' => $this->talent_id,
                'reason' => $this->reason,
            ]);
            session()->flash('success', 'Talent request have been sent successfully');
        }
    }
}
