<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\TamkeenResource\Pages;
use App\Filament\Resources\TamkeenResource\RelationManagers;
use App\Models\Tamkeen;
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
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TamkeenResource extends Resource
{
    protected static ?string $model = Tamkeen::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('user.email')->label(__('email')),
                Tables\Columns\TextColumn::make('user.phone')->label(__('phone')),
                Tables\Columns\TextColumn::make('user.province.name')->label(__('province')),
                Tables\Columns\TextColumn::make('user.state.name')->label(__('state')),
                TextColumn::make('user.birth_date')->label(__('Age'))->formatStateUsing(fn(string $state
                ): string => Carbon::parse($state)->age),
//                Tables\Columns\TagsColumn::make('social_media_accounts'),
                Tables\Columns\TextColumn::make('linkedin_account'),
                Tables\Columns\TextColumn::make('skill'),
                Tables\Columns\TextColumn::make('primary_skill'),
//                Tables\Columns\TagsColumn::make('other_skill'),
                Tables\Columns\TextColumn::make('program_goals'),
                Tables\Columns\TextColumn::make('how_did_you_discover_your_skill'),
                Tables\Columns\TextColumn::make('skill_practice_duration')->date(),
                Tables\Columns\TextColumn::make('awards_certificates'),
                Tables\Columns\TextColumn::make('earned_income'),
                Tables\Columns\TextColumn::make('freelance_experience_years'),
                Tables\Columns\TextColumn::make('freelance_experience_level'),
                Tables\Columns\TextColumn::make('skill_level'),
                Tables\Columns\TextColumn::make('clients_worked_with'),
                Tables\Columns\TextColumn::make('financial_earnings'),
//                Tables\Columns\TagsColumn::make('achievements'),
                Tables\Columns\TextColumn::make('development_plan'),
                Tables\Columns\TextColumn::make('can_manage_projects')->enum(
                    [
                        1 => 'Yes',
                        0 => 'No'
                    ]
                ),
                Tables\Columns\TextColumn::make('can_price_services_and_market_self')->enum(
                    [
                        1 => 'Yes',
                        0 => 'No'
                    ]
                ),
                Tables\Columns\TextColumn::make('self_marketing_strategy'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('skill')->options([
                    'المجال العلمي' => 'المجال العلمي',
                    'المجال الفني' => 'المجال الفني',
                    'المجال الهندسي' => 'المجال الهندسي',
                    'المجال الإعلامي' => 'المجال الإعلامي',
                    'المجال الكتابي' => 'المجال الكتابي',
                    'مجال البرمجيات' => 'مجال البرمجيات',
                    'مجال التسويق' => 'مجال التسويق',
                    'مجال التصميم' => 'مجال التصميم',
                    'المجال الحرفي' => 'المجال الحرفي',
                    'مجال التصوير' => 'مجال التصوير',
                    'مجال التجميل' => 'مجال التجميل',
                    'مجال الأزياء' => 'مجال الأزياء',
                    'المجال التقني' => 'المجال التقني',
                    'مجالات أخرى' => 'مجالات أخرى',
                ]),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Approve')
                    ->label(__('Approve'))
                    ->action('approve')
                    ->action(function (Tamkeen $record, array $data) {
                        $user = User::where('id', $record->user_id)->first();

                        $sms = new SmsMessage;

                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message('عزيزنا المسجل تم قبولك في برنامج تمكّن ،
ننتظرك في أول ورشة تعريفية بتاريخ  23 أكتوبر ( عبر منصة الزوم)  ، وذلك في تمام  الساعة ٤:٠٠ مساءً  .')
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message('Dear participant, We are delighted to inform you that you have been accepted in Tamakon program. We look forward to seeing you at the orientation workshop on 23 October (via Zoom) at 4:00 PM.')
                                ->lang($user->preferred_language)
                                ->send();
                        }
                    })
                    ->icon('heroicon-o-trash')
                    ->color('success'),
            ])
            ->bulkActions([
                FilamentExportBulkAction::make('export'),
                BulkAction::make('approve')
                    ->label(__('Approve'))
                    ->action(function (Collection $records, array $data) {
                        $sms = new SmsMessage;
                        foreach ($records as $record) {
                            $user = User::where('id', $record->user_id)->first();
                            if ($user->preferred_language == 'ar') {
                                $sms->to($user->phone)
                                    ->message('عزيزنا المسجل تم قبولك في برنامج تمكّن ،
ننتظرك في أول ورشة تعريفية بتاريخ  23 أكتوبر ( عبر منصة الزوم)  ، وذلك في تمام  الساعة ٤:٠٠ مساءً  .')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('Dear participant, We are delighted to inform you that you have been accepted in Tamakon program. We look forward to seeing you at the orientation workshop on 23 October (via Zoom) at 4:00 PM.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->color('success'),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TagsInput::make('social_media_accounts')->required(),
                Forms\Components\TextInput::make('linkedin_account')->required(),
                Forms\Components\FileUpload::make('resume_attachment')->required(),
                Forms\Components\FileUpload::make('profile_picture_attachment'),
                Forms\Components\Select::make('skill')->options([
                    'المجال العلمي' => 'المجال العلمي',
                    'المجال الفني' => 'المجال الفني',
                    'المجال الهندسي' => 'المجال الهندسي',
                    'المجال الإعلامي' => 'المجال الإعلامي',
                    'المجال الكتابي' => 'المجال الكتابي',
                    'مجال البرمجيات' => 'مجال البرمجيات',
                    'مجال التسويق' => 'مجال التسويق',
                    'مجال التصميم' => 'مجال التصميم',
                    'المجال الحرفي' => 'المجال الحرفي',
                    'مجال التصوير' => 'مجال التصوير',
                    'مجال التجميل' => 'مجال التجميل',
                    'مجال الأزياء' => 'مجال الأزياء',
                    'المجال التقني' => 'المجال التقني',
                    'مجالات أخرى' => 'مجالات أخرى',
                ])
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('primary_skill')->required(),
                Forms\Components\TagsInput::make('other_skill'),
                Forms\Components\TextInput::make('program_goals')->required(),
                Forms\Components\TextInput::make('how_did_you_discover_your_skill')->required(),
                Forms\Components\TextInput::make('skill_practice_duration')->required(),
                Forms\Components\TextInput::make('awards_certificates')->required(),
                Forms\Components\TextInput::make('earned_income')->required(),
                Forms\Components\TextInput::make('freelance_experience_years')->required(),
                Forms\Components\Select::make('freelance_experience_level')->options([
                    'Beginner' => __('Beginner'),
                    'Intermediate' => __('Intermediate'),
                    'Expert' => __('Expert'),
                ])->required()->searchable(),
                Forms\Components\Select::make('skill_level')->options([
                    'Beginner' => __('Beginner'),
                    'Intermediate' => __('Intermediate'),
                    'Expert' => __('Expert'),
                ])->required()->searchable(),
                Forms\Components\TextInput::make('clients_worked_with')->required(),
                Forms\Components\TextInput::make('financial_earnings')->required(),
                Forms\Components\TagsInput::make('achievements')->required(),
                Forms\Components\Textarea::make('development_plan')->required(),
                Forms\Components\Select::make('can_manage_projects')
                    ->options([
                        0 => 'No',
                        1 => 'Yes'
                    ])->required()->searchable(),
                Forms\Components\Select::make('can_price_services_and_market_self')
                    ->options([
                        0 => 'No',
                        1 => 'Yes'
                    ])->required()->searchable(),
                Forms\Components\Textarea::make('self_marketing_strategy'),
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
            'index' => Pages\ListTamkeens::route('/'),
            'create' => Pages\CreateTamkeen::route('/create'),
            'edit' => Pages\EditTamkeen::route('/{record}/edit'),
        ];
    }
}
