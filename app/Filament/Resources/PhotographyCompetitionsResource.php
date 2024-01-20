<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\PhotographyCompetitionsResource\Pages;
use App\Filament\Resources\PhotographyCompetitionsResource\RelationManagers;
use App\Models\PhotographyCompetition;
use App\Models\User;
use App\Notifications\SmsMessage;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;

class PhotographyCompetitionsResource extends Resource
{
    protected static ?string $model = PhotographyCompetition::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('images')->enableDownload(),
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
                            ->message('أهلا بصديق المركز '.$user->name.' '.'يسرنا إعلامك بقبولك في برنامج ( الأمن السيبراني ). نحن بانتظارك في ( 05-02-2024 ) تبدأ الورشة ( 5:00 )')
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello friend '.$user->name.' We are pleased to inform you that you have been accepted into the (Cybersecurity) program. We are waiting for you on (2024-02-05) The workshop begins (17:00:00)')
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
                            ->message('أهلا بصديق المركز '.$user->name.'يسرنا اعلامك بأنك تم اختيارك لبرنامج الأمن السيبراني نحن في انتظارك في تاريخ ٠٥-٠٢-٢٠٢٤ في تمام الساعة ١٧:٠٠')
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello friend '.$user->name.' We are pleased to inform you that you have been accepted into the (Cybersecurity) program. We are waiting for you on (2024-02-05) The workshop begins (17:00:00)')
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
