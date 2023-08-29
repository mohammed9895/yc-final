<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;

class AttendeesPage extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.attendees';

    protected static function getNavigationGroup(): ?string
    {
        return __('workshops');
    }

    protected static function getNavigationLabel(): string
    {
        return __('filament::attendees.heading');
    }

    public function getTitle(): string
    {
        return __('filament::attendees.heading');
    }
}
