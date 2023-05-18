<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Hall;
use App\Models\User;
use Filament\Tables;
use App\Models\Event;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Config;
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\RelationManagers;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return   __('halls');
    }

    public static function getModelLabel(): string
    {
        return   __('events');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('events');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reasone')
                    ->label(__('reasone'))
                    ->required()
                    ->maxLength(255),
                Select::make('hall_id')
                    ->label(__('hall'))
                    ->options(Hall::all()
                        ->where('status', 1)
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\DateTimePicker::make('start')
                    ->label(__('start'))
                    ->withoutSeconds()
                    ->minutesStep(30)
                    ->required(),
                Forms\Components\DateTimePicker::make('end')
                    ->label(__('end'))
                    ->withoutSeconds()
                    ->minutesStep(30)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('id')),
                Tables\Columns\TextColumn::make('user.name')->sortable()->label(__('user')),
                Tables\Columns\TextColumn::make('hall.name')->sortable()->label(__('hall')),
                Tables\Columns\TextColumn::make('title')->label(__('title')),
                Tables\Columns\TextColumn::make('reasone')->label(__('reasone')),
                Tables\Columns\TextColumn::make('start')->label(__('start')),
                Tables\Columns\TextColumn::make('end')->label(__('end')),
                Tables\Columns\BadgeColumn::make('status')->enum([
                    0 => __('Waiting'),
                    1 => __('Approvied'),
                    2 => __('Rejected'),
                ])->label(__('status')),
                Tables\Columns\TextColumn::make('created_at')->label(__('created_at'))
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->label(__('updated_at'))
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')->label(__('status'))
                    ->multiple()
                    ->options([
                        0 => 'Waiting',
                        1 => 'Approvied',
                        2 => 'Rejected',
                    ]),
                SelectFilter::make('hall_id')->label(__('hall'))
                    ->multiple()
                    ->options(Hall::all()
                        ->where('status', 1)
                        ->pluck('name', 'id')),
                Filter::make('date')
                    ->form([
                        DatePicker::make('created_from')->label(__('filament::yc.created_from')),
                        DatePicker::make('created_until')->label(__('filament::yc.created_until')),
                    ])
                    ->label(__('filament::yc.date'))
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('approve')->action('approve')
                    ->action(function (Event $record) {
                        if ($record->status == 1) {
                            Notification::make()
                                ->title('This event already approved!')
                                ->danger()
                                ->send();
                            return;
                        }
                        $user = User::where('id', $record->user_id)->first();
                        if (Config::get('app.locale') == 'ar') {
                            $messageSms = "تم قبولك طلب حجزك للقاعة " . $record->hall->name . ' من ' . $record->start . ' الى ' . $record->end;
                        } else {
                            $messageSms = "Your " . $record->hall->name . " reservation request has been accepted from " . $record->start . ' till ' . $record->end;
                        }

                        $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                        $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . $user['phone'] . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');

                        Event::where('id', $record->id)->update(['status' => 1]);
                    })
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation(),

                Action::make('reject')->action('reject')
                    ->action(function (Event $record, array $data) {
                        if ($record->status == 2) {
                            Notification::make()
                                ->title('This event already rejected!')
                                ->danger()
                                ->send();
                            return;
                        }
                        $user = User::where('id', $record->user_id)->first();
                        if (Config::get('app.locale') == 'ar') {
                            $messageSms = "تم رفض طلب حجزك ل " . $record->hall->name;
                        } else {
                            $messageSms = "Your " . $record->hall->name . " reservation request has been rejected";
                        }

                        $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                        $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . $user['phone'] . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');

                        Event::where('id', $record->id)->update(['status' => 2]);
                    })
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                BulkAction::make('approve')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            // if ($record->status == 1) {
                            //     Notification::make()
                            //         ->title('This event already approved!' . $record->id)
                            //         ->danger()
                            //         ->send();
                            //     return;
                            // }
                            $user = User::where('id', $record->user_id)->first();
                            if (Config::get('app.locale') == 'ar') {
                                $messageSms = "تم قبولك طلب حجزك للقاعة " . $record->hall->name . ' من ' . $record->start . ' الى ' . $record->end;
                            } else {
                                $messageSms = "Your " . $record->hall->name . " reservation request has been accepted from " . $record->start . ' till ' . $record->end;
                            }

                            $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                            $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . $user['phone'] . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');

                            Event::where('id', $record->id)->update(['status' => 1]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation(),
                BulkAction::make('reject')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            // if ($record->status == 2) {
                            //     Notification::make()
                            //         ->title('This event already approved! ID is ' . $record->id)
                            //         ->danger()
                            //         ->send();
                            //     return;
                            // }
                            $user = User::where('id', $record->user_id)->first();
                            if (Config::get('app.locale') == 'ar') {
                                $messageSms = "تم رفض طلب حجزك ل " . $record->hall->name;
                            } else {
                                $messageSms = "Your " . $record->hall->name . " reservation request has been rejected";
                            }

                            $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                            $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . $user['phone'] . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');

                            Event::where('id', $record->id)->update(['status' => 2]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-x-circle')
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
