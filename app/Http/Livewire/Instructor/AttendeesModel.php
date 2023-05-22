<?php

namespace App\Http\Livewire\Instructor;

use DateTime;
use Wizard\Step;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\Hall;
use App\Models\Slot;
use App\Models\Event;
use App\Models\Booking;
use Livewire\Component;
use App\Models\Workshop;
use App\Models\Attendees;
use Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
use Forms\Components\MarkdownEditor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use LivewireUI\Modal\ModalComponent;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Config;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class AttendeesModel extends ModalComponent implements Forms\Contracts\HasForms
{
    use InteractsWithForms;
    public $workshop;

    public $slots;
    public $slot_id = 0;
    public $attendance;

    public $attendanceCount;


    public $users = [];

    public $step;

    public function mount(Workshop $workshop)
    {
        $this->step = 1;
        $this->workshop = $workshop;
        $this->slots = Slot::where('start_date', '>=', date('Y-m-d'))->where('workshop_id', '=', $this->workshop->id)->with('bookings')->get();
    }
    public function moreStep()
    {
        $slot = Slot::select('start_date')->where('id', $this->slot_id)->first();
        if (now() < $slot->start_date) {
            $this->closeModal();
            Notification::make()
                ->title('This workshop has not started yet!')
                ->danger()
                ->send();
        } else {
            $this->step++;
        }
    }

    public function lessStep()
    {
        $this->step--;
    }

    public function create()
    {
        foreach ($this->users as $key => $value) {
            Attendees::create([
                'user_id' => $key,
                'slot_id' => $this->slot_id,
                'attendance' => $value,
                'date' => new DateTime('now')
            ]);
        }
        Notification::make()
            ->title('Attendance has been taken successfully!')
            ->success()
            ->send();
        $this->closeModal();
    }

    public function update()
    {
        foreach ($this->users as $key => $value) {
            Attendees::where('user_id', $key)->whereDate('created_at', Carbon::today())->update(['attendance' => $value]);
        }
        Notification::make()
            ->title('Attendance has been updated successfully!')
            ->success()
            ->send();
        $this->closeModal();
    }
    public function render()
    {
        $this->attendance = Booking::where('slot_id', '=', $this->slot_id)->where('status', '=', 2)->get();
        $this->attendanceCount = Attendees::where('slot_id', '=', $this->slot_id)->whereDate('created_at', Carbon::today())->get();
        return view('livewire.instructor.attendees-model');
    }
}
