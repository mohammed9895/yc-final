<?php

namespace App\Http\Livewire\User;

use Carbon\Carbon;
use Filament\Forms;

use App\Models\Hall;
use App\Models\Event;
use App\Models\Slot;
use App\Models\Workshop;
use Livewire\Component;
use Spatie\CalendarLinks\Link;
use Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
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

    // public $data;


    public function mount(Hall $hall)
    {
        $this->hall = $hall;
        $this->user_id = Auth::id();
        $this->hall_id = $this->hall->id;
        $this->form->fill();
    }
    protected function getFormSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('reasone')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make('start')
                        ->withoutSeconds()
                        ->minDate(now())
                        ->minutesStep(30)
                        ->weekStartsOnSunday()
                        ->reactive()
                        ->required(),
                    Forms\Components\DateTimePicker::make('end')
                        ->withoutSeconds()
                        ->minDate(function (callable $get) {
                            return Carbon::parse($get('start'))->addHours(1);
                        })
                        ->maxDate(function (callable $get) {
                            return Carbon::parse($get('start'))->addHours(4);
                        })
                        ->weekStartsOnSunday()
                        ->minutesStep(30)
                        ->required(),
                ])
        ];
    }


    public function create(): void
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = $this->user_id;
        $orginal['hall_id'] = $this->hall_id;

        $events = Event::where('hall_id', $this->hall_id)
            ->where('start', '<', $orginal['end'])
            ->where('end', '>', $orginal['start'])
            ->count();

        // $slots = Workshop::where('hall_id', $this->hall_id)
        //     ->with('slots')
        //     ->where('slot.start_date', '<', $orginal['end'])
        //     ->where('slot.end_date', '>', $orginal['start'])
        //     ->where('slot.start_time', '<', $orginal['end'])
        //     ->where('slot.end_time', '>', $orginal['start'])
        //     ->count();
        // dd($slots);
        if ($events > 0) {
            Notification::make()
                ->title('This event timing is not available!')
                ->warning()
                ->send();
        } else {
            if (Event::create($orginal)) {
                $from = Carbon::parse($orginal['start']);
                $to = Carbon::parse($orginal['end']);
                $link = Link::create($orginal['title'], $from, $to)
                    ->description($orginal['reasone'])
                    ->address('Youth Center ' . $this->hall->name);
                $this->closeModal();
                Notification::make()
                    ->title('You have booked your seat!')
                    ->success()
                    ->persistent()
                    ->actions([
                        Action::make('add to Calender')
                            ->button()
                            ->url($link->ics())
                    ])
                    ->send();

                $messageSms = '';

                if (Config::get('app.locale') == 'ar') {
                    $messageSms = "تم استلام طلبك حجزك ل " . $this->hall->name . ' سوف يتم تأكيد حجزك قريبًا';
                } else {
                    $messageSms = "Your reservation has been received for " . $this->hall->name . ', It will be confirmed soon.';
                }

                $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('OMANTEL_USER') . '&Password=' . env('OMANTEL_PASSWORD') . '&MobileNo=' . Auth::user()->phone . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');
            }
        }
    }

    public function render()
    {
        return view('livewire.user.book-hall-model');
    }
}
