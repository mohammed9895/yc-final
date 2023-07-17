<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\LineChartWidget;

class UsersChart extends LineChartWidget
{
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = 'today';


    protected function getHeading(): string
    {
        return 'Users';
    }

    protected function getData(): array
    {



        $activeFilter = $this->filter;

        if ($activeFilter == 'week') {
            $startDate =now()->startOfWeek()->subWeek();
            $endDate = now()->endOfWeek()->subWeek();
            $data = Trend::model(User::class)
                ->between(
                    start: $startDate,
                    end: $endDate,
                )
                ->perDay()
                ->count();
        }
        else if ($activeFilter == 'today') {
            $startDate = now()->startOfDay();
            $endDate = now();
            $data = Trend::model(User::class)
                ->between(
                    start: $startDate,
                    end: $endDate,
                )
                ->perHour()
                ->count();
        }
        else if ($activeFilter == 'month') {
            $startDate = now()->startOfMonth()->subMonth();
            $endDate = now()->endOfMonth()->subMonth();
            $data = Trend::model(User::class)
                ->between(
                    start: $startDate,
                    end: $endDate,
                )
                ->perDay()
                ->count();
        }
        else {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
            $data = Trend::model(User::class)
                ->between(
                    start: $startDate,
                    end: $endDate,
                )
                ->perMonth()
                ->count();
        }



        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
}
