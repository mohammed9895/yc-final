<?php

namespace App\Filament\Widgets;

use Closure;
use App\Models\Hall;
use Filament\Tables;
use App\Models\Event;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestEvents extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    protected function getTableQuery(): Builder
    {
        return Event::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('user.name'),
            Tables\Columns\TextColumn::make('hall.name'),
            Tables\Columns\TextColumn::make('created_at')->since(),
        ];
    }
    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('hall_id')
                ->label('Hall')
                ->options(Hall::all()->pluck('name', 'id'))
                ->searchable()
        ];
    }
}
