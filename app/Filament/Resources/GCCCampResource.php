<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\GCCCamp;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GCCCampResource\Pages;


class GCCCampResource extends Resource
{
    protected static ?string $model = GCCCamp::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getModelLabel(): string
    {
        return   __('إستمارات المشاركة في مخيم الشباب الخليجي 2023');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('إستمارات المشاركة في مخيم الشباب الخليجي 2023');
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
                                    ->visible(fn (callable $get) =>  $get('has_respiratory_issues')),
                                Checkbox::make('has_diabetes')
                                    ->label('مرض السكر ؟'),
                                Checkbox::make('has_head_injury')
                                    ->reactive()
                                    ->label('صراع أو نوبات إغماء أو صداع نصفي أو إصابة جسمية في الرأس؟'),
                                TextInput::make('head_injury_details')
                                    ->required()
                                    ->label('إذا كان الجواب نعم الرجاء ذكرالإصابة')
                                    ->visible(fn (callable $get) => $get('has_head_injury')),
                                Checkbox::make('is_registered_disabled')
                                    ->label('هل أنت مسجل رسميا كصاحب احتياجات خاصة؟'),
                                Checkbox::make('has_bone_or_tendon_injury')
                                    ->reactive()
                                    ->label('كسور في العظام أو تمزق في الأربطة أو الوتر ؟'),
                                TextInput::make('bone_tendon_injury_details')
                                    ->label('إذا كان الجواب نعم الرجاء ذكرالإصابة')
                                    ->required()
                                    ->visible(fn (callable $get) => $get('has_bone_or_tendon_injury')),
                                Checkbox::make('has_infectious_disease')
                                    ->reactive()
                                    ->label('هل تعاني من أي مرض معدي أو تحمل مكروبات أمراض معدية ؟'),
                                TextInput::make('infectious_disease_details')
                                    ->required()
                                    ->label('إذا كان الجواب نعم الرجاء ذكرالمرض')
                                    ->visible(fn (callable $get) => $get('has_infectious_disease')),
                                Checkbox::make('had_medical_treatment')
                                    ->required()
                                    ->reactive()
                                    ->label('هل سبق لك أن تلقيت علاجا من الطبيب أو أنك دخلت المستشفى خلال العام الأخير؟'),
                                TextInput::make('medical_treatment_details')
                                    ->required()
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
                    ->url(fn ($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('user.phone')->searchable()->label('Phone'),
                Tables\Columns\TextColumn::make('user.email')->searchable()->label('Email'),
                Tables\Columns\IconColumn::make('has_heart_issues')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_respiratory_issues')
                    ->boolean(),
                Tables\Columns\TextColumn::make('crisis_stage'),
                Tables\Columns\IconColumn::make('has_diabetes')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_head_injury')
                    ->boolean(),
                Tables\Columns\TextColumn::make('head_injury_details'),
                Tables\Columns\IconColumn::make('is_registered_disabled')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_bone_or_tendon_injury')
                    ->boolean(),
                Tables\Columns\TextColumn::make('bone_tendon_injury_details'),
                Tables\Columns\IconColumn::make('has_infectious_disease')
                    ->boolean(),
                Tables\Columns\TextColumn::make('infectious_disease_details'),
                Tables\Columns\TextColumn::make('blood_type'),
                Tables\Columns\IconColumn::make('had_medical_treatment')
                    ->boolean(),
                Tables\Columns\TextColumn::make('medical_treatment_details'),
                Tables\Columns\TextColumn::make('medications'),
                Tables\Columns\TextColumn::make('other_medical_issues'),
                Tables\Columns\TextColumn::make('diet'),
                Tables\Columns\TextColumn::make('fears'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->dateTime(),
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
