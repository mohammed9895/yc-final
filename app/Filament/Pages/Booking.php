<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Booking extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static string $view = 'filament.pages.booking';

    protected static ?string $title = 'Workshop Bookings';

    protected static ?string $navigationLabel = 'Workshop Bookings';

    protected static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public function getTitle(): string
    {
        return   __('workshop_bookings');
    }

    protected static function getNavigationLabel(): string
    {
        return   __('workshop_bookings');
    }
}
