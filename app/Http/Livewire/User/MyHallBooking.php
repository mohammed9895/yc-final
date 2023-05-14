<?php

namespace App\Http\Livewire\User;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class MyHallBooking extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return Event::query()->where('user_id', '=', Auth::id());
    }
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('title')->label(__('Title')),
            TextColumn::make('hall.name')->weight('bold')->label(__('hall')),
            BadgeColumn::make('status')->label(__('status'))
                ->enum([
                    0 => __('Waiting'),
                    2 => __('Rejected'),
                    1 => __('Approvied')
                ])
                ->colors([
                    'warning' => static fn ($state): bool => $state === 0,
                    'success' => static fn ($state): bool => $state === 1,
                    'danger' => static fn ($state): bool => $state === 2,
                ]),
            TextColumn::make('start')->label(__('start_date'))
                ->dateTime('M d, Y h:i'),
            TextColumn::make('end')->label(__('end_date'))
                ->dateTime('M d, Y h:i'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

    public function render()
    {
        return view('livewire.user.my-hall-booking');
    }
}
