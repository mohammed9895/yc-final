<?php

namespace App\Filament\Pages;

use App\Models\Field;
use Filament\Pages\Page;
use App\Models\Freelancers;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class RegisterAsFreelancer extends Page implements HasForms, HasTable
{
    use InteractsWithForms,  InteractsWithTable;

    public function getTitle(): string
    {
        return   __('Register as Freelancer');
    }

    protected static function getNavigationLabel(): string
    {
        return   __('Register as Freelancer');
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.register-as-freelancer';

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('civil_copy')
                ->label(__('Civil Copy'))
                ->enableDownload()
                ->required(),
            Select::make('field_id')
                ->label(__('Field'))
                ->options(Field::where('type', 'freelancer')
                    ->pluck('name', 'id'))
                ->searchable()
                ->required(),
            FileUpload::make('cr_copy')
                ->enableDownload()
                ->label(__('cr_copy')),
            FileUpload::make('profile_file')
                ->label(__('Work Files'))
                ->enableDownload()
                ->multiple(),
            TextInput::make('profile_link')
                ->label(__('Profile Link')),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Freelancers::query()->where('user_id', auth()->id());
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user.name')->label(__('User')),
            TextColumn::make('field.name')->label(__('Field')),
            TextColumn::make('profile_link')->label(__('Profile Link')),
            TextColumn::make('created_at')
                ->dateTime(),
            TextColumn::make('updated_at')
                ->dateTime(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('delete')
                ->label(__('delete'))
                ->action('delete')
                ->action(function (Freelancers $record, array $data) {
                    $record->delete();
                })
                ->icon('heroicon-o-trash')
                ->color('danger')
        ];
    }

    public function register()
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = auth()->id();
        $booking = Freelancers::create($orginal);
        return Notification::make()
            ->title(__('Booked Successfuly'))
            ->success()
            ->send();
    }
}
