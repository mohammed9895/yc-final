<?php

namespace App\Filament\Pages;

use App\Notifications\SmsMessage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class OperationsTrainingApplication extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.operations-training-application';
    public $open = true;
    public $isRegistered;

    protected static function getNavigationLabel(): string
    {
        return 'البرنامج التدر يبي في قسم العمليات';
    }

    public function getTitle(): string
    {
        return 'البرنامج التدر يبي في قسم العمليات';
    }

    public function mount(): void
    {
        $this->form->fill();
        $this->isRegistered = \App\Models\OperationsTrainingApplications::where('user_id', '=', auth()->id())->count();
    }

    public function register()
    {
        $registrationCount = \App\Models\OperationsTrainingApplications::where('user_id', '=', auth()->id())->count();
        if ($registrationCount > 0) {
            return Notification::make()
                ->title(__('Already Registered'))
                ->success()
                ->send();
        } else {
            $orginal = $this->form->getState();
            $orginal['user_id'] = auth()->id();
            $booking = \App\Models\OperationsTrainingApplications::create($orginal);
            if ($booking) {
                $sms = new SmsMessage;
                if (auth()->user()->preferred_language == 'ar') {
                    $sms->to(auth()->user()->phone)
                        ->message('شكراً لك، تم ارسال إستمارتك لطلب التدريب في قسم العمليات')
                        ->lang(auth()->user()->preferred_language)
                        ->send();
                } else {
                    $sms->to(auth()->user()->phone)
                        ->message('Thank you, your application has been sent to request to jon the operations training department')
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
            \Filament\Forms\Components\Toggle::make('do_you_have_experience')
                ->label('هل لديك خبرة سابقة في إدارة المساحات أو تنظيم الفعاليات؟')
                ->reactive()
                ->default(false),
            Textarea::make('experience_description')
                ->label('يرجى توضيح.')
                ->hidden(function (callable $get) {
                    if ($get('do_you_have_experience') === false) {
                        return true;
                    }
                }),
            Textarea::make('goals')
                ->label('ما هي أهدافك من الانضمام إلى هذا البرنامج التدريبي؟')
                ->required(),
            FileUpload::make('cv')
                ->label('السيرة الذاتية')
                ->required(),
        ];
    }
}
