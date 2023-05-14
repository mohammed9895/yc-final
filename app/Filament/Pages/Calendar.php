<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Calendar extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.pages.calendar';

    public function getTitle(): string
    {
        return   __('filament::yc.calendar');
    }

    protected static function getNavigationLabel(): string
    {
        return   __('filament::yc.calendar');
    }
}
