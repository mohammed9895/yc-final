<?php

namespace App\Filament\Pages;

use App\Models\Tender;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class TendersList extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tenders-list';


    public function getTitle(): string
    {
        return   __('Tenders List');
    }

    protected static function getNavigationLabel(): string
    {
        return   __('Tenders List');
    }

    public $tenders;

    public function mount()
    {
        $this->tenders = Tender::all()->where('status', 1);
    }

    public function download(Tender $tender)
    {
//        dd($tender->document);
        $outputFile = Storage::disk('local')->path("/public/" . $tender->document[0]);
        return Response::download($outputFile);
    }
}
