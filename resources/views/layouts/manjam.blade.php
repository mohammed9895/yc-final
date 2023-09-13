<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'en' ? 'lrt' : 'rtl' }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manjam</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="
        https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css
        "
          rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;700&display=swap"
          rel="stylesheet">

    <style>
        body {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }

        .bg-primary-100, .bg-primary-200, .bg-primary-300, .bg-primary-400, .bg-primary-500, .bg-primary-600, .bg-primary-700, .bg-primary-800, .bg-primary-900 {
            background-color: #684e9a;
        }

        .choices__list--dropdown .choices__item--selectable.is-highlighted, .choices__list[aria-expanded] .choices__item--selectable.is-highlighted {
            background-color: #684e9a;
        }

        .focus\:ring-primary-500:focus {
            --tw-ring-opacity: 1;
            --tw-ring-color: #684e9a;
        }

        .focus\:border-primary-500:focus {
            --tw-border-opacity: 1;
            border-color: #684e9a;
        }

        .hover\:bg-primary-500:hover {
            background-color: #684e9a;
        }

        .is-focused .choices_inner, .is-open .choices_inner {
            border-color: #684e9a;
            --tw-ring-color: #684e9a;
            --tw-ring-shadow: #684e9a;
            opacity: 0;
        }

        .border-primary-500 {
            border-color: #684e9a;
        }

        .text-primary-700 {
            color: #684e9a;
        }

        .text-primary-500 {
            color: #684e9a;
        }
    </style>

    @livewireStyles
</head>
<body class="bg-slate-300">

<div class="container mx-auto py-10">
    <nav class="flex justify-between items-center">
        <div>
            <a href="/">
                <img src="{{ asset('images/manjam-logo.svg') }}"
                     class="hover:rotate-[360deg]  transition-all duration-1000 ease-in-out" width="80"
                     alt="">
            </a>
        </div>
        <div>
            <a href="#register" class="bg-[#161849] relative text-white inline-block px-10 py-4">
                <div
                    class="bg-[url({{ asset('images/star.svg')  }})] absolute top-0 right-0 opacity-25 w-10 h-10"></div>
                {{ __('Register Now') }}
            </a>
            @if (session()->get('locale', 'en') == 'en')
                <a href="{{ route('language.switch', 'ar') }}"
                   class="bg-[#161849] relative text-white inline-block px-6 py-4">
                    <div
                        class="bg-[url({{ asset('images/star.svg')  }})] absolute top-0 right-0 opacity-25 w-10 h-10"></div>
                    ع
                </a>
            @else
                <a href="{{ route('language.switch', 'en') }}"
                   class="bg-[#161849] relative text-white inline-block px-6 py-4">
                    <div
                        class="bg-[url({{ asset('images/star.svg')  }})] absolute top-0 right-0 opacity-25 w-10 h-10"></div>
                    EN
                </a>
            @endif
        </div>
    </nav>
</div>


@yield('content')

<section class="bg-slate-300 mt-20 py-14">
    <div class="container md:w-3/4 mx-auto">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div class="mb-4 md:mb-0">
                <h1 class="text-[#684e9a] mb-4 text-4xl font-bold">{{ __('Need Any Help?') }}</h1>
                <h1 class="text-slate-800 text-4xl font-bold">{{ __('Contact Us anytime.') }}</h1>
            </div>
            <div class="bg-slate-100 p-5 flex flex-col md:flex-row items-center shadow-sm">
                <div class="">
                    <h3 class="text-lg text-slate-500">
                        {{ __('Send Us Message At') }}
                    </h3>
                    <h3 class="text-3xl text-slate-800">
                        talents@yc.om
                    </h3>
                </div>
                <div class="bg-slate-300 w-[50px] h-[1px] my-10 md:w-[1px] md:h-[50px] md:mx-10"></div>
                <div>
                    <h3 class="text-lg text-slate-500">
                        {{ __('Call Us') }}
                    </h3>
                    <h3 class="text-3xl text-slate-800 " dir="ltr">
                        +968 94449151
                    </h3>
                </div>
            </div>
        </div>
    </div>
</section>


<footer class="text-center relative flex items-center justify-center">
    <div class="z-50">
        <a href="#">
            <img src="{{ asset('images/yc-logo.svg') }}" width="200" alt="">
        </a>
    </div>
</footer>

@livewire('livewire-ui-modal')
@livewireScripts
</body>
</html>
