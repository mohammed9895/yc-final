<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Attendees extends Page
{
    use HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.attendees';

    protected static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public function getTitle(): string
    {
        return   __('filament::attendees.heading');
    }

    protected static function getNavigationLabel(): string
    {
        return   __('filament::attendees.heading');
    }
}
