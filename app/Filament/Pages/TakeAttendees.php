<?php

namespace App\Filament\Pages;

use App\Models\Attendees;
use App\Models\Booking;
use App\Models\Slot;
use App\Models\Workshop;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Closure;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\View\View;

class TakeAttendees extends Page implements HasForms
{

    use InteractsWithForms, HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.take-attendees';

    public $attendance;
    public $slot_id = 108;

    public $users = [];

    public function mount(): void
    {
        $this->form->fill();
        $this->attendance = Booking::where('slot_id', '=',  26)->where('status', '=', 2)->get();
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('workshop_id')
                ->options(Workshop::all()->pluck('title', 'id'))
                ->reactive()
                ->searchable()
                ->required(),
            Select::make('slot_id')
                ->options(function (callable $get) {
                    $workshop = Workshop::find($get('workshop_id'));
                    if (!$workshop) {
                        return Slot::all()->pluck('name', 'id');
                    }
                    return $workshop->slots->pluck('name', 'id');
                })
                ->afterStateUpdated(function (Closure $set, $state) {
                    $this->slot_id = $state;
                    $this->attendance = Booking::where('slot_id', '=',  $state)->where('status', '=', 2)->get();
                })
                ->searchable()
                ->reactive()
                ->required(),
            DatePicker::make('date'),
        ];
    }

    public function save() :void
    {
        $orginal = $this->form->getState();
        foreach ($this->users as $key => $value) {
            Attendees::updateOrCreate([
                'user_id' => $key,
                'slot_id' => $this->slot_id,
                'attendance' => $value,
                'date' => $orginal['date']
            ]);
        }
        Notification::make()
            ->title('Attendance has been taken successfully!')
            ->success()
            ->send();
    }
}
