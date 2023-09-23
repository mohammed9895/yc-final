<?php

namespace App\Filament\Pages;

use App\Models\LinkedinDitales;
use App\Notifications\SmsMessage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class LinkedinDitalesPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.linkedin-ditales';
    public $booking;

    protected static function shouldRegisterNavigation(): bool
    {
        $booking_count = auth()->user()->bookings()->where('workshop_id', 55)->count();
        if ($booking_count <= 0) {
            return false;
        }
        return true;
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function register()
    {
        $orginal = $this->form->getState();
        $booking = LinkedinDitales::create($orginal);
        if ($booking) {
            $sms = new SmsMessage;
            if (auth()->user()->preferred_language == 'ar') {
                $sms->to(auth()->user()->phone)
                    ->message('شكراً لك، تم تأكيد معلوماتك للمشاركة في ورشة حدد مسارك.')
                    ->lang(auth()->user()->preferred_language)
                    ->send();
            } else {
                $sms->to(auth()->user()->phone)
                    ->message('Thank you, your information has been submitted for Determine Your Path workshop')
                    ->lang(auth()->user()->preferred_language)
                    ->send();
            }
            return Notification::make()
                ->title(__('Registered Successfuly'))
                ->success()
                ->send();
        }
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('fullname')
                ->label(__('filament::users.name'))
                ->required(),
            TextInput::make('email')->label(__('email'))->required(),
            TextInput::make('phone')->label(__('phone'))->required(),
        ];
    }
}
