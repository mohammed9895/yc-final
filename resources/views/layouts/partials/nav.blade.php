<nav class="fixed w-full z-[1002] top-0 left-0 navbar-fixed-top">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center">
            <img src="{{ asset('images/yc-logo-white.svg') }}" class="h-12 mr-3" alt="Flowbite Logo">
        </a>

        <div class="flex md:order-2">
            @if (auth()->user())
                <img id="avatarButton" type="button" data-dropdown-toggle="userDropdown"
                    data-dropdown-placement="bottom-start" class="w-10 h-10 rounded-full cursor-pointer"
                    src="{{ '/storage/' . auth()->user()->avatar }}" alt="User dropdown">

                <!-- Dropdown menu -->
                <div id="userDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                    <div class="px-4 py-3 text-sm text-gray-600 ">
                        <div>{{ auth()->user()->name }}</div>
                        <div class="font-medium truncate">{{ auth()->user()->email }}</div>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 " aria-labelledby="avatarButton">
                        <li>
                            <a href="/cp" class="block px-4 py-2 hover:bg-gray-100  ">{{ __('dashboard') }}</a>
                        </li>
                        <li>
                            <a href="/cp/profile" class="block px-4 py-2 hover:bg-gray-100  ">{{ __('profile') }}</a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <form action="/filament/logout" method="post">
                            @csrf
                            <button href="#"
                                class=" px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 ">{{ __('signout') }}</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="/cp/register"
                    class="text-white flex justify-center items-center bg-lime-400 hover:bg-lime-400 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-6 py-3 text-center mr-3 md:mr-0 dark:bg-lime-400 dark:hover:bg-lime-400 dark:focus:ring-lime-400">سجل
                    الان
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 rotate-180 mr-2 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>

                </a>
            @endif

            <button data-collapse-toggle="navbar-sticky" type="button"
                class="inline-flex items-center ml-3 rtl:mr-3 p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">افتح القائمة</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium md:flex-row md:space-x-8 md:mt-0 md:border-0 ">
                <li class="rtl:ml-8">
                    <a href="/"
                        class="block py-2 pl-3 pr-4 text-white bg-lime-400 rounded md:bg-transparent md:text-lime-400 md:p-0 md:dark:text-lime-400"
                        aria-current="page">{{ __('home') }}</a>
                </li>
                <li>
                    <a href="/about"
                        class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-lime-400 md:p-0 md:dark:hover:text-lime-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">{{ __('about_us') }}</a>
                </li>
                <li>
                    <a href="/contact"
                        class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-lime-400 md:p-0 md:dark:hover:text-lime-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">{{ __('contact_us') }}</a>
                </li>
                @if (session()->get('locale', 'en') == 'en')
                    <li>
                        <a href="{{ route('language.switch', 'ar') }}"
                            class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-lime-400 md:p-0 md:dark:hover:text-lime-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">العربية</a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('language.switch', 'en') }}"
                            class="block py-2 pl-3 pr-4 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-lime-400 md:p-0 md:dark:hover:text-lime-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">English</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
