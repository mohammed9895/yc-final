<?php

namespace App\Http\Livewire\Frontend;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public $fullname;
    public $phone;
    public $email;
    public $subject;
    public $message;

    protected $rules = [
        'fullname' => 'required',
        'phone' => 'required|numeric',
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required'
    ];

    public function render()
    {
        return view('livewire.frontend.contact-form');
    }

    public function submitForm()
    {
        $this->validate();
        Mail::to('info@yc.om')->send(new ContactMail($this->fullname, $this->phone, $this->email, $this->subject,
            $this->message));
        session()->flash('message', 'Email Sent Successfuly');
        $this->reset();
    }
}
