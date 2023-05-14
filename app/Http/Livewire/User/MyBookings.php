<?php

namespace App\Http\Livewire\User;

use Carbon\Carbon;
use Livewire\Event;
use App\Models\Slot;
use App\Models\Booking;
use Livewire\Component;
use App\Models\Evaluate;
use App\Models\Workshop;
use App\Models\Attendees;
use setasign\Fpdi\Tfpdf\Fpdi;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Facades\Response;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;


class MyBookings extends Component implements HasTable
{
    use InteractsWithTable;

    public $slot_id;
    public $workshop_id;

    protected $listeners = ['downloadCertificate' => 'downloadCert'];

    public function mount()
    {
    }

    protected function getTableQuery(): Builder
    {
        return Booking::query()->where('user_id', '=', Auth::id());
    }
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('workshop.title')->label(__('Workshop')),
            TextColumn::make('reasone')->label(__('reasone')),
            BadgeColumn::make('status')->label(__('status'))
                ->enum([
                    0 => 'Waiting',
                    1 => 'Rejected',
                    2 => 'Approved'
                ])
                ->colors([
                    'warning' => static fn ($state): bool => $state === 0,
                    'success' => static fn ($state): bool => $state === 2,
                    'danger' => static fn ($state): bool => $state === 1,
                ]),
            TextColumn::make('slot.start_date')
                ->label(__('start_date'))
                ->date(),
            TextColumn::make('slot.end_date')
                ->label(__('end_date'))
                ->date(),
            TextColumn::make('slot.start_time')
                ->label(__('start_time'))
                ->time('g:i A'),
            TextColumn::make('slot.end_time')
                ->time('g:i A')->label(__('end_time')),
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('downloadCertifcate')->label(__('downloadCertifcate'))->action(function (Booking $record) {
                if ($record->status === 2) {
                    $this->workshop_id = $record->workshop_id;
                    $this->slot_id = $record->slot_id;
                    $slots_dates = Slot::select('start_date', 'end_date')->where('id', $this->slot_id)->first();

                    $slot_start_date = Carbon::parse($slots_dates->start_date);
                    $slot_end_date = Carbon::parse($slots_dates->end_date);

                    $slot_days_count = $slot_start_date->diffInDays($slot_end_date);

                    $present_attendees = Attendees::where('slot_id', $this->slot_id)->where('user_id', Auth::id())->where('attendance', 1)->count();
                    if ($slot_days_count === 0) {
                        $slot_days_count = 1;
                    }
                    if ($slot_days_count === $present_attendees) {
                        $evaluations = Evaluate::where('user_id', Auth::id(),)->where('workshop_id', $record->workshop_id)->get();
                        if (count($evaluations) === 0) {
                            $this->emit('openModal', 'user.evaluate-model', ['booking' => $record]);
                        } else {
                            $this->emit('downloadCertificate');
                        }
                    } else {
                        Notification::make()
                            ->title('You are not eligible for certificate')
                            ->danger()
                            ->send();
                    }
                } else {
                    Notification::make()
                        ->title('You are not eligible for certificate')
                        ->danger()
                        ->send();
                }
            }),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

    public function downloadCert()
    {
        $workshop   = $this->workshop_id;
        $slot       = $this->slot_id;
        $user       = Auth::id();
        $slots_dates = Slot::select('start_date', 'end_date')->where('id', $slot)->first();

        $slot_start_date = Carbon::parse($slots_dates->start_date);
        $slot_end_date = Carbon::parse($slots_dates->end_date);
        $slot_days_count = $slot_start_date->diffInDays($slot_end_date);

        $present_attendees = Attendees::where('slot_id', $slot)->where('user_id', $user)->where('attendance', 1)->count();
        if ($slot_days_count === 0) {
            $slot_days_count = 1;
        }
        if ($slot_days_count === $present_attendees) {

            $workshop_info = Workshop::where('id', $workshop)->first();

            $outputFile = Storage::disk('local')->path("\/certificates/" . auth()->user()->name . ".pdf");

            $text = [
                auth()->user()->name,
                $workshop_info->title,
                'من تاريخ ' . $slots_dates->start_date . ' الى ' . $slots_dates->end_date,
            ];
            $this->fillPDF(Storage::disk('local')->path('/certificates/cert.pdf'), $outputFile, $text);

            //output to browser
            $headers = array(
                'Content-Type: application/pdf',
            );

            $filename = $workshop_info->title . ' Certificate.pdf';
            Notification::make()
                ->title('Certificate downloaded successfuly')
                ->success()
                ->send();
            return Response::download($outputFile, $filename, $headers);
        } else {
            Notification::make()
                ->title('You are not eligible for certificate')
                ->danger()
                ->send();
        }
    }


    public function fillPDF($file, $outputFile, $text)
    {
        $fpdi = new Fpdi();
        // merger operations
        $fpdi->addFont('NeoSansArabic', 'M', 'NeoSansArabicMedium.ttf', true);
        // $fpdi->addFont('NeoSansArabic', 'M', 'NeoSansArabicMedium.php', true);
        $count = $fpdi->setSourceFile($file);
        for ($i = 1; $i <= $count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            $fpdi->SetFont("NeoSansArabic", "M", 18, '', true);
            $fpdi->SetTextColor(59, 87, 167);
            $fpdi->SetY(146);
            $Arabic = new \ArPHP\I18N\Arabic();
            $name_str = $Arabic->utf8Glyphs($text[0]);
            $fpdi->Cell(0, 0, $name_str, 0, 0, 'C');

            $fpdi->SetFont("NeoSansArabic", "M", 18);
            $fpdi->SetTextColor(59, 87, 167);
            $fpdi->SetY(171);
            $workshop_str = $Arabic->utf8Glyphs($text[1]);
            $fpdi->Cell(0, 0, $workshop_str, 0, 0, 'C');

            $fpdi->SetFont("NeoSansArabic", "M", 18);
            $fpdi->SetTextColor(59, 87, 167);
            $fpdi->SetY(197);
            $dates_str = $Arabic->utf8Glyphs($text[2]);
            $fpdi->Cell(0, 0, $dates_str, 0, 0, 'C');
        }
        return $fpdi->Output($outputFile, 'F');
    }

    public function render()
    {
        return view('livewire.user.my-bookings');
    }
}
