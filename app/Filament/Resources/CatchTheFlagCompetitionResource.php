<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\CatchTheFlagCompetitionResource\Pages;
use App\Filament\Resources\CatchTheFlagCompetitionResource\RelationManagers;
use App\Models\CatchTheFlagCompetition;
use Carbon\Carbon;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class CatchTheFlagCompetitionResource extends Resource
{
    protected static ?string $model = CatchTheFlagCompetition::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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

                        Repeater::make('teammates')
                            ->label('معلومات الفريق')
                            ->schema([
                                TextInput::make('fullname')
                                    ->label('الاسم الكامل')->required(),
                                TextInput::make('age')->label('العمر')->required(),
                                TextInput::make('phone')->label('الهاتف'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
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
                Tables\Columns\TextColumn::make('previous_participation'),
                Tables\Columns\TextColumn::make('open_source_usage'),
                Tables\Columns\TextColumn::make('kali_linux_usage'),
                Tables\Columns\TextColumn::make('ethical_hacking_definition'),
                Tables\Columns\TextColumn::make('network_scanning_tool'),
                Tables\Columns\TextColumn::make('password_cracking_tool'),
                Tables\Columns\TextColumn::make('cyber_attack_type'),
                Tables\Columns\TextColumn::make('metasploit_usage'),
                Tables\Columns\TextColumn::make('other_os_for_pentesting'),
                Tables\Columns\TextColumn::make('hashing_algorithm'),
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
            'index' => Pages\ListCatchTheFlagCompetitions::route('/'),
            'create' => Pages\CreateCatchTheFlagCompetition::route('/create'),
            'edit' => Pages\EditCatchTheFlagCompetition::route('/{record}/edit'),
        ];
    }
}
