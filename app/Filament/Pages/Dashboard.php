<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\UsersChart;
use App\Filament\Widgets\LatestEvents;
use App\Filament\Widgets\BookingsChart;
use App\Filament\Widgets\UsersOverview;
use App\Filament\Widgets\EventsOverview;
use Filament\Pages\Dashboard as BasePage;
use App\Filament\Widgets\HallBookingChart;
use App\Filament\Widgets\HallBookingsChart;
use App\Filament\Widgets\User\WorkshopsCard;
use App\Filament\Widgets\WorkshopsOverview;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Dashboard extends BasePage
{
    // use HasPageShield;

    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            WorkshopsCard::class,
            UsersOverview::class,
            UsersChart::class,
            WorkshopsOverview::class,
            BookingsChart::class,
            EventsOverview::class,
            HallBookingChart::class,
            LatestEvents::class,
        ];
    }


    protected function getHeading(): string
    {
        $name = auth()->user()->name;
        return "{$name}'s Dashboard";
    }
}
