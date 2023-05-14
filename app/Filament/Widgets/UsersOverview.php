<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\User;
use Flowframe\Trend\Trend;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UsersOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    protected function getCards(): array
    {
        $averageAge = User::selectRaw('AVG(TIMESTAMPDIFF(YEAR, birth_date, CURDATE())) as average_age')->value('average_age');
        return [
            Card::make('Total Users', User::count()),
            Card::make('Users Registered Today', User::whereDate('created_at', today())->count()),
            Card::make('Users Registered This Month', User::whereMonth('created_at', '=', date('m'))->count()),
            Card::make('Male Users', User::where('gender', '=', 0)->count()),
            Card::make('Female Users', User::where('gender', '=', 1)->count()),
            Card::make('Residents Users', User::where('citizen', '=', 1)->count()),
            Card::make('Omani Users', User::where('citizen', '=', 0)->count()),
            Card::make('Averag Age', (int)$averageAge),
        ];
    }
}
