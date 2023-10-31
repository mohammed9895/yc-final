<?php

namespace App\Http\Livewire\User;

use App\Models\Attendees;
use App\Models\Booking;
use App\Models\Evaluate;
use App\Models\Slot;
use App\Models\User;
use App\Models\Workshop;
use App\Notifications\SmsMessage;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use setasign\Fpdi\Tfpdf\Fpdi;


class MyBookings extends Component implements HasTable
{
    use InteractsWithTable;

    public $slot_id;
    public $workshop_id;

    protected $listeners = ['downloadCertificate' => 'downloadCert'];

    public function mount()
    {
    }

    public function downloadCert()
    {
        $workshop = $this->workshop_id;
        $slot = $this->slot_id;
        $user = Auth::id();
        $slots_dates = Slot::select('start_date', 'end_date')->where('id', $slot)->first();

        $slot_start_date = Carbon::parse($slots_dates->start_date);
        $slot_end_date = Carbon::parse($slots_dates->end_date);
        $slot_days_count = $slot_start_date->diffInDays($slot_end_date);

        $workshop_info = Workshop::where('id', $workshop)->first();

        $present_attendees = Attendees::where('slot_id', $slot)->where('user_id', $user)->where('attendance',
            1)->count();

//        if ($workshop_info->days === $present_attendees) {

        $outputFile = Storage::disk('local')->path("\/certificates/".auth()->user()->name.".pdf");

        $text = [
            auth()->user()->name,
            $workshop_info->title,
            'من تاريخ '.$slots_dates->start_date.' الى '.$slots_dates->end_date,
        ];
        $this->fillPDF(Storage::disk('local')->path('/certificates/cert.pdf'), $outputFile, $text);

        //output to browser
        $headers = array(
            'Content-Type: application/pdf',
        );


        $filename = str_ireplace(array(
                '\'', '"',
                ',', ';', '<', '>'
            ), '', Str::kebab($workshop_info->title)).'-certificate.pdf';
        Notification::make()
            ->title('Certificate downloaded successfully')
            ->success()
            ->send();
        return Response::download($outputFile, $filename, $headers);
//        }
//        else {
//            Notification::make()
//                ->title('You are not eligible for certificate')
//                ->danger()
//                ->send();
//        }

    }

    public function fillPDF($file, $outputFile, $text)
    {
        $fpdi = new Fpdi();
        // merger operations
        $fpdi->addFont('NeoSansArabic', 'M', 'NeoSansArabicMedium.ttf', true);
        // $fpdi->addFont('NeoSansArabic', 'M', 'NeoSansArabicMedium.php', true);
        $count = $fpdi->setSourceFile($file);
        for ($i = 1; $i <= $count; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            $fpdi->SetFont("NeoSansArabic", "M", 18, '', true);
            $fpdi->SetTextColor(59, 87, 167);
            $fpdi->SetY(111);
            $Arabic = new \ArPHP\I18N\Arabic();
            $name_str = $Arabic->utf8Glyphs($text[0]);
            $fpdi->Cell(0, 0, $name_str, 0, 0, 'C');

            $fpdi->SetFont("NeoSansArabic", "M", 18);
            $fpdi->SetTextColor(59, 87, 167);
            $fpdi->SetY(136);
            $workshop_str = $Arabic->utf8Glyphs($text[1]);
            $fpdi->Cell(0, 0, $workshop_str, 0, 0, 'C');

            $fpdi->SetFont("NeoSansArabic", "M", 18);
            $fpdi->SetTextColor(96, 97, 97);
            $fpdi->SetY(159);
            $dates_str = $Arabic->utf8Glyphs($text[2]);
            $fpdi->Cell(0, 0, $dates_str, 0, 0, 'C');
        }
        return $fpdi->Output($outputFile, 'F');
    }

    public function render()
    {
        return view('livewire.user.my-bookings');
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
                    0 => __('Waiting'),
                    1 => __('Rejected'),
                    2 => __('Approvied'),
                    3 => __('canceled'),
                ])
                ->colors([
                    'warning' => static fn($state): bool => $state === 0,
                    'success' => static fn($state): bool => $state === 2,
                    'danger' => static fn($state): bool => $state === 1,
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

//                    $present_attendees = Attendees::where('slot_id', $this->slot_id)->where('user_id', Auth::id())->where('attendance', 1)->count();
//                    if ($slot_days_count === 0) {
//                        $slot_days_count = 1;
//                    }

                    $evaluations = Evaluate::where('user_id', Auth::id(),)->where('workshop_id',
                        $record->workshop_id)->get();
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
            })->visible(fn(Booking $record) => $record->status == 2),
            Action::make('cancel')
                ->label(__('cancel'))
                ->action('cancel')
                ->action(function (Booking $record, array $data) {
                    $workshop = Workshop::where('id', $record->workshop_id)->first();
                    $user = User::where('id', $record->user_id)->first();

                    $sms = new SmsMessage;

                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('تم الغاء حجزك في  '.$workshop->title)
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Your reservation for '.$workshop->title.' has been canceled')
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    Booking::where('id', $record->id)->update(['status' => 3]);
                })
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->hidden(fn(Booking $record) => $record->status === 3),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }
}
