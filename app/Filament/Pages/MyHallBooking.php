<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class MyHallBooking extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.my-hall-booking';

    protected static function getNavigationGroup(): ?string
    {
        return   __('halls');
    }

    public function getTitle(): string
    {
        return   __('my-hall-booking');
    }

    protected static function getNavigationLabel(): string
    {
        return   __('my-hall-booking');
    }
}
