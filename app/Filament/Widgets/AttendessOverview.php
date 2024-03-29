<?php

namespace App\Filament\Widgets;

use App\Models\Attendees;
use Filament\Widgets\BarChartWidget;

class AttendessOverview extends BarChartWidget
{
    protected static ?string $heading = 'Chart';

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    protected int | string | array $columnSpan = 'full';


    protected function getData(): array
    {
//        $data = Attendees::where('')->with();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
