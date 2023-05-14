<?php

namespace App\Http\Livewire\User;

use App\Models\Booking;
use Livewire\Component;
use App\Models\Attendees;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AttendeesTable extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return Attendees::query()->where('user_id', '=', Auth::id())->with('slot.workshop');
    }
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('slot.workshop.title')
                ->searchable()
                ->label(__('filament::workshop.title')),
            BadgeColumn::make('attendance')
                ->enum([
                    0 => __('filament::yc.absent'),
                    1 => __('filament::yc.present'),
                ])
                ->colors([
                    'success' => static fn ($state): bool => $state === 1,
                    'danger' => static fn ($state): bool => $state === 0,
                ])
                ->searchable()
                ->label(__('filament::yc.attendees')),
            TextColumn::make('slot.name')
                ->label(__('filament::yc.slot'))
                ->searchable(),
            TextColumn::make('date')
                ->date('M, d Y')
                ->label(__('filament::yc.date'))
                ->searchable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('attendance')
                ->label(__('filament::yc.present'))
                ->query(fn (Builder $query): Builder => $query->where('attendance', 1))->toggle(),

            Filter::make('slot')
                ->form([
                    Select::make('slot')->options(Attendees::join('slots', 'attendees.slot_id', '=', 'slots.id')->where('user_id', '=', Auth::id())->pluck('slots.name', 'slots.id'))->searchable()->label(__('filament::yc.slot')),
                ])->query(function (Builder $query, array $data): Builder {

                    if ($data['slot'] == null) {
                        return $query;
                    } else {
                        return $query
                            ->where(
                                'slot_id',
                                $data['slot'],
                            );
                    }
                }),


            Filter::make('date')
                ->form([
                    DatePicker::make('created_from')->label(__('filament::yc.created_from')),
                    DatePicker::make('created_until')->label(__('filament::yc.created_until')),
                ])
                ->label(__('filament::yc.date'))
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                        );
                })
        ];
    }

    protected function getTableActions(): array
    {
        return [];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }
    public function render()
    {
        return view('livewire.user.attendees-table');
    }
}
