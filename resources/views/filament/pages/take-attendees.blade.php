<x-filament::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}
        <div class="relative mb-2 overflow-x-auto shadow-md sm:rounded-lg mt-10">
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
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" wire:key={{ $item->id }} >
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
        </div>
        <button  type="submit"
            class="filament-button mt-4 filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2rem] px-3 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">{{ __('book') }}</button>
    </form>
</x-filament::page>
