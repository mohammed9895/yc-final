<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CybersecurityResource\Pages;
use App\Filament\Resources\CybersecurityResource\RelationManagers;
use App\Models\Cybersecurity;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class CybersecurityResource extends Resource
{
    protected static ?string $model = Cybersecurity::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Checkbox::make('tried_linux')
                    ->label('Have you tried working on Linux systems in the past?'),

                Checkbox::make('passionate_cyber_security')
                    ->label('Are you passionate about learning cyber security and the Linux operating system?'),

                Select::make('academic_professional_status')
                    ->label('What is your current academic or professional status?')
                    ->options([
                        'diploma_holder' => 'Diploma holder',
                        'senior_year_student' => 'Senior year student',
                        'fresh_graduate' => 'Fresh graduate',
                        'cyber_analyst' => 'Cyber analyst',
                        'other' => 'Other',
                    ]),

                Select::make('linux_expertise')
                    ->label('Evaluate your expertise in Linux fundamentals.')
                    ->options([
                        'zero_knowledge' => 'Zero knowledge',
                        'low_knowledge' => 'Low knowledge',
                        'medium_knowledge' => 'Medium knowledge',
                        'high_knowledge' => 'High knowledge',
                    ]),

                Checkbox::make('participated_in_workshops')
                    ->label('Have you participated in any cyber security workshops?'),

                Textarea::make('significant_project_description')
                    ->label('Please describe your most significant project related to Linux.')
                    ->maxLength(600),

                Textarea::make('motivation_participation')
                    ->label('What motivated you to participate in this program?')
                    ->maxLength(600),

                Textarea::make('reason_for_opportunity')
                    ->label('Why do you believe you deserve this opportunity?')
                    ->maxLength(600),
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
                Tables\Columns\BooleanColumn::make('tried_linux')
                    ->label('Tried Linux'),
                Tables\Columns\BooleanColumn::make('passionate_cyber_security')
                    ->label('Passionate about Cyber Security'),
                Tables\Columns\TextColumn::make('academic_professional_status')
                    ->label('Academic/Professional Status')
                    ->enum([
                        'diploma_holder' => 'Diploma holder',
                        'senior_year_student' => 'Senior year student',
                        'fresh_graduate' => 'Fresh graduate',
                        'cyber_analyst' => 'Cyber analyst',
                        'other' => 'Other',
                    ]),
                Tables\Columns\TextColumn::make('linux_expertise')
                    ->label('Linux Expertise')
                    ->enum([
                        'zero_knowledge' => 'Zero knowledge',
                        'low_knowledge' => 'Low knowledge',
                        'medium_knowledge' => 'Medium knowledge',
                        'high_knowledge' => 'High knowledge',
                    ]),
                Tables\Columns\BooleanColumn::make('participated_in_workshops')
                    ->label('Participated in Workshops'),
                Tables\Columns\TextColumn::make('significant_project_description')
                    ->label('Significant Project')
                    ->limit(50), // Truncate to show a preview
                Tables\Columns\TextColumn::make('motivation_participation')
                    ->label('Motivation')
                    ->limit(50), // Truncate to show a preview
                Tables\Columns\TextColumn::make('reason_for_opportunity')
                    ->label('Reason for Opportunity')
                    ->limit(50), // Truncate to show a preview
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCybersecurities::route('/'),
            'create' => Pages\CreateCybersecurity::route('/create'),
            'edit' => Pages\EditCybersecurity::route('/{record}/edit'),
        ];
    }
}
