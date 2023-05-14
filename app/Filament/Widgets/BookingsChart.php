<?php

namespace App\Filament\Widgets;

use App\Models\Place;
use App\Models\Booking;
use App\Models\Workshop;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\Auth;

class BookingsChart extends BarChartWidget
{
    protected static ?string $heading = 'Booking';

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = null;

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        if ($activeFilter !== null) {
            $data = Workshop::withCount('bookings')->where('place_id', $activeFilter)->get();
        } else {
            $data = Workshop::withCount('bookings')->get();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Bookings',
                    'data' => $data->map(fn ($workshop) => $workshop->bookings_count),
                    'backgroundColor' => '#a855f7',
                ],
            ],
            'labels' => $data->map(fn ($workshop) => $workshop->title),
        ];
    }

    protected function getFilters(): ?array
    {
        return Place::all()->pluck('name', 'id')->toArray();
    }
}
