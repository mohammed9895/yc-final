<?php

namespace App\Http\Livewire\User;

use Carbon\Carbon;
use App\Models\Slot;
use App\Models\Booking;
use Livewire\Component;
use App\Models\Evaluate;
use App\Models\Workshop;
use App\Models\Attendees;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class EvaluateModel extends ModalComponent implements HasForms
{
    use InteractsWithForms;

    public $booking;

    public $user_id;
    public $workshop_id;
    public $rating;
    public $instructor;
    public $duration;
    public $sutsfing;
    public $devloped;
    public $suggestions;

    protected $rules = [
        'rating' => 'required',
        'duration' => 'required',
        'sutsfing' => 'required',
        'devloped' => 'required',
    ];

    public function mount(Booking $booking)
    {
        $this->booking = $booking;
        $this->user_id =  Auth::id();
        $this->workshop_id = $booking->workshop_id;
        $this->instructor = $booking->workshop->user_id;
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    Radio::make('rating')
                        ->options([
                            'excellent' => __('filament::yc.evaluate.excellent'),
                            'very good' =>  __('filament::yc.evaluate.very_good'),
                            'good' =>  __('filament::yc.evaluate.good'),
                            'weak' =>  __('filament::yc.evaluate.weak'),
                        ])->required(),
                    Radio::make('instructor')
                        ->options([
                            'excellent' => __('filament::yc.evaluate.excellent'),
                            'very good' =>  __('filament::yc.evaluate.very_good'),
                            'good' =>  __('filament::yc.evaluate.good'),
                            'weak' =>  __('filament::yc.evaluate.weak'),
                        ])->required(),

                    Radio::make('duration')
                        ->options([
                            'long' => __('filament::yc.evaluate.excellent'),
                            'perfect' =>  __('filament::yc.evaluate.very_good'),
                            'short' =>  __('filament::yc.evaluate.good'),
                        ])->required(),

                    Radio::make('sutsfing')
                        ->options([
                            'completely_satisfied' => __('filament::yc.evaluate.completely_satisfied'),
                            'satisfied' =>  __('filament::yc.evaluate.satisfied'),
                            'fairly_satisfied' =>  __('filament::yc.evaluate.fairly_satisfied'),
                            'not_satisfied' =>  __('filament::yc.evaluate.not_satisfied'),
                            'not_satisfied_at_all' =>  __('filament::yc.evaluate.not_satisfied_at_all'),
                        ])->required(),

                    Textarea::make('devloped')
                        ->required()
                        ->label(__('filament::yc.evaluate.devloped')),

                    Textarea::make('suggestions')
                        ->required()
                        ->label(__('filament::yc.evaluate.suggestions'))

                ])
        ];
    }


    public function submit()
    {
        $this->validate();

        $evaluate = Evaluate::create([
            'user_id' => $this->user_id,
            'workshop_id' => $this->workshop_id,
            'rating' => $this->rating,
            'instructor' => $this->instructor,
            'duration' => $this->duration,
            'sutsfing' => $this->sutsfing,
            'devloped' => $this->devloped,
            'suggestions' => $this->suggestions,
        ]);

        $this->emit('downloadCertificate');
        Notification::make()
            ->title('Yorr evaluation has been sent successfuly!')
            ->success()
            ->send();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.user.evaluate-model');
    }
}
