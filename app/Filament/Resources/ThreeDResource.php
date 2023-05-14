<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\ThreeD;
use App\Channels\SmsChannel;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Notifications\SmsMessage;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Config;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\OmantelSMSNotification;
use App\Filament\Resources\ThreeDResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ThreeDResource\RelationManagers;

class ThreeDResource extends Resource
{
    protected static ?string $model = ThreeD::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('User'))
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Textarea::make('file_description')
                    ->label(__('File Description'))
                    ->required(),
                TimePicker::make('duration')->label(__('duration'))->required(),
                TextInput::make('weight')->label('weight')->required(),
                TextInput::make('purpose')->label('purpose')->required(),
                Select::make('status')
                    ->options([
                        0 => __('Waiting'),
                        1 => __('Rejected'),
                        2 => __('Approvied')
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label(__('User')),
                TextColumn::make('file_description')->label(__('File Description')),
                TextColumn::make('duration')->label(__('File Description')),
                TextColumn::make('weight')->label('weight'),
                TextColumn::make('purpose')->label('purpose'),
                Tables\Columns\BadgeColumn::make('status')->label(__('status'))->enum([
                    0 => __('Waiting'),
                    1 => __('Rejected'),
                    2 => __('Approvied')
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('approve')
                    ->label(__('approve'))
                    ->action('approve')
                    ->action(function (ThreeD $record) {
                        $user = User::where('id', $record->user_id)->first();

                        $sms = new SmsMessage;

                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message('تم قبول حجزك لمختبر طباعة ثلاثية الأبعاد')
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message('Your reservation for a 3D printing lab has been accepted')
                                ->lang($user->preferred_language)
                                ->send();
                        }

                        ThreeD::where('id', $record->id)->update(['status' => 2]);
                    })
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    // ->hidden(fn (ThreeD $record) => $record->status === 2)
                    ->requiresConfirmation(),
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
            'index' => Pages\ListThreeDS::route('/'),
            'create' => Pages\CreateThreeD::route('/create'),
            'edit' => Pages\EditThreeD::route('/{record}/edit'),
        ];
    }
}
