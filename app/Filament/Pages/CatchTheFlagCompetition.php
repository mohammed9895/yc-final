<?php

namespace App\Filament\Pages;

use App\Notifications\SmsMessage;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class CatchTheFlagCompetition extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.catch-the-flag-competition';

    protected static function getNavigationLabel(): string
    {
        return __('إستمارة المشاركة في مسابقة التقط العلم  للأمن السيبراني');
    }

    public function getTitle(): string
    {
        return __('إستمارة المشاركة في مسابقة التقط العلم  للأمن السيبراني');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function register()
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = auth()->id();
        $booking = \App\Models\CatchTheFlagCompetition::create($orginal);
        if ($booking) {
            $sms = new SmsMessage;
            if (auth()->user()->preferred_language == 'ar') {
                $sms->to(auth()->user()->phone)
                    ->message('شكراً لك، تم ارسال إستمارتك لطلب المشاركة في مسابقة التقط العلم  للأمن السيبراني')
                    ->lang(auth()->user()->preferred_language)
                    ->send();
            } else {
                $sms->to(auth()->user()->phone)
                    ->message('Thank you, your application has been sent to request participation in Catch the Flag Competition')
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
            Grid::make(1)
                ->schema([
                    Radio::make('previous_participation')
                        ->label('هل شاركت مسبقا في برامج تدريب الأمن السيبراني لمركز الشباب؟')
                        ->options([
                            'yes' => 'نعم',
                            'no' => 'لا',
                        ])
                        ->required(),

                    Radio::make('open_source_usage')
                        ->label('هل قمت باستخدام أنظمة مفتوحة المصدر مثل: Kali Linux؟')
                        ->options([
                            'yes' => 'نعم',
                            'no' => 'لا',
                        ])
                        ->required(),

                    TextInput::make('kali_linux_usage')
                        ->label('اذكر استخدامًا رئيسيًا لنظام كالي لينكس')
                        ->required(),

                    Textarea::make('ethical_hacking_definition')
                        ->label('ما هو الاختراق الأخلاقي بكلماتك الخاصة؟')
                        ->required(),

                    TextInput::make('network_scanning_tool')
                        ->label('أي أداة تستخدمها لمسح الشبكة للبحث عن المنافذ المفتوحة ونقاط الضعف؟')
                        ->required(),

                    TextInput::make('password_cracking_tool')
                        ->label('أي أداة قد تكون خيارك الأول عند محاولة كسر كلمات المرور؟')
                        ->required(),

                    TextInput::make('cyber_attack_type')
                        ->label('اذكر نوعًا واحدًا من الهجمات السيبرانية التي تعرفها')
                        ->required(),

                    TextInput::make('metasploit_usage')
                        ->label('لأي غرض ستستخدم إطار العمل Metasploit؟')
                        ->required(),

                    TextInput::make('other_os_for_pentesting')
                        ->label('بجانب Kali Linux، اذكر نظام تشغيل آخر يُستخدم بشكل شائع لاختبار الاختراق')
                        ->required(),

                    TextInput::make('hashing_algorithm')
                        ->label('حدد خوارزمية تجزئة واحدة تعرفها')
                        ->required(),
                ]),
        ];
    }
}
