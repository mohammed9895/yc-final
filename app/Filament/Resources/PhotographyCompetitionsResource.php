<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\PhotographyCompetitionsResource\Pages;
use App\Filament\Resources\PhotographyCompetitionsResource\RelationManagers;
use App\Models\PhotographyCompetition;
use App\Models\User;
use App\Notifications\SmsMessage;
use Carbon\Carbon;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;

class PhotographyCompetitionsResource extends Resource
{
    protected static ?string $model = PhotographyCompetition::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('images')->multiple()->enableDownload(),
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
                Tables\Columns\TextColumn::make('user.phone')
                    ->label(__('phone')),
                Tables\Columns\TextColumn::make('user.email')
                    ->label(__('email')),
                TextColumn::make('user.birth_date')->label(__('Age'))->formatStateUsing(fn(string $state
                ): string => Carbon::parse($state)->age),
                Tables\Columns\TextColumn::make('images')
                    ->label(__('Image'))
                    ->searchable()
                    ->prefix('http://yc-final.test/storage/')
                    ->url(function ($record) {
                        $arr = json_decode($record->images);
                        foreach ($arr as $img) {
                            return '/storage/'.$img;
                        }
                    })
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Approve')->action(function (PhotographyCompetition $record) {
                    $user = User::where('id', $record->user_id)->first();
                    $sms = new SmsMessage;
                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('أهلا بصديق المركزأهلاً بصديق المركز، يسرنا إعلامك بقبولك في مسابقة ( التصوير الفوتوغرافي )')
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello friend, We are pleased to inform you that you have been accepted into the (Photography) Competition .')
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    $record->update(['status' => 1]);
                })
                    ->color('success')
                    ->hidden(fn(PhotographyCompetition $record) => $record->status === 1)
                    ->icon('heroicon-o-check-circle'),
                Action::make('reject')->action(function (PhotographyCompetition $record) {
                    $user = User::where('id', $record->user_id)->first();
                    $sms = new SmsMessage;
                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('أهلًا،
شكرًا لتسجيلك في مسابقة التصوير الفوتوغرافي. نعتذر عن عدم إجتيازك لمرحلة الفرز.
 نراكم في برامجنا القادمة.')
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello, Thank you for registering for the Photography Contest. We regret to inform that you have not been shortlisted. Hope to see you in our future programs.')
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    $record->update(['status' => 2]);
                })
                    ->color('danger')
                    ->hidden(fn(PhotographyCompetition $record) => $record->status === 2)
                    ->icon('heroicon-o-x-circle'),
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
            'index' => Pages\ListPhotographyCompetitions::route('/'),
            'create' => Pages\CreatePhotographyCompetitions::route('/create'),
            'edit' => Pages\EditPhotographyCompetitions::route('/{record}/edit'),
        ];
    }
}
