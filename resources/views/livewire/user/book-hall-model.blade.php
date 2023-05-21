<div>
    <style>
        [type=checkbox]:checked,
        [type=checkbox]:focus,
        [type=checkbox]:active {
            color: #9334e9;
            border: none;
            outline: none;
            box-shadow: none;
        }
    </style>
    <div class="space-y-2">
        <div class="filament-modal-header px-6 py-2">
            <h2 class="filament-modal-heading text-xl font-bold tracking-tight">
                {{ __('book') . ' ' . $hall->name }}
            </h2>
        </div>

        <div aria-hidden="true" class="filament-hr border-t dark:border-gray-700 px-2"></div>
        <form wire:submit.prevent="create">
            <div class="filament-modal-content space-y-2 p-2">

                <div class="px-4 py-2 space-y-4">

                    {{ $this->form }}
                    @if (session()->has('error'))
                        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                            role="alert">
                            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3 rtl:mr-0 ml-3"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif
                    <div class="flex overflow-x-auto overflow-y-hidden">
                        @foreach ($slotsTimings as $timing)
                            <div class="flex flex-col justify-start items-start">
                                @php
                                    $isReserved = false;
                                    $isSelected = in_array($timing, $slots); // Check if current slot is selected
                                    $isConsecutive = true;
                                    
                                    if (!empty($slots)) {
                                        $lastSelectedIndex = array_search(end($slots), $slotsTimings);
                                    
                                        if ($lastSelectedIndex !== false && $lastSelectedIndex !== count($slotsTimings) - 1) {
                                            $nextSlot = $slotsTimings[$lastSelectedIndex + 1];
                                            $isConsecutive = $timing === $nextSlot;
                                        }
                                    }
                                    
                                    foreach ($timings as $reservedTiming) {
                                        $reservedStart = Carbon\Carbon::createFromFormat('h:i A', $reservedTiming['start']);
                                        $reservedEnd = Carbon\Carbon::createFromFormat('h:i A', $reservedTiming['end']);
                                        $currentTiming = Carbon\Carbon::createFromFormat('h:i A', $timing);
                                    
                                        if ($currentTiming >= $reservedStart && $currentTiming < $reservedEnd) {
                                            $isReserved = true;
                                            break;
                                        }
                                    }
                                @endphp

                                <div>
                                    <input type="checkbox" wire:model="slots"
                                        wire:click="toggleSlot('{{ $timing }}', {{ $isSelected ? 'false' : 'true' }})"
                                        value="{{ $timing }}"
                                        class="w-12 h-12 rounded border-0 mb-2 ml-4 appearance-none checked:text-primary-500 outline-none {{ $isSelected ? 'pointer-events-auto cursor-pointer' : '' }} {{ $isReserved || ($counter >= 8 && !$isSelected) || !$isConsecutive || $isSelected ? 'pointer-events-none bg-gray-300' : 'cursor-pointer bg-primary-300' }}"
                                        wire:key="{{ $loop->index }}">
                                </div>
                                <div class="text-gray-600 text-xs text-center dark:text-gray-100">
                                    {{ $timing }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                <div aria-hidden="true" class="filament-hr border-t dark:border-gray-700 px-2"></div>

                <div class="filament-modal-footer px-6 py-2">
                    <div class="filament-modal-actions flex flex-wrap items-center gap-4 rtl:space-x-reverse">
                        <button type="submit"
                            class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-tables-modal-button-action">
                            {{ __('book') }}
                        </button>

                        <button type="button"
                            class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800 filament-tables-modal-button-action"
                            wire:click="$emit('closeModal')">
                            <span class="flex items-center gap-1">
                                <span class="">
                                    {{ __('cancel') }}
                                </span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <button tabindex="-1" type="button" class="absolute top-2 right-2 rtl:right-auto rtl:left-2"
        wire:click="$emit('closeModal')">
        <svg title="Close" tabindex="-1" class="filament-modal-close-button h-4 w-4 cursor-pointer text-gray-400"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">
            Close
        </span>
    </button>
</div>
