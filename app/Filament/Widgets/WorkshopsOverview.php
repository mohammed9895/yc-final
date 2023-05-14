<?php

namespace App\Filament\Widgets;

use App\Models\Slot;
use App\Models\Booking;
use App\Models\Workshop;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class WorkshopsOverview extends BaseWidget
{
    protected static ?int $sort = 3;

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    protected function getCards(): array
    {
        return [
            Card::make('Total Workshops', Workshop::count()),
            Card::make('Total Slots', Slot::count()),
            Card::make('Total Bookings', Booking::count()),
        ];
    }
}
