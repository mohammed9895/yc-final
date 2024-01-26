<?php

namespace App\Filament\Pages;

use App\Notifications\SmsMessage;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class BookConferences extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.book-conference';

    public function mount(): void
    {
        $this->form->fill();
        $this->isRegistered = \App\Models\BookConference::where('user_id', '=', auth()->id())->count();
    }

    public function register()
    {
        $registrationCount = \App\Models\BookConference::where('user_id', '=', auth()->id())->count();
        if ($registrationCount > 0) {
            return Notification::make()
                ->title(__('Already Registered'))
                ->success()
                ->send();
        } else {
            $orginal = $this->form->getState();
            $orginal['user_id'] = auth()->id();
            $booking = \App\Models\BookConference::create($orginal);
            if ($booking) {
                $sms = new SmsMessage;
                if (auth()->user()->preferred_language == 'ar') {
                    $sms->to(auth()->user()->phone)
                        ->message('تم ارسال مشاركتك بنجاح.')
                        ->lang(auth()->user()->preferred_language)
                        ->send();
                } else {
                    $sms->to(auth()->user()->phone)
                        ->message('تم ارسال مشاركتك بنجاح.')
                        ->lang('ar')
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
            FileUpload::make('file')
                ->label(__('الملف'))
                ->maxSize(10240)
                ->required(),
        ];
    }
}
