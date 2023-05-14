<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class AvailableWorkshops extends Page
{

    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static string $view = 'filament.pages.available-workshops';

    protected static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public function getTitle(): string
    {
        return   __('filament::yc.available-workshops');
    }

    protected static function getNavigationLabel(): string
    {
        return   __('filament::yc.available-workshops');
    }
}
