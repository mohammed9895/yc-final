<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Slot;
use App\Models\User;
use Filament\Tables;
use App\Models\Booking;
use App\Models\Workshop;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\BookingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use App\Filament\Resources\BookingResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

class BookingResource extends Resource
{
    // use HasPageShield;
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public static function getModelLabel(): string
    {
        return   __('bookings');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('bookings');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('workshop_id')->options(Workshop::all()->pluck('title', 'id'))->searchable()
                    ->label(__('Workshop'))
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('slot_id', null))
                    ->required(),
                Forms\Components\Select::make('slot_id')
                    ->label(__('slot'))
                    ->options(function (callable $get) {
                        $workshop = Workshop::find($get('workshop_id'));
                        if (!$workshop) {
                            return null;
                        }
                        return $workshop->slots->pluck('name', 'id');
                    })
                    ->searchable()
                    ->label('Slot')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label(__('User'))
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()->label('User')
                    ->required(),
                Forms\Components\TextInput::make('reasone')
                    ->label(__('updated_at'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rejection_message')
                    ->label(__('updated_at'))
                    ->maxLength(255),
                Forms\Components\Select::make('status')->options([
                    0 => 'Waiting',
                    1 => 'Rejected',
                    2 => 'Approvied'
                ])->searchable()
                    ->label(__('status'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('workshop.title')->label(__('Workshop'))->searchable(),
                Tables\Columns\TextColumn::make('slot.name')->label(__('slot'))->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn ($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('reasone')->label(__('reasone'))->searchable(),
                Tables\Columns\TextColumn::make('answers')->label(__('answers'))->searchable(),
                Tables\Columns\TextColumn::make('rejection_message')->label(__('rejection_message')),
                Tables\Columns\BadgeColumn::make('status')->label(__('status'))->enum([
                    0 => __('Waiting'),
                    1 => __('Rejected'),
                    2 => __('Approvied')
                ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('status'))
                    ->multiple()
                    ->options([
                        0 => __('Waiting'),
                        1 => __('Rejected'),
                        2 => __('Approvied')
                    ]),
                    SelectFilter::make('workshop_id')
                    ->multiple()
                    ->label(__('Workshop'))
                    ->options(Workshop::all()->pluck('title', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('approve')->action('approve')
                    ->action(function (Booking $record) {
                        $user = User::where('id', $record->user_id)->first();
                        $slot = Slot::where('id', '=', $record->slot_id)->first();
                        $workshop = Workshop::where('id', '=', $record->workshop_id)->first();
                        if (Config::get('app.locale') == 'ar') {
                            $messageSms = "تم قبولك في " . $slot['name'] . ' الموافق ' . $slot['start_date'] . ' تبدأ الورشة في الساعة ' . $slot['start_time'] . ' الى ' . $slot['end_time'] . ' في برنامج ' . $workshop['title'];
                        } else {
                            $messageSms = "Your request have been approved on " . $slot['name'] . ' on ' . $slot['start_date'] . ' workshop start at' . $slot['start_time'] . ' till ' . $slot['end_time'] . ' on ' . $workshop['title'];
                        }

                        $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                        $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . $user['phone'] . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');

                        Booking::where('id', $record->id)->update(['status' => 2]);
                    })
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn (Booking $record) => $record->status === 2)
                    ->requiresConfirmation(),
                // Action::make('answers')
                //     ->action(fn (Booking $record) => null),
                Action::make('reject')->action('reject')
                    ->action(function (Booking $record, array $data) {
                        $user = User::where('id', $record->user_id)->first();
                        $slot = Slot::where('id', '=', $record->slot_id)->first();
                        $workshop = Workshop::where('id', '=', $record->workshop_id)->first();
                        if (Config::get('app.locale') == 'ar') {
                            $messageSms = $data['rejection_message_ar'] . ' ' . $workshop['title'];
                        } else {
                            $messageSms =  $data['rejection_message_en'] . ' ' . $workshop['title'];
                        }

                        $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                        $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . $user['phone'] . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');

                        Booking::where('id', $record->id)->update(['status' => 1, 'rejection_message' => $messageSms]);
                    })
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->hidden(fn (Booking $record) => $record->status === 1)
                    ->form([
                        Forms\Components\Textarea::make('rejection_message_ar')
                            ->label('Rejection Message Arabic')
                            ->required(),
                        Forms\Components\Textarea::make('rejection_message_en')
                            ->label('Rejection Message English')
                            ->required(),
                    ]),
            ])
            ->bulkActions([
                BulkAction::make('approve')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $user = User::where('id', $record->user_id)->first();
                            $slot = Slot::where('id', '=', $record->slot_id)->first();
                            $workshop = Workshop::where('id', '=', $record->workshop_id)->first();
                            if (Config::get('app.locale') == 'ar') {
                                $messageSms = "تم قبولك في " . $slot['name'] . ' الموافق ' . $slot['start_date'] . ' تبدأ الورشة في الساعة ' . $slot['start_time'] . ' الى ' . $slot['end_time'] . ' في برنامج ' . $workshop['title'];
                            } else {
                                $messageSms = "Your request have been approved on " . $slot['name'] . ' on ' . $slot['start_date'] . ' workshop start at' . $slot['start_time'] . ' till ' . $slot['end_time'] . ' on ' . $workshop['title'];
                            }

                            $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                            $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . $user['phone'] . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');
                            Booking::where('id', $record->id)->update(['status' => 2]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation(),
                BulkAction::make('reject')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $user = User::where('id', $record->user_id)->first();
                            $slot = Slot::where('id', '=', $record->slot_id)->first();
                            $workshop = Workshop::where('id', '=', $record->workshop_id)->first();
                            if (Config::get('app.locale') == 'ar') {
                                $messageSms = "نظرًا للإقبال الواسع في التسجيل وإكتمال العدد المحدد للبرنامج يؤسِفنا إبلاغك بعدم قبولك في في برنامج "  . $workshop['title'];
                            } else {
                                $messageSms = "Due to the high demand for registration and the completion of the specified number of the program, we regret to inform you that you have not been accepted into the program " . $workshop['title'];
                            }

                            $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                            $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . $user['phone'] . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');
                            Booking::where('id', $record->id)->update(['status' => 1]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Forms\Components\TextArea::make('rejection_message')
                            ->label('Rejection Message')
                            ->required(),
                    ]),
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
