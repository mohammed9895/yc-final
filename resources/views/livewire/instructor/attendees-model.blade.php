<div>
    <div class="space-y-2">
        <div class="filament-modal-header px-6 py-2">
            <h2 class="filament-modal-heading text-xl font-bold tracking-tight">
                Book {{ $workshop->title }}
            </h2>
        </div>

        <div aria-hidden="true" class="filament-hr border-t dark:border-gray-700 px-2"></div>
        <div class="filament-modal-content space-y-2 p-2">

            <div class="px-4 py-2 space-y-4">

                <ol
                    class="flex items-center w-full p-3 space-x-2 text-sm font-medium text-center text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-4">
                    <li
                        class="flex items-center @if ($step == 1) text-primary-600 dark:text-primary-500 @endif">
                        <span
                            class="flex items-center justify-center rounded-full w-5 h-5 mr-2 text-xs border @if ($step == 1) border-primary-600  shrink-0 dark:border-primary-500 @endif">
                            1
                        </span>
                        Choose <span class="hidden sm:inline-flex sm:ml-2">Slat</span>
                        <svg aria-hidden="true" class="w-4 h-4 ml-2 sm:ml-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li
                        class="flex items-center @if ($step == 2) text-primary-600 dark:text-primary-500 @endif">
                        <span
                            class="flex items-center justify-center w-5 h-5 mr-2 text-xs border rounded-full  @if ($step == 2) border-primary-600  shrink-0 dark:border-primary-500 @else border-gray-500  dark:border-gray-400 @endif">
                            2
                        </span>
                        Fill <span class="hidden sm:inline-flex sm:ml-2">Attendeens</span>
                    </li>
                </ol>
                @if ($step == 1)
                    <div class="row">
                        <ul class="grid w-full mb-4 gap-6 md:grid-cols-2">
                            @if (count($slots))
                                @foreach ($slots as $slot)
                                    <li>
                                        <input type="radio" id="slot-number-{{ $slot->id }}" wire:model="slot_id"
                                            value="{{ $slot->id }}" name="slot_id" class="hidden peer" required>
                                        <label for="slot-number-{{ $slot->id }}"
                                            class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-primary-500 peer-checked:border-primary-600 peer-checked:text-primary-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <div class="block">
                                                <div class="w-full text-lg font-semibold">{{ $slot->name }}</div>
                                                <div class="w-full"><svg xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" class="w-6 h-6 inline-block">
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
                                <h1>Slots</h1>
                            @endif
                        </ul>
                        <div class="col-auto">
                            <!-- click this button it will increment step value by 1 -->
                            <a wire:click="moreStep"
                                class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-tables-modal-button-action"
                                @disabled($slot_id == null)>Next</a>
                        </div>
                    </div>
                @endif

                @if ($step == 2)
                    <div class="row">

                        @if (count($attendanceCount) == 0)
                            <div class="relative mb-2 overflow-x-auto shadow-md sm:rounded-lg">
                                <form>
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Name
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Attendeens
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($attendance as $item)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <th scope="row"
                                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $item->user->name }}
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center mb-4">
                                                            <input id="default-radio-1" type="radio" value="1"
                                                                wire:model="users.{{ $item->user->id }}"
                                                                class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                            <label for="default-radio-1"
                                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Present</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input id="default-radio-2" type="radio"
                                                                wire:model="users.{{ $item->user->id }}" value="0"
                                                                class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                            <label for="default-radio-2"
                                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Absent</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <div class="flex items-center justify-between">
                                <a wire:click="lessStep"
                                    class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-tables-modal-button-action">Back</a>
                                <a wire:click="create"
                                    class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-tables-modal-button-action">Submit
                                    Attendens</a>
                            </div>
                        @else
                            <div class="relative mb-2 overflow-x-auto shadow-md sm:rounded-lg">
                                <form>
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Name
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Attendeens
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($attendanceCount as $item)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <th scope="row"
                                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $item->user->name }}
                                                    </th>
                                                    <td>
                                                        @if ($item->attendance == 1)
                                                            Present
                                                        @else
                                                            Absent
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center mb-4">
                                                            <input type="hidden" wire:model="attendanceIds">
                                                            <input id="default-radio-1" type="radio" value="1"
                                                                wire:model="users.{{ $item->user->id }}"
                                                                name="users-{{ $item->user->id }}"
                                                                class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                                checked>
                                                            <label for="default-radio-1"
                                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Present</label>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <input id="default-radio-2" type="radio"
                                                                wire:model="users.{{ $item->user->id }}"
                                                                value="0" name="users-{{ $item->user->id }}"
                                                                class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                            <label for="default-radio-2"
                                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Absent</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <div class="flex items-center justify-between">
                                <a wire:click="lessStep"
                                    class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-tables-modal-button-action">Back</a>
                                <a wire:click="update"
                                    class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-tables-modal-button-action">Submit
                                    Attendens</a>
                            </div>
                        @endif



                    </div>
                @endif

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
