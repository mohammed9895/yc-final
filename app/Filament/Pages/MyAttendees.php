<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class MyAttendees extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.my-attendees';

    protected static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public function getTitle(): string
    {
        return   __('filament::yc.my_attendees');
    }

    protected static function getNavigationLabel(): string
    {
        return   __('filament::yc.my_attendees');
    }
}
