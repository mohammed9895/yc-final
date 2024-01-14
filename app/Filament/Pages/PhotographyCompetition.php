<?php

namespace App\Filament\Pages;

use App\Notifications\SmsMessage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class PhotographyCompetition extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.photography-competition';

    public $isRegistered;

    public function mount(): void
    {
        $this->form->fill();
        $this->isRegistered = \App\Models\PhotographyCompetition::where('user_id', '=', auth()->id())->count();
    }

    public function register()
    {
        $registrationCount = \App\Models\PhotographyCompetition::where('user_id', '=', auth()->id())->count();
        if ($registrationCount > 0) {
            return Notification::make()
                ->title(__('Already Registered'))
                ->success()
                ->send();
        } else {
            $orginal = $this->form->getState();
            $orginal['user_id'] = auth()->id();
            $booking = \App\Models\PhotographyCompetition::create($orginal);
            if ($booking) {
                $sms = new SmsMessage;
                if (auth()->user()->preferred_language == 'ar') {
                    $sms->to(auth()->user()->phone)
                        ->message('شكراً لك، تم ارسال إستمارتك لطلب المشاركة في مسابقة (مطرح في اطار)')
                        ->lang(auth()->user()->preferred_language)
                        ->send();
                } else {
                    $sms->to(auth()->user()->phone)
                        ->message('Thank you, your application has been sent to request participation in (Mutrah in Frame)')
                        ->lang(auth()->user()->preferred_language)
                        ->send();
                }
                return Notification::make()
                    ->title(__('Registered Successfuly'))
                    ->success()
                    ->send();
            }
        }
    }

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('images')->multiple()->image(),
        ];
    }
}
