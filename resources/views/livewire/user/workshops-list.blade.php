<div>
    <div>
        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Select the Governorate')  }}</label>
        <select id="countries" wire:change="change_place" wire:model="place" class="bg-gray-50 mb-5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="all">{{ __('tables::table.pagination.fields.records_per_page.options.all') }}</option>
            @foreach($places as $place)
                <option value="{{ $place->id }}">{{ $place->name  }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        @foreach ($workshops as $workshop)
            <div
                class="max-w-sm relative bg-white cursor-pointer border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a wire:click="$emit('openModal', 'user.booking-model', {{ json_encode(['workshop' => $workshop->id], JSON_UNESCAPED_UNICODE) }})">
                    <img class="rounded-t-lg max-h-80 w-full" src="/storage/{{ $workshop->cover }}" alt="" />
                </a>
                <div class="p-5">
                    <div class="mb-4">
                        @foreach ($workshop->conditions as $condition)
                        <span
                            class="bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">{{ $condition }}</span>
                    @endforeach
                        <span
                            class="bg-purple-100 absolute top-2 left-1  text-purple-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">{{ $workshop->place->name }}</span>
                    </div>
                    <a wire:click="$emit('openModal', 'user.booking-model', {{ json_encode(['workshop' => $workshop->id], JSON_UNESCAPED_UNICODE) }})">
                        <h5 class="mb-2 text-2xl cursor-pointer font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $workshop->title }}</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $workshop->description }}</p>
                    <a wire:click="$emit('openModal', 'user.booking-model', {{ json_encode(['workshop' => $workshop->id], JSON_UNESCAPED_UNICODE) }})"
                        class="inline-flex cursor-pointer items-center px-3 py-2 text-sm font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        {{ __('filament::users.workshop.attend') }}
                        @if (Config::get('app.locale') == 'en')
                            <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @else
                            <svg aria-hidden="true" class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
