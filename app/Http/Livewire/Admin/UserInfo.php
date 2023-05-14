<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class UserInfo extends ModalComponent
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.admin.user-info');
    }
}
