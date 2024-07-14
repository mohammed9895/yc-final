<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\TrainingAlppicationResource\Pages;
use App\Filament\Resources\TrainingAlppicationResource\RelationManagers;
use App\Models\EducationType;
use App\Models\EmployeeType;
use App\Models\Province;
use App\Models\TrainingApplication;
use App\Models\User;
use App\Notifications\SmsMessage;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class TrainingAlppicationResource extends Resource
{
    protected static ?string $model = TrainingApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required(),
                Forms\Components\TextInput::make('province_id')->label(__('province'))
                    ->required(),
                Forms\Components\TextInput::make('education_type_id')->label(__('filament::users.degree'))
                    ->required(),
                Forms\Components\TextInput::make('employee_type_id')->label(__('filament::users.work'))
                    ->required(),
                Forms\Components\FileUpload::make('cv')
                    ->enableDownload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label(__('User'))
                    ->searchable()
                    ->url(fn($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                TextColumn::make('user.email')->label(__('User'))
                    ->searchable(),
                TextColumn::make('user.birth_date')->label(__('Age'))->formatStateUsing(fn(string $state): string => Carbon::parse($state)->age),
                Tables\Columns\TextColumn::make('user.phone')->label(__('phone')),
                Tables\Columns\TextColumn::make('province.name')->label(__('province')),
                Tables\Columns\TextColumn::make('educationType.name')->label(__('filament::users.degree')),
                Tables\Columns\TextColumn::make('employeeType.name')->label(__('filament::users.work')),
                TextColumn::make('reason'),
                TextColumn::make('experience'),
                TextColumn::make('transportation'),
                Tables\Columns\TextColumn::make('cv')->label(__('CV'))->url(fn($record) => 'https://yc.om/storage/' . $record->cv)->openUrlInNewTab()->prefix('https://yc.om/storage/'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('province_id')->searchable()->options(Province::all()->pluck('name', 'id'))->label(__('province'))->multiple(),
                Tables\Filters\SelectFilter::make('education_type_id')->searchable()->options(EducationType::all()->pluck('name', 'id'))->label(__('filament::users.degree'))->multiple(),
                Tables\Filters\SelectFilter::make('employee_type_id')->searchable()->options(EmployeeType::all()->pluck('name', 'id'))->label(__('filament::users.work'))->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('download')->action('approve')
                    ->label(__('Download CV'))
                    ->action(function (TrainingApplication $record) {
                        $outputFile = Storage::disk('local')->path("/public/" . $record->cv);
                        return Response::download($outputFile, $record->user->name . '_cv.pdf');
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('export'),


                BulkAction::make('reject')
                    ->label(__('reject'))
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {

                            $user = User::where('id', $record->user_id)->first();

                            $sms = new SmsMessage;
                            if ($user->preferred_language == 'ar') {
                                $sms->to($user->phone)
                                    ->message('نشكركم على تفاعلكم و تسجيلكم في إعلان المتدربين، ونتعذر منكم لعدم قبولكم بسبب محدودية العدد المطلوب، ونتمنى تكونوا دائمًا جزء من برامجنا وفعالياتنا خلال الفترة القادمة.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('We appreciate your interaction and application in the training announcement. However, we do regret to inform you that you have not been shortlisted this time due to the limited numbers required. We hope that you will always be part of our programs and events during the coming period.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }

                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-check-circle')
                    ->color('danger')
                    ->requiresConfirmation(),
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
            'index' => Pages\ListTrainingAlppications::route('/'),
            'create' => Pages\CreateTrainingAlppication::route('/create'),
            'edit' => Pages\EditTrainingAlppication::route('/{record}/edit'),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->withoutGlobalScopes();
    }
}
