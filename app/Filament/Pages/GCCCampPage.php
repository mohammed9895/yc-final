<?php

namespace App\Filament\Pages;

use App\Models\GCCCamp;
use Filament\Pages\Page;
use App\Notifications\SmsMessage;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class GCCCampPage extends Page implements HasForms, HasTable
{
    use InteractsWithForms,  InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.g-c-c-camp';

    public function getTitle(): string
    {
        return   __('إستمارة المشاركة في مخيم الشباب الخليجي 2023');
    }

    protected static function getNavigationLabel(): string
    {
        return   __('إستمارة المشاركة في مخيم الشباب الخليجي 2023');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(1)
                ->schema([
                    Section::make('معلومات أساسية')
                        ->schema([
                            TextInput::make('orginization')
                                ->required()
                                ->label('الجهة المشارك من خلالها'),
                            Select::make('shert_size')
                                ->required()
                                ->searchable()
                                ->options([
                                    'XS' => 'XS',
                                    'S' => 'S',
                                    'M' => 'M',
                                    'L' => 'L',
                                    'XL' => 'XL',
                                    'XXL' => 'XXL',
                                    'XXXL' => 'XXXL'
                                ])
                                ->label('مقاس المقيص'),
                        ]),
                    Section::make('السيرة الطبية')
                        ->description('من المهم للغاية أن تتوافر لدينا المعلومات الواردة أدناه بخصوص سيرتكم الطبية وسيكون من صالحكم وصالحنا أن تكون إجابتكم على الأسلئة صحيحة ودقيقة وأن تتحمل مسؤولية إجابتك عليها')
                        ->schema([
                            Checkbox::make('has_heart_issues')
                                ->label('مشاكل في القلب أو ارتفاع ضغط الدم؟'),
                            Checkbox::make('has_respiratory_issues')
                                ->reactive()
                                ->label('ربو أو نزلات شعبية أو ضيق في التنفس؟'),
                            TextInput::make('crisis_stage')
                                ->required(fn (callable $get) => $get('has_respiratory_issues'))
                                ->label('إذا كان الجواب نعم الرجاء ذكر مرحلة الأزمة')
                                ->visible(fn (callable $get) =>  $get('has_respiratory_issues')),
                            Checkbox::make('has_diabetes')
                                ->label('مرض السكر ؟'),
                            Checkbox::make('has_head_injury')
                                ->reactive()
                                ->label('صراع أو نوبات إغماء أو صداع نصفي أو إصابة جسمية في الرأس؟'),
                            TextInput::make('head_injury_details')
                                ->required(fn (callable $get) => $get('has_head_injury'))
                                ->label('إذا كان الجواب نعم الرجاء ذكرالإصابة')
                                ->visible(fn (callable $get) => $get('has_head_injury')),
                            Checkbox::make('is_registered_disabled')
                                ->label('هل أنت مسجل رسميا كصاحب احتياجات خاصة؟'),
                            Checkbox::make('has_bone_or_tendon_injury')
                                ->reactive()
                                ->label('كسور في العظام أو تمزق في الأربطة أو الوتر ؟'),
                            TextInput::make('bone_tendon_injury_details')
                                ->label('إذا كان الجواب نعم الرجاء ذكرالإصابة')
                                ->required(fn (callable $get) => $get('has_bone_or_tendon_injury'))
                                ->visible(fn (callable $get) => $get('has_bone_or_tendon_injury')),
                            Checkbox::make('has_infectious_disease')
                                ->reactive()
                                ->label('هل تعاني من أي مرض معدي أو تحمل مكروبات أمراض معدية ؟'),
                            TextInput::make('infectious_disease_details')
                                ->required(fn (callable $get) => $get('has_infectious_disease'))
                                ->label('إذا كان الجواب نعم الرجاء ذكرالمرض')
                                ->visible(fn (callable $get) => $get('has_infectious_disease')),
                            Checkbox::make('had_medical_treatment')
                                ->reactive()
                                ->label('هل سبق لك أن تلقيت علاجا من الطبيب أو أنك دخلت المستشفى خلال العام الأخير؟'),
                            TextInput::make('medical_treatment_details')
                                ->required(fn (callable $get) => $get('had_medical_treatment'))
                                ->label('إذا كان الجواب نعم الرجاء ذكرالسبب')
                                ->visible(fn (callable $get) => $get('had_medical_treatment')),
                            Select::make('blood_type')
                                ->required()
                                ->searchable()
                                ->options([
                                    'AB-' => 'AB-',
                                    'AB+' => 'AB+',
                                    'B-' => 'B-',
                                    'B+' => 'B+',
                                    'A-' => 'A-',
                                    'A+' => 'A+',
                                    'O-' => 'O-',
                                    'O+' => 'O+',
                                ])
                                ->label('ماهي فصيلة الدم ؟'),
                            TextInput::make('medications')
                                ->required()
                                ->label('هل تتعاطى أي أدوية ( إذا كانت الإجابة نعم نرجو منك وصف نوع الدواء والتفاصيل )'),
                            TextInput::make('other_medical_issues')
                                ->required()
                                ->label('هل تعاني من أي متاعب طبية أخرى يجوز أن تؤثر عليك خلال هذا البرنامج؟'),
                            TextInput::make('diet')
                                ->required()
                                ->label('هل تستخدم أسلوب غذائي معين ؟'),
                            TextInput::make('fears')
                                ->required()
                                ->label('هل لديك مخاوف مثال ( المرتفعات / السباحة / أخرى مع ذكرها)'),
                        ]),
                    Section::make('معلومات التواصل في حالة الطوارئ')
                        ->schema([
                            TextInput::make('emergency_contact_name')
                                ->required()
                                ->label('شخص للتواصل في حالة أي طارئ'),
                            TextInput::make('address')
                                ->required()
                                ->label('العنوان'),
                            TextInput::make('phone_1')
                                ->required()
                                ->label('رقم الهاتف 1 :'),
                            TextInput::make('email')
                                ->required()
                                ->label('الإيميل :'),
                        ]),
                ]),
            Grid::make(1)->schema([
                Checkbox::make('aggre1')
                    ->required()
                    ->dehydrated(false)
                    ->label('أقر بأنني على دراية بأن المخيم يحتاج إلى جهد بدني وأني أعتبر نفسي لائق بدنيا بالدرجة الكافية التي تسمح لي بالمشاركة.'),
                Checkbox::make('aggre2')
                    ->required()
                    ->dehydrated(false)
                    ->label('أقر بموافقتي على الالتزام بالقواعد المطبقة علي أثناء مشاركتي في البرنامج والتزامي بالشروط الموضوعة والتي يوجهها لي المنظمون وممثليهم .							'),
            ])
        ];
    }

    protected function getTableQuery(): Builder
    {
        return GCCCamp::query()->where('user_id', auth()->id());
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user_id'),
            IconColumn::make('has_heart_issues')
                ->boolean(),
            IconColumn::make('has_respiratory_issues')
                ->boolean(),
            TextColumn::make('crisis_stage'),
            IconColumn::make('has_diabetes')
                ->boolean(),
            IconColumn::make('has_head_injury')
                ->boolean(),
            TextColumn::make('head_injury_details'),
            IconColumn::make('is_registered_disabled')
                ->boolean(),
            IconColumn::make('has_bone_or_tendon_injury')
                ->boolean(),
            TextColumn::make('bone_tendon_injury_details'),
            IconColumn::make('has_infectious_disease')
                ->boolean(),
            TextColumn::make('infectious_disease_details'),
            TextColumn::make('blood_type'),
            IconColumn::make('had_medical_treatment')
                ->boolean(),
            TextColumn::make('medical_treatment_details'),
            TextColumn::make('medications'),
            TextColumn::make('other_medical_issues'),
            TextColumn::make('diet'),
            TextColumn::make('fears'),
            TextColumn::make('created_at')
                ->dateTime(),
            TextColumn::make('updated_at')
                ->dateTime(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('delete')
                ->label(__('delete'))
                ->action('delete')
                ->action(function (GCCCamp $record, array $data) {
                    $record->delete();
                })
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation(),
        ];
    }

    public function register()
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = auth()->id();
        $booking = GCCCamp::create($orginal);
        if ($booking) {
            $sms = new SmsMessage;
            if (auth()->user()->preferred_language == 'ar') {
                $sms->to(auth()->user()->phone)
                    ->message('شكراً لك، تم ارسال إستمارتك لطلب المشاركة في مخيم الشباب الخليجي 2023')
                    ->lang(auth()->user()->preferred_language)
                    ->send();
            } else {
                $sms->to(auth()->user()->phone)
                    ->message('Thank you, your application has been sent to request participation in the Gulf Youth Camp')
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
