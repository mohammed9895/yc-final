<?php

namespace App\Filament\Pages;

use App\Models\Tamkeen;
use App\Notifications\SmsMessage;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class TamkeenApplication extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tamkeen-application';

    protected static ?string $slug = 'tmakon';

    protected static function getNavigationLabel(): string
    {
        return __('Tmakon Application');
    }

    public function getTitle(): string
    {
        return __('Tmakon Application');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function register()
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = auth()->id();

        $register = Tamkeen::create($orginal);

        if ($register) {
            $sms = new SmsMessage;
            if (auth()->user()->preferred_language == 'ar') {
                $sms->to(auth()->user()->phone)
                    ->message('شكراً لك، تم ارسال طلبك للتسجيل في برنامج تمكين')
                    ->lang(auth()->user()->preferred_language)
                    ->send();
            } else {
                $sms->to(auth()->user()->phone)
                    ->message('Thank you, Your request have been sent to register in Tmakon Program')
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
            Placeholder::make('')
                ->content('برنامج تمكن أصحاب العمل الحر هو برنامج يستهدف تمكين الشباب بالمهارات اللازمة لتحويل مهاراتهم إلى مصدر دخل كأصحاب عمل مستقلين، ويهدف البرنامج إلى تعزيز الجهود المبذولة لدعم أصحاب العمل المستقلين، والعمل على إبرازها محليا ودوليا. '),
            Placeholder::make('')
                ->content('الفئة العمرية من 15 إلى 34 سنة.'),
            Section::make(__('Personal Information'))
                ->label(__('Personal Information'))
                ->schema([
                    TagsInput::make('social_media_accounts')->label(__('social_media_accounts'))->required(),
                    TextInput::make('linkedin_account')->label(__('linkedin_account'))->required(),
                    FileUpload::make('resume_attachment')->label(__('resume_attachment'))->required(),
                    FileUpload::make('profile_picture_attachment')->label(__('profile_picture_attachment')),
                    Select::make('skill')->label(__('skill'))->options($array = [
                        'المجال العلمي' => 'المجال العلمي',
                        'المجال الفني' => 'المجال الفني',
                        'المجال الهندسي' => 'المجال الهندسي',
                        'المجال الإعلامي' => 'المجال الإعلامي',
                        'المجال الكتابي' => 'المجال الكتابي',
                        'مجال البرمجيات' => 'مجال البرمجيات',
                        'مجال التسويق' => 'مجال التسويق',
                        'مجال التصميم' => 'مجال التصميم',
                        'المجال الحرفي' => 'المجال الحرفي',
                        'مجال التصوير' => 'مجال التصوير',
                        'مجال التجميل' => 'مجال التجميل',
                        'مجال الأزياء' => 'مجال الأزياء',
                        'المجال التقني' => 'المجال التقني',
                        'مجالات أخرى' => 'مجالات أخرى',
                    ])
                        ->searchable()
                        ->required(),
                    TextInput::make('primary_skill')->label(__('primary_skill'))->required(),
                    TagsInput::make('other_skill')->label(__('other_skill')),
                ]),

            Section::make(__('Technical Questions'))
                ->label(__('Technical Questions'))->schema([
                    TextInput::make('program_goals')->label(__('program_goals'))->required(),
                    TextInput::make('how_did_you_discover_your_skill')->label(__('how_did_you_discover_your_skill'))->required(),
                    DatePicker::make('skill_practice_duration')->label(__('skill_practice_duration'))->required(),
                    TextInput::make('awards_certificates')->label(__('awards_certificates'))->required(),
                    TextInput::make('earned_income')->label(__('earned_income'))->required(),
                    TextInput::make('freelance_experience_years')->label(__('freelance_experience_years'))->required(),
                    Select::make('freelance_experience_level')->label(__('freelance_experience_level'))->options([
                        'Beginner' => __('Beginner'),
                        'Intermediate' => __('Intermediate'),
                        'Expert' => __('Expert'),
                    ])->required()->searchable(),
                    Select::make('skill_level')->label(__('skill_level'))->options([
                        'Beginner' => __('Beginner'),
                        'Intermediate' => __('Intermediate'),
                        'Expert' => __('Expert'),
                    ])->required()->searchable(),
                    TextInput::make('clients_worked_with')->label(__('clients_worked_with'))->required(),
                    TextInput::make('financial_earnings')->label(__('financial_earnings'))->required(),
                    TagsInput::make('achievements')->label(__('achievements'))->required(),
                    Textarea::make('development_plan')->label(__('development_plan'))->required(),
                    Select::make('can_manage_projects')->label(__('can_manage_projects'))
                        ->options([
                            0 => 'No',
                            1 => 'Yes'
                        ])->required()->searchable(),
                    Select::make('can_price_services_and_market_self')->label(__('can_price_services_and_market_self'))
                        ->options([
                            0 => 'No',
                            1 => 'Yes'
                        ])->required()->searchable(),
                    Textarea::make('self_marketing_strategy')->label(__('self_marketing_strategy')),
                ]),
        ];
    }
}
