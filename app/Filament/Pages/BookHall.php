<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class BookHall extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static string $view = 'filament.pages.book-hall';

    protected static function getNavigationGroup(): ?string
    {
        return   __('halls');
    }

    public function getTitle(): string
    {
        return   __('filament::yc.book-hall');
    }

    protected static function getNavigationLabel(): string
    {
        return   __('filament::yc.book-hall');
    }
}
