<?php

namespace App\Http\Livewire\User;

use Closure;
use Carbon\Carbon;

use Filament\Forms;
use App\Models\Hall;
use App\Models\Slot;
use App\Models\Event;
use Livewire\Component;
use App\Models\Workshop;
use Spatie\CalendarLinks\Link;
use Forms\Components\TextInput;
use App\Notifications\SmsMessage;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Forms\Components\MarkdownEditor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use LivewireUI\Modal\ModalComponent;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Config;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;

class BookHallModel extends ModalComponent implements Forms\Contracts\HasForms
{
    use InteractsWithForms;
    public $hall;


    public $title = '';
    public $user_id;
    public $hall_id;
    public $reasone = '';
    public $start = '';
    public $end = '';
    public $todayDate = '';

    public $timings;

    public $slots = [];

    public $counter = 0;

    public $slotsTimings = ['08:00 AM', '08:30 AM', '09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM', '01:00 PM', '01:30 PM', '02:00 PM', '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM', '05:00 PM', '05:30 PM', '06:00 PM', '06:30 PM', '07:00 PM', '07:30 PM', '08:00 PM', '08:30 PM', '09:00 PM', '09:30 PM', '10:00 PM'];

    public function mount(Hall $hall)
    {
        $this->hall = $hall;
        $this->user_id = Auth::id();
        $this->hall_id = $this->hall->id;
        $this->form->fill();
    }

    public function toggleSlot($timing, $isSelected)
    {
        if ($isSelected) {
            $this->counter++;
        } else {
            $this->counter--;
        }
    }


    protected function getFormSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->label(__('Title'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('reasone')
                        ->required()
                        ->label(__('reasone'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('pax')->required()->numeric()->label(__('pax')),
                    Forms\Components\DatePicker::make('date')
                        ->withoutSeconds()
                        ->label(__('filament::yc.date'))
                        ->minDate(now()->today())
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set, $state) => $set('todayDate', $state))
                        ->weekStartsOnSunday()
                        ->required(),
                ])
        ];
    }


    public function create(): void
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = $this->user_id;
        $orginal['hall_id'] = $this->hall_id;

        $startTime = min($this->slots);
        $endTime = max($this->slots);

        $startDateAndTime = Carbon::parse($orginal['date'] . $startTime);
        $endDateAndTime = Carbon::parse($orginal['date'] . $endTime);

        $orginal['start'] = $startDateAndTime;

        if ($endTime != '10:00 PM') {
            $orginal['end'] = $endDateAndTime->addMinutes(30);
        } else {
            $orginal['end'] = $endDateAndTime;
        }

        $events = Event::where('hall_id', $this->hall_id)
            ->where('start', '<', $endDateAndTime)
            ->where('end', '>', $startDateAndTime)
            ->count();

        $event_date = Carbon::createFromFormat('Y-m-d', $orginal['date']);

        $user_event_today = Event::whereDate('start', $event_date)
            ->where('status', '!=', 3)
            ->count();

        if ($events > 0) {
            session()->flash('error', __('This booking timing is not available!'));
            Notification::make()
                ->title(__('This booking timing is not available!'))
                ->warning()
                ->send();
        } elseif (!$this->areSlotsConsecutive()) {
            Notification::make()
                ->title(__('The selected slots are not consecutive!'))
                ->warning()
                ->send();
        } elseif($user_event_today >= 1) {
            Notification::make()
                ->title(__('You Can Book just one booking per day'))
                ->warning()
                ->send();
        } else {
            if (Event::create([
                'title' => $orginal['title'],
                'user_id' => $orginal['user_id'],
                'hall_id' => $orginal['hall_id'],
                'reasone' => $orginal['reasone'],
                'pax' => $orginal['pax'],
                'start' => $startDateAndTime,
                'end' => $endDateAndTime
            ])) {
                $this->closeModal();
                Notification::make()
                    ->title(__('You have booked hall successfuly!'))
                    ->success()
                    ->persistent()
                    // ->actions([
                    //     Action::make('add to Calender')
                    //         ->button()
                    //         ->url($link->ics())
                    // ])
                    ->send();

                $sms = new SmsMessage;
                $user = auth()->user();
                if ($user->preferred_language == 'ar') {
                    $sms->to($user->phone)
                        ->message('تم استلام طلبك حجزك ل ' . $this->hall->name . ' سوف يتم تأكيد حجزك قريبًا')
                        ->lang($user->preferred_language)
                        ->send();
                } else {
                    $sms->to($user->phone)
                        ->message("Your reservation has been received for " . $this->hall->name . ", It will be confirmed soon.")
                        ->lang($user->preferred_language)
                        ->send();
                }
            }
        }
    }

    public function areSlotsConsecutive()
    {
        // Sort the slots in ascending order
        sort($this->slots);

        for ($i = 0; $i < count($this->slots) - 1; $i++) {
            $currentSlot = Carbon::createFromFormat('h:i A', $this->slots[$i]);
            $nextSlot = Carbon::createFromFormat('h:i A', $this->slots[$i + 1]);
            $difference = $currentSlot->diffInMinutes($nextSlot);

            // Check if the difference between two slots is not equal to 30 (or your slot interval)
            if ($difference != 30) {
                session()->flash('error', __('The selected slots are not consecutive!'));
                return false;
            }
        }

        return true;
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'date') {
            $date = Carbon::parse($this->date);
            $dayOfWeek = $date->dayOfWeek;

            if ($dayOfWeek === Carbon::FRIDAY) {
                // Assign your modified slots for Friday
                $this->slotsTimings = ['01:00 PM', '01:30 PM', '02:00 PM', '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM', '05:00 PM', '05:30 PM', '06:00 PM', '06:30 PM', '07:00 PM', '07:30 PM', '08:00 PM', '08:30 PM', '09:00 PM', '09:30 PM', '10:00 PM'];
            } else {
                // Assign your default slots for other days
                $this->slotsTimings = ['08:00 AM', '08:30 AM', '09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM', '01:00 PM', '01:30 PM', '02:00 PM', '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM', '05:00 PM', '05:30 PM', '06:00 PM', '06:30 PM', '07:00 PM', '07:30 PM', '08:00 PM', '08:30 PM', '09:00 PM', '09:30 PM', '10:00 PM'];
            }
        }
    }


    public function render()
    {

        $events = Event::where('hall_id', $this->hall_id)
            ->whereDate('start', '=', $this->todayDate)
            ->where('status', 1)
            ->get();

        $reservedTimings = [];

        foreach ($events as $event) {
            $reservedTimings[] = [
                'start' => Carbon::parse($event->start)->format('h:i A'),
                'end' => Carbon::parse($event->end)->format('h:i A')
            ];
        }

        $this->timings = $reservedTimings;

        return view('livewire.user.book-hall-model');
    }
}
