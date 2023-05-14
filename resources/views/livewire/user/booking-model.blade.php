<div>
    <div class="space-y-2">
        <div class="filament-modal-header px-6 py-2">
            <h2 class="filament-modal-heading text-xl font-bold tracking-tight">
                Book {{ $workshop->title }}
            </h2>
        </div>
        <form wire:submit.prevent="book">
            <div aria-hidden="true" class="filament-hr border-t dark:border-gray-700 px-2"></div>
            <div class="filament-modal-content space-y-2 p-2">

                <div class="px-4 py-2 space-y-4">
                    <ul class="grid w-full mb-4 gap-6 md:grid-cols-2">
                        @if (count($slots))
                            @foreach ($slots as $slot)
                                <li>
                                    <input type="radio" id="slot-number-{{ $slot->id }}" wire:model="slot_id"
                                        value="{{ $slot->id }}" class="hidden peer" required
                                        @disabled($slot->bookings->count() >= $workshop->capacity)>
                                    <label for="slot-number-{{ $slot->id }}"
                                        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-primary-500 peer-checked:border-primary-600 peer-checked:text-primary-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700
                                    @if ($slot->bookings->count() >= $workshop->capacity) cursor-not-allowed @else cursor-pointer @endif">
                                        <div class="block">
                                            <div class="w-full text-lg font-semibold">{{ $slot->name }}</div>
                                            <div class="w-full"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6 inline-block">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                                </svg>
                                                {{ $slot->start_date }} -
                                                {{ $slot->end_date }}</div>
                                            <div class="w-full mt-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="w-6 h-6 inline-block">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $slot->start_time }} -
                                                {{ $slot->end_time }}</div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                        </svg>
                                    </label>
                                </li>
                            @endforeach
                        @else
                            <h1>No Slots</h1>
                        @endif

                    </ul>

                    <div class="2282u7u2">
                        @if ($workshop->questions)
                            @for ($i = 0; $i < count($workshop->questions); $i++)
                                @foreach ($workshop->questions[$i]['data'] as $key => $value)
                                    @if ($workshop->questions[$i]['type'] == 'open_question')
                                        <div class="mb-6">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $value }}</label>
                                            <input type="text" wire:model="answers.{{ $i }}"
                                                class="block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600"
                                                required>
                                        </div>
                                    @endif
                                    @if ($workshop->questions[$i]['type'] == 'checkbox_question')
                                        <div class="flex items-center mb-6">
                                            <input id="default-checkbox" type="checkbox"
                                                wire:model="answers.{{ $i }}" checked="false"
                                                class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-checkbox"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $value }}</label>
                                        </div>
                                    @endif

                                    @if ($workshop->questions[$i]['type'] == 'upload_question')
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                            for="file_input">{{ $value }}</label>
                                        <input
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                            id="file_input" type="file" wire:model="answers.{{ $i }}">
                                    @endif
                                @endforeach
                                @if ($workshop->questions[$i]['type'] === 'options_question')
                                    <label for="countries"
                                        class="block mb-2 mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ $workshop->questions[$i]['data']['options_question'] }}</label>
                                    <select id="countries" wire:model="answers.{{ $i }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        @php
                                            $options = explode(',', $workshop->questions[$i]['data']['options_list']);
                                        @endphp
                                        <option value="">Choose</option>
                                        @foreach ($options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            @endfor
                        @endif
                    </div>
                    <div>
                        @if(app()->getLocale('en') == 'en')
                            <label for="reasone" class="">Reason</label>
                        @else
                            <label for="reasone" class="">أذكر سبب أنضمامك للورشة</label>
                        @endif
                        
                        
                        <textarea wire:model="reasone" id="reasone" required
                            class="block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600"></textarea>
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                <div aria-hidden="true" class="filament-hr border-t dark:border-gray-700 px-2"></div>

                <div class="filament-modal-footer px-6 py-2">
                    <div class="filament-modal-actions flex flex-wrap items-center gap-4 rtl:space-x-reverse">
                        <button type="submit"
                            class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-tables-modal-button-action">
                            Book Now
                        </button>

                        <button type="button"
                            class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800 filament-tables-modal-button-action"
                            wire:click="$emit('closeModal')">
                            <span class="flex items-center gap-1">
                                <span class="">
                                    Cancel
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
