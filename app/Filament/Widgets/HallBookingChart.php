<?php

namespace App\Filament\Widgets;

use App\Models\Hall;
use Filament\Widgets\PieChartWidget;

class HallBookingChart extends PieChartWidget
{
    protected static ?string $heading = 'Hall Booking';

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    public ?string $filter = null;

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        if ($activeFilter !== null) {
            $data = Hall::withCount('events')->where('id', $activeFilter)->get();
        } else {
            $data = Hall::withCount('events')->get();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Bookings',
                    'data' => $data->map(fn ($hall) => $hall->events_count),
                    'backgroundColor' => $data->map(fn ($hall) => $hall->backgroundColor),
                ],
            ],
            'labels' => $data->map(fn ($hall) => $hall->name),
        ];
    }

    protected function getFilters(): ?array
    {
        return Hall::all()->pluck('name', 'id')->toArray();
    }
}
