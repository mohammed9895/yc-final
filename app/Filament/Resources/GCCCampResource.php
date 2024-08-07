<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\GCCCampResource\Pages;
use App\Models\GCCCamp;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;


class GCCCampResource extends Resource
{
    protected static ?string $model = GCCCamp::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getModelLabel(): string
    {
        return __('إستمارات المشاركة في مخيم الشباب الخليجي 2023');
    }

    public static function getPluralModelLabel(): string
    {
        return __('إستمارات المشاركة في مخيم الشباب الخليجي 2023');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        Section::make('معلومات أساسية')
                            ->schema([
                                Select::make('user_id')
                                    ->label(__('User'))
                                    ->options(User::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->required(),
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
                                    ->required()
                                    ->label('إذا كان الجواب نعم الرجاء ذكر مرحلة الأزمة')
                                    ->hidden(fn(callable $get) => $get('has_respiratory_issues') == null),
                                Checkbox::make('has_diabetes')
                                    ->label('مرض السكر ؟'),
                                Checkbox::make('has_head_injury')
                                    ->reactive()
                                    ->label('صراع أو نوبات إغماء أو صداع نصفي أو إصابة جسمية في الرأس؟'),
                                TextInput::make('head_injury_details')
                                    ->required()
                                    ->label('إذا كان الجواب نعم الرجاء ذكرالإصابة')
                                    ->visible(fn(callable $get) => $get('has_head_injury')),
                                Checkbox::make('is_registered_disabled')
                                    ->label('هل أنت مسجل رسميا كصاحب احتياجات خاصة؟'),
                                Checkbox::make('has_bone_or_tendon_injury')
                                    ->reactive()
                                    ->label('كسور في العظام أو تمزق في الأربطة أو الوتر ؟'),
                                TextInput::make('bone_tendon_injury_details')
                                    ->label('إذا كان الجواب نعم الرجاء ذكرالإصابة')
                                    ->required()
                                    ->visible(fn(callable $get) => $get('has_bone_or_tendon_injury')),
                                Checkbox::make('has_infectious_disease')
                                    ->reactive()
                                    ->label('هل تعاني من أي مرض معدي أو تحمل مكروبات أمراض معدية ؟'),
                                TextInput::make('infectious_disease_details')
                                    ->required()
                                    ->label('إذا كان الجواب نعم الرجاء ذكرالمرض')
                                    ->visible(fn(callable $get) => $get('has_infectious_disease')),
                                Checkbox::make('had_medical_treatment')
                                    ->required()
                                    ->reactive()
                                    ->label('هل سبق لك أن تلقيت علاجا من الطبيب أو أنك دخلت المستشفى خلال العام الأخير؟'),
                                TextInput::make('medical_treatment_details')
                                    ->required()
                                    ->label('إذا كان الجواب نعم الرجاء ذكرالسبب')
                                    ->visible(fn(callable $get) => $get('had_medical_treatment')),
                                Select::make('blood_type')
                                    ->required()
                                    ->searchable()
                                    ->options([
                                        'AB-' => 'AB-',
                                        'AB+' => 'AB+',
                                        'B-' => 'B-',
                                        'B+' => 'B+',
                                        'A-' => 'A-',
                                        'O-' => 'O-',
                                        'O+' => 'O+',
                                    ])
                                    ->label('ماهي فصيلة الدم ؟'),
                                TextInput::make('medications')
                                    ->required()
                                    ->label('هل تتعاطى أي أدوية ( إذا كانت الإجابة نعم نرجو منك وصف نوع الدواء والتفاصيل )'),
                                TextInput::make('other_medical_issues')
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
                                    ->label('رقم الهاتف :'),
                                TextInput::make('email')
                                    ->required()
                                    ->label('الإيميل :'),
                            ]),
                    ]),
                Grid::make(1)->schema([
                    Checkbox::make('had_medical_treatment')
                        ->required()
                        ->label('أقر بأنني على دراية بأن المخيم يحتاج إلى جهد بدني وأني أعتبر نفسي لائق بدنيا بالدرجة الكافية التي تسمح لي بالمشاركة.'),
                    Checkbox::make('had_medical_treatment')
                        ->required()
                        ->label('أقر بموافقتي على الالتزام بالقواعد المطبقة علي أثناء مشاركتي في البرنامج والتزامي بالشروط الموضوعة والتي يوجهها لي المنظمون وممثليهم .							'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->searchable()
                    ->url(fn($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('user.phone')->searchable()->label('Phone'),
                Tables\Columns\TextColumn::make('user.email')->searchable()->label('Email'),
                Tables\Columns\BadgeColumn::make('user.gender')
                    ->enum([
                        0 => 'Male',
                        1 => 'Female'
                    ])->searchable()
                    ->label(__('filament::users.sex'))->sortable(),
                TextColumn::make('user.birth_date')->label(__('Age'))->formatStateUsing(fn(string $state): string => Carbon::parse($state)->age),
                Tables\Columns\TextColumn::make('fullname_ar')
                    ->label('الاسم الثلاثي باللغة العربية "حسب جواز السفر"')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('fullname_en')
                    ->label('الاسم الثلاثي باللغة الانجليزية "حسب جواز السفر"')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nationality')
                    ->label('الجنسية')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_address')
                    ->label('مقر الإقامة الحالي')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('airport')
                    ->label('أقرب مطار')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('why_you_want_to_register')
                    ->label('لماذا ترغب في المشاركة؟')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('goals')
                    ->label('ما هي أهدافك؟')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('experience')
                    ->label('هل لديك خبرات سابقة؟')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('talents')
                    ->label('ما هي المهارات أو المواهب؟')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('suggestions')
                    ->label('هل لديك أي اقتراحات؟')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('shert_size')
                    ->label('مقاس المقيص')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('has_heart_issues')
                    ->label('مشاكل في القلب؟'),
                Tables\Columns\BooleanColumn::make('fitness')
                    ->label('لياقة بدنية عالية؟'),
                Tables\Columns\BooleanColumn::make('has_respiratory_issues')
                    ->label('ربو أو ضيق في التنفس؟'),
                Tables\Columns\TextColumn::make('crisis_stage')
                    ->label('مرحلة الأزمة')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('has_diabetes')
                    ->label('مرض السكر؟'),
                Tables\Columns\BooleanColumn::make('has_head_injury')
                    ->label('نوبات إغماء أو صداع نصفي؟'),
                Tables\Columns\TextColumn::make('head_injury_details')
                    ->label('تفاصيل إصابة الرأس')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('is_registered_disabled')
                    ->label('احتياجات خاصة؟'),
                Tables\Columns\BooleanColumn::make('has_bone_or_tendon_injury')
                    ->label('كسور أو تمزق؟'),
                Tables\Columns\TextColumn::make('bone_tendon_injury_details')
                    ->label('تفاصيل الإصابة')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('has_infectious_disease')
                    ->label('مرض معدي؟'),
                Tables\Columns\TextColumn::make('infectious_disease_details')
                    ->label('تفاصيل المرض')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('had_medical_treatment')
                    ->label('تلقي علاج طبي؟'),
                Tables\Columns\TextColumn::make('medical_treatment_details')
                    ->label('تفاصيل العلاج')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('blood_type')
                    ->label('فصيلة الدم')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('medications')
                    ->label('الأدوية')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('other_medical_issues')
                    ->label('متاعب طبية أخرى')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('diet')
                    ->label('أسلوب غذائي')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('fears')
                    ->label('مخاوف')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('emergency_contact_name')
                    ->label('شخص للتواصل في حالة الطوارئ')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('العنوان')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_1')
                    ->label('رقم الهاتف 1')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('الإيميل')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cv')
                    ->label('السيرة الذاتية'),
                Tables\Columns\TextColumn::make('passport')
                    ->label('صورة جواز السفر'),
                Tables\Columns\TextColumn::make('id_card')
                    ->label('البطاقة الشخصية'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('export'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGCCCamps::route('/'),
            'create' => Pages\CreateGCCCamp::route('/create'),
            'edit' => Pages\EditGCCCamp::route('/{record}/edit'),
        ];
    }
}
