<div>
    <div class="container mx-auto">


        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            @foreach ($workshops as $workshop)
                <div class="max-w-sm relative bg-white border border-gray-200 rounded-lg shadow ">
                    <a href="/cp/available-workshops">
                        <img class="rounded-t-lg max-h-80 w-full" src="/storage/{{ $workshop->cover }}" alt="" />
                    </a>
                    <div class="p-5">
                        <div class="mb-4">
                            @foreach ($workshop->conditions as $condition)
                                <span
                                    class="bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">{{ $condition }}</span>
                            @endforeach
                            <span
                                class="bg-purple-100 absolute top-2 left-1 text-purple-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">{{ $workshop->place->name }}</span>
                        </div>
                        <a href="/cp/available-workshops">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 ">
                                {{ $workshop->title }}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 ">{{ $workshop->description }}</p>
                        <a href="/cp/available-workshops"
                            class="inline-flex cursor-pointer items-center px-3 py-2 text-sm font-medium text-center text-white bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-primary-300 ">
                            {{ __('filament::users.workshop.attend') }}
                            @if (Config::get('app.locale') == 'en')
                                <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <svg aria-hidden="true" class="w-4 h-4 mr-2 -ml-1" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
</div>
