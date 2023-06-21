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
use App\Notifications\SmsMessage;
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
use Filament\Forms\Components\Select;

class BookingResource extends Resource
{
    // use HasPageShield;
    public $answer;
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected $listeners = ['downloadAnswerFile' => 'download'];

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 0)->count();
    }

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
                Tables\Columns\TextColumn::make('user.phone')
                    ->label(__('filament::users.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label(__('filament::users.email'))
                    ->searchable(),
//                TextColumn::make('answers'),
                Tables\Columns\TextColumn::make('reasone')->label(__('reasone'))->searchable(),
                // Tables\Columns\TextColumn::make('answers')->label(__('answers'))->searchable(),
                Tables\Columns\TextColumn::make('rejection_message')->label(__('rejection_message')),
                Tables\Columns\BadgeColumn::make('status')->label(__('status'))->enum([
                    0 => __('Waiting'),
                    1 => __('Rejected'),
                    2 => __('Approvied'),
                    3 => __('canceled')
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
                        2 => __('Approvied'),
                        3 => __('canceled')
                    ]),
                SelectFilter::make('workshop_id')
                    ->multiple()
                    ->label(__('Workshop'))
                    ->options(Workshop::all()->pluck('title', 'id')),
                SelectFilter::make('slot_id')
                    ->multiple()
                    ->label(__('Slot'))
                    ->options(Slot::all()->pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('approve')->action('approve')
                    ->label(__('approve'))
                    ->action(function (Booking $record) {
                        $user = User::where('id', $record->user_id)->first();
                        $slot = Slot::where('id', '=', $record->slot_id)->first();
                        $workshop = Workshop::where('id', '=', $record->workshop_id)->first();
                        $sms = new SmsMessage;
                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message('أهلا بصديق المركز ' . $user->name . ' يسرنا إعلامك بقبولك في برنامج (' . $workshop->getTranslation('title', 'ar') . '). نحن بانتظارك في (' . $slot['start_date'] . ') تبدأ الورشة (' . $slot['start_time'] . ')')
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message('Hello friend ' . $user->name . ' We are pleased to inform you that you have been accepted into the (' . $workshop->getTranslation('title', 'en') . ') program. We are waiting for you on (' . $slot['start_date'] . ') The workshop begins (' . $slot['start_time'] . ')')
                                ->lang($user->preferred_language)
                                ->send();
                        }
                        Booking::where('id', $record->id)->update(['status' => 2]);
                    })
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn (Booking $record) => $record->status === 2)
                    ->requiresConfirmation(),

                Action::make('reject')->action('reject')
                    ->label(__('reject'))
                    ->action(function (Booking $record, array $data) {
                        $user = User::where('id', $record->user_id)->first();
                        $slot = Slot::where('id', '=', $record->slot_id)->first();
                        $workshop = Workshop::where('id', '=', $record->workshop_id)->first();

                        $sms = new SmsMessage;



                        if ($user->preferred_language == 'en') {
                            if ($data['rejection_reason'] == 'full') {
                                $sms->to($user->phone)
                                    ->message('Hello friend ' . $user->name . ' Thank you for registering in the (' . $workshop->getTranslation('title', 'en') . ') program. We apologize for not accepting you among the participants due to the wide demand for registration and the completion of the specified number of the program. See you soon on our next shows.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('Welcome, ' . $user->name . '. Since you did not meet the admission requirements, we regret to inform you that you were not accepted into the (' . $workshop->getTranslation('title', 'en') . ') program.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }
                        } else {
                            if ($data['rejection_reason'] == 'full') {
                                $sms->to($user->phone)
                                    ->message('أهلا بصديق المركز ' . $user->name . ' شكرً لتسجيلك في برنامج (' . $workshop->getTranslation('title', 'ar') . '). نعتذر لك لعدم قبولك ضمن المشاركين فيها نظرا للإقبال الواسع في التسجيل و اكتمال العدد المحدد للبرنامج. نراك قريبًا في برامجنا القادمة.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('أهلا بصديق المركز ' . $user->name . ' شكرً لتسجيلك في برنامج (' . $workshop->getTranslation('title', 'ar') . '). نظرا لعدم استيفائك لشروط القبول يؤسِفنا إبلاغك بعدم قبولك في برنامج')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }
                        }

                        Booking::where('id', $record->id)->update(['status' => 1, 'rejection_message' => $data['rejection_reason']]);
                    })
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->hidden(fn (Booking $record) => $record->status === 1)
                    ->form([
                        Select::make('rejection_reason')->required()
                            ->label(__('rejection_reason'))
                            ->options([
                                'full' => __('Fully Booked'),
                                'not_fit' => __('Not meeting the conditions')
                            ])
                    ]),
                Action::make('cancel')
                    ->label(__('cancel'))
                    ->action('cancel')
                    ->action(function (Booking $record, array $data) {
                        $workshop = Workshop::where('id', $record->workshop_id)->first();
                        $user = User::where('id', $record->user_id)->first();

                        $sms = new SmsMessage;

                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message('تم الغاء حجزك في  ' . $workshop->getTranslation('title', 'ar'))
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message('Your reservation for ' . $workshop->getTranslation('title', 'en') . ' has been canceled')
                                ->lang($user->preferred_language)
                                ->send();
                        }
                        Booking::where('id', $record->id)->update(['status' => 3]);
                    })
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->hidden(fn (Booking $record) => $record->status === 3),
                Action::make('show_answers')
                    ->action(function(Booking $record, array $data) {

                    })
                    ->color('warning')
                    ->modalContent(fn ($record) => view('filament.custom.answers', ['record'=> $record]))
                    ->hidden(fn (Booking $record) => $record->answers === [])
            ])
            ->bulkActions([
                BulkAction::make('approve')
                    ->label(__('approve'))
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $user = User::where('id', $record->user_id)->first();
                            $slot = Slot::where('id', '=', $record->slot_id)->first();
                            $workshop = Workshop::where('id', '=', $record->workshop_id)->first();

                            $sms = new SmsMessage;
                            if ($user->preferred_language == 'ar') {
                                $sms->to($user->phone)
                                    ->message('أهلا بصديق المركز ' . $user->name . ' يسرنا إعلامك بقبولك في برنامج (' . $workshop->getTranslation('title', 'ar') . '). نحن بانتظارك في (' . $slot['start_date'] . ') تبدأ الورشة (' . $slot['start_time'] . ')')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('Hello friend ' . $user->name . ' We are pleased to inform you that you have been accepted into the (' . $workshop->getTranslation('title', 'en') . ') program. We are waiting for you on (' . $slot['start_date'] . ') The workshop begins (' . $slot['start_time'] . ')')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }

                            Booking::where('id', $record->id)->update(['status' => 2]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation(),
                BulkAction::make('reject')
                    ->label(__('reject'))
                    ->action(function (Collection $records, array $data) {
                        foreach ($records as $record) {
                            $user = User::where('id', $record->user_id)->first();
                            $slot = Slot::where('id', '=', $record->slot_id)->first();
                            $workshop = Workshop::where('id', '=', $record->workshop_id)->first();

                            $sms = new SmsMessage;
                            if ($user->preferred_language == 'en') {
                                if ($data['rejection_reason'] == 'full') {
                                    $sms->to($user->phone)
                                        ->message('Hello friend ' . $user->name . ' Thank you for registering in the (' . $workshop->getTranslation('title', 'en') . ') program. We apologize for not accepting you among the participants due to the wide demand for registration and the completion of the specified number of the program. See you soon on our next shows.')
                                        ->lang($user->preferred_language)
                                        ->send();
                                } else {
                                    $sms->to($user->phone)
                                        ->message('Welcome, ' . $user->name . '. Since you did not meet the admission requirements, we regret to inform you that you were not accepted into the (' . $workshop->getTranslation('title', 'en') . ') program.')
                                        ->lang($user->preferred_language)
                                        ->send();
                                }
                            } else {
                                if ($data['rejection_reason'] == 'full') {
                                    $sms->to($user->phone)
                                        ->message('أهلا بصديق المركز ' . $user->name . ' شكرً لتسجيلك في برنامج (' . $workshop->getTranslation('title', 'ar') . '). نعتذر لك لعدم قبولك ضمن المشاركين فيها نظرا للإقبال الواسع في التسجيل و اكتمال العدد المحدد للبرنامج. نراك قريبًا في برامجنا القادمة.')
                                        ->lang($user->preferred_language)
                                        ->send();
                                } else {
                                    $sms->to($user->phone)
                                        ->message('أهلا بصديق المركز ' . $user->name . ' شكرً لتسجيلك في برنامج (' . $workshop->getTranslation('title', 'ar') . '). نظرا لعدم استيفائك لشروط القبول يؤسِفنا إبلاغك بعدم قبولك في برنامج')
                                        ->lang($user->preferred_language)
                                        ->send();
                                }
                            }
                            Booking::where('id', $record->id)->update(['status' => 1]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Select::make('rejection_reason')->required()
                            ->label(__('rejection_reason'))
                            ->options([
                                'full' => __('Fully Booked'),
                                'not_fit' => __('Not meeting the conditions')
                            ])
                    ]),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    public function download() {
       ray('test');
    }
}
