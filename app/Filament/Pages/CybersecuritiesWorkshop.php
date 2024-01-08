<?php

namespace App\Filament\Pages;

use App\Models\Cybersecurity;
use App\Notifications\SmsMessage;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class CybersecuritiesWorkshop extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.cybersecurities';

    public $isRegistered;

    public function mount(): void
    {
        $this->form->fill();
        $this->isRegistered = Cybersecurity::where('user_id', '=', auth()->id())->count();
    }

    public function register()
    {
        $registrationCount = Cybersecurity::where('user_id', '=', auth()->id())->count();
        if ($registrationCount > 0) {
            return Notification::make()
                ->title(__('Already Registered'))
                ->success()
                ->send();
        } else {
            $orginal = $this->form->getState();
            $orginal['user_id'] = auth()->id();
            $booking = Cybersecurity::create($orginal);
            if ($booking) {
                $sms = new SmsMessage;
                if (auth()->user()->preferred_language == 'ar') {
                    $sms->to(auth()->user()->phone)
                        ->message('شكراً لك، تم ارسال إستمارتك لطلب المشاركة في ورشة الإمن السيبراني')
                        ->lang(auth()->user()->preferred_language)
                        ->send();
                } else {
                    $sms->to(auth()->user()->phone)
                        ->message('Thank you, your application has been sent to request participation in Cybersecurity workshop')
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
            Checkbox::make('tried_linux')
                ->label('Have you tried working on Linux systems in the past?'),

            Checkbox::make('passionate_cyber_security')
                ->label('Are you passionate about learning cyber security and the Linux operating system?'),

            Select::make('academic_professional_status')
                ->label('What is your current academic or professional status?')
                ->options([
                    'diploma_holder' => 'Diploma holder',
                    'senior_year_student' => 'Senior year student',
                    'fresh_graduate' => 'Fresh graduate',
                    'cyber_analyst' => 'Cyber analyst',
                    'other' => 'Other',
                ]),

            Select::make('linux_expertise')
                ->label('Evaluate your expertise in Linux fundamentals.')
                ->options([
                    'zero_knowledge' => 'Zero knowledge',
                    'low_knowledge' => 'Low knowledge',
                    'medium_knowledge' => 'Medium knowledge',
                    'high_knowledge' => 'High knowledge',
                ]),

            Checkbox::make('participated_in_workshops')
                ->label('Have you participated in any cyber security workshops?'),

            Textarea::make('significant_project_description')
                ->label('Please describe your most significant project related to Linux.')
                ->maxLength(600),

            Textarea::make('motivation_participation')
                ->label('What motivated you to participate in this program?')
                ->maxLength(600),

            Textarea::make('reason_for_opportunity')
                ->label('Why do you believe you deserve this opportunity?')
                ->maxLength(600),
        ];
    }
}
