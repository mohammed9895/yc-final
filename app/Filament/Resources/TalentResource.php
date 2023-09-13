<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TalentResource\Pages;
use App\Filament\Resources\TalentResource\RelationManagers;
use App\Models\Booking;
use App\Models\Talent;
use App\Models\TalentType;
use App\Models\User;
use App\Notifications\SmsMessage;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Tables\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class TalentResource extends Resource
{
    protected static ?string $model = Talent::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make(__('General Information'))
                        ->schema([
                            Forms\Components\Select::make('user_id')
                                ->label(__('User'))
                                ->options(User::all()->pluck('name', 'id'))
                                ->searchable()
                                ->getSearchResultsUsing(fn (string $search) => User::where('email', 'like', "%{$search}%")->limit(10)->pluck('name', 'id'))
                                ->label('User')
                                ->required(),
                            Select::make('talent_type_id')
                                ->label(__('Talent Type'))
                                ->searchable()
                                ->options(TalentType::pluck('name', 'id'))
                                ->required(),
                            TextInput::make('talent_sub_type')
                                ->label(__('Talent Sub Type'))
                                ->required(),
                            TextInput::make('purpose')->required(),
                        ]),
                    Wizard\Step::make(__('Video and Images'))
                        ->schema([
                            FileUpload::make('video')
                                ->panelAspectRatio('2:1')
                                ->required(),
                            FileUpload::make('personal_image')->required()->image(),
                        ]),
                    Wizard\Step::make(__('Contact Information'))
                        ->schema([
                            TextInput::make('phone')->required()->tel(),
                            TextInput::make('email')->required()->email(),
                            TagsInput::make('social_media_links')->required(),
                        ]),
                ])
                    ->columns(1)
                    ->columnSpanFull()
                    ->submitAction(new HtmlString(html: '
                        <button type="submit" class="filament-button filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2rem] px-3 text-sm text-white shadow focus:ring-white border-transparent bg-manjam_primary hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">Register Now
                        </button>')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn ($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('talentType.name'),
                Tables\Columns\TextColumn::make('talent_sub_type'),
                Tables\Columns\TextColumn::make('purpose'),
                Tables\Columns\ImageColumn::make('personal_image'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('talent_type_id')->options(TalentType::all()->pluck('name', 'id'))->searchable()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Interview')
                    ->action(function (Talent $record, array $data) {
                    $user = User::where('id', $record->user_id)->first();
                    $sms = new SmsMessage;
                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('أهلا بصديق المركز ' . $user->name . 'يسرنا اعلامك بأنك تم اختيار اسمك لإجراء مقابلة لبرنامج منجم المواهب بتاريخ ' . $data['date_time'])
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello friend ' . $user->name . ' We are pleased to inform you that you have been accepted for interview in Talent Manjam in ' .  $data['date_time'])
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    $record->update(['status' => 1]);
                })
                    ->hidden(fn (Talent $record) => $record->status === 1)
                    ->color('warning')
                    ->icon('heroicon-o-check-circle')
                ->form([
                    Forms\Components\DateTimePicker::make('date_time'),
                ]),
                Action::make('Reject')->action(function (Talent $record) {
                    $user = User::where('id', $record->user_id)->first();
                    $sms = new SmsMessage;
                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('أهلا بصديق المركز ' . $user->name . 'يؤسفنا اعلامك بأن لم يتم قبولك في برنامج منجم للمواهب')
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello friend ' . $user->name . 'We are sorry to inform you that you have been rejected from Talent Manjam Program')
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    $record->update(['status' => 3]);
                })->color('danger')
                    ->hidden(fn (Talent $record) => $record->status === 3)
                    ->icon('heroicon-o-x-circle'),
                Action::make('Publish')->action(function (Talent $record) {
                    $user = User::where('id', $record->user_id)->first();
                    $sms = new SmsMessage;
                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('أهلا بصديق المركز ' . $user->name . 'يسرنا اعلامك بأنك تم اختيارك لبرنامج منجم المواهب')
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Hello friend ' . $user->name . 'We are pleased to inform you that you have been accepted for Talent Manjam Program')
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    $record->update(['status' => 2]);
                })
                    ->color('success')
                    ->hidden(fn (Talent $record) => $record->status === 2)
                    ->icon('heroicon-o-check-circle'),
            ])
            ->bulkActions([
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
            'index' => Pages\ListTalent::route('/'),
            'create' => Pages\CreateTalent::route('/create'),
            'edit' => Pages\EditTalent::route('/{record}/edit'),
        ];
    }
}
