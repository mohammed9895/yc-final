<?php

namespace App\Http\Livewire\User;

use Carbon\Carbon;
use Filament\Forms;

use App\Models\Hall;
use App\Models\Event;
use App\Models\Slot;
use App\Models\Workshop;
use Closure;
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
    public $todayDate = '';

    public $timings;

    public $slots = [];

    public $slotsTimings = ['08:00 AM', '08:30 AM', '09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM', '01:00 PM', '01:30 PM', '02:00 PM', '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM', '05:00 PM', '05:30 PM', '06:00 PM', '06:30 PM', '07:00 PM', '07:30 PM', '08:00 PM', '08:30 PM', '09:00 PM', '09:30 PM', '10:00 PM'];

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
                    Forms\Components\DatePicker::make('date')
                        ->withoutSeconds()
                        ->minDate(now())
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
        $orginal['end'] = $endDateAndTime;

        $events = Event::where('hall_id', $this->hall_id)
            ->where('start', '<', $endDateAndTime)
            ->where('end', '>', $startDateAndTime)
            ->count();

        if ($events > 0) {
            Notification::make()
                ->title('This event timing is not available!')
                ->warning()
                ->send();
        } else {
            if (Event::create([
                'title' => $orginal['title'],
                'user_id' => $orginal['user_id'],
                'hall_id' => $orginal['hall_id'],
                'reasone' => $orginal['reasone'],
                'start' => $startDateAndTime,
                'end' => $endDateAndTime
            ])) {
                $from = Carbon::parse($startDateAndTime);
                $to = Carbon::parse($endDateAndTime);
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

        $events = Event::where('hall_id', $this->hall_id)
            ->whereDate('start', '=', $this->todayDate)
            ->get();

        $reservedTimings = [];

        foreach ($events as $event) {
            $reservedTimings[] = [
                'start' => Carbon::parse($event->start)->format('H:i A'),
                'end' => Carbon::parse($event->end)->format('H:i A')
            ];
        }

        $this->timings = $reservedTimings;

        return view('livewire.user.book-hall-model');
    }
}
