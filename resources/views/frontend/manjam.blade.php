@extends('layouts.manjam')


@section('content')
    <section class="mt-10 relative">
        <h1 class="text-6xl font-bold text-[#161849] text-center leading-[70px]">
            {{ __('Expend Your Limits With') }} <br>
            <span class="text-[#684e9a] relative">
                {{ __('Talents Manjam') }}
                <i>
                    <img src="{{ asset('images/line.svg') }}" class="absolute w-full left-0 -bottom-3" alt="">
                </i>
            </span>
        </h1>
        <div class="w-1/2 mx-auto mt-8">
            <p class="text-center text-slate-600">
                {{ __('Talents Platform connects skilled individuals with opportunities through user profiles, promoting efficient talent discovery and collaboration.') }}
            </p>
        </div>
        <span class="hidden md:block md:absolute md:right-[15%] md:top-[70%]">
            <img src="{{ asset('images/star-dark.svg') }}" width="250" alt="">
        </span>

        <span class="hidden md:block md:absolute md:right-[15%] md:top-[20%]">
            <img src="{{ asset('images/laptop.svg') }}" width="60" alt="">
        </span>

        <span class="hidden md:block md:absolute md:left-[10%] md:top-[80%]">
            <img src="{{ asset('images/mic.svg') }}" class="text-white" width="80" alt="">
        </span>

        <span class="hidden md:block md:absolute md:left-[20%] md:top-[0%]">
            <img src="{{ asset('images/guitar.svg') }}" class="text-white" width="80" alt="">
        </span>
    </section>

    <section class="container mx-auto mt-32">
        <div class="flex items-start flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-4xl text-slate-800 font-bold">{{ __('Available Category We Host') }}</h1>
                <p class="text-slate-500">{{ __('Our talents pool is like a colorful palette with many different categories.') }}</p>
            </div>
            <div>
                <a href="{{ route('manjam.all_categories', ) }}"
                   class="px-8 py-4 border border-[#684e9a] text-[#684e9a] bg-slate-200 hover:shadow-md inline-block mt-2 md:mt-0">
                    {{ __('All Categories') }}
                </a>
            </div>
        </div>
        @livewire('manjam.categories')
    </section>

    <section class="container mx-auto mt-40">
        <div class="text-center">
            <div>
                <h1 class="text-4xl text-slate-800 font-bold">{{ __('How we choose Talents') }}</h1>
                <p class="text-slate-500">{{ __('We select talents based on their unique skills and abilities.') }}</p>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-4 even:mt-20 gap-3 mt-20">
            <div class="flex relative mb-8 items-center flex-col ">
                <div class="bg-slate-200 p-10 -rotate-45">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 text-[#684e9a] rotate-45">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                    </svg>
                </div>
                <h1 class="mt-8 text-2xl font-bold text-slate-800">{{ __('Register on Platform') }}</h1>
                <p class="text-sm text-slate-500 text-center">
                    {{__('To get started, simply sign up on our platform.')}}
                </p>
                <img src="{{ asset('images/arrow.svg') }}"
                     class="hidden md:block absolute -right-12 rtl:-left-12 rtl:right-auto rtl:rotate-[-60deg] w-24 transform -scale-x-100 rtl:scale-x-100 rotate-[60deg]"
                     alt="">
                <img src="{{ asset('images/arrow-mob.svg') }}" class="w-36 -rotate-90 my-10 md:hidden" alt="">
            </div>
            <div class="flex relative mb-8 md:mt-16 items-center flex-col">
                <div class="bg-slate-200 p-10 -rotate-45">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 text-[#684e9a] rotate-45">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/>
                    </svg>
                </div>
                <h1 class="mt-8 text-2xl font-bold text-slate-800">{{ __('Filter Talents') }}</h1>
                <p class="text-sm text-slate-500 text-center">
                    {{ __('We sieve through talents to find the perfect match.') }}
                </p>
                <img src="{{ asset('images/arrow.svg') }}"
                     class="hidden md:block absolute -right-12 rtl:right-auto rtl:-left-12 w-24 transform rotate-[120deg] rtl:rotate-[-120deg] rtl:-scale-x-100"
                     alt="">
                <img src="{{ asset('images/arrow-mob.svg') }}" class="w-36 -rotate-90 my-10 md:hidden" alt="">
            </div>
            <div class="flex relative mb-8 items-center flex-col">
                <div class="bg-slate-200 p-10 -rotate-45">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 text-[#684e9a] rotate-45">
                        <path stroke-linecap="round"
                              d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                </div>
                <h1 class="mt-8 text-2xl font-bold text-slate-800">{{ __('Interview Talents') }}</h1>
                <p class="text-sm text-slate-500 text-center">
                    {{ __('We conduct interviews to get to know our talents better.') }}
                </p>
                <img src="{{ asset('images/arrow.svg') }}"
                     class="hidden md:block absolute -right-12 rtl:-left-12 rtl:right-auto rtl:rotate-[-60deg] w-24 transform -scale-x-100 rtl:scale-x-100 rotate-[60deg]"
                     alt="">
                <img src="{{ asset('images/arrow-mob.svg') }}" class="w-36 -rotate-90 my-10 md:hidden" alt="">
            </div>
            <div class="flex md:mt-16 mb-8 items-center flex-col">
                <div class="bg-slate-200 p-10 -rotate-45">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 text-[#684e9a] rotate-45">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                    </svg>
                </div>
                <h1 class="mt-8 text-2xl font-bold text-slate-800">{{ __('Publish Talents') }}</h1>
                <p class="text-sm text-slate-500 text-center">
                    {{ __('We showcase our talents to the world.') }}
                </p>
            </div>
        </div>
    </section>


    <section class="container mx-auto mt-40">
        <div class="text-center mb-20">
            <div>
                <h1 class="text-4xl text-slate-800 font-bold">
                    {{ __('Our Best of the Best Talents') }}
                </h1>
                <p class="text-slate-500">
                    {{ __("Our talent pool is bursting with the best-of-the-best, and it's teeming with options.") }}
                </p>
            </div>
        </div>
        @livewire('manjam.talents')
    </section>



    <section class="container mx-auto mt-48">
        @livewire('manjam.statistics')
    </section>


    <section class="container mx-auto mt-32" id="register">
        <div class="text-center mb-16">
            <div>
                <h1 class="text-4xl text-slate-800 font-bold">{{ __('Register Now and Show us Your Talent') }}</h1>
                <p class="text-slate-500">{{ __('Take the leap and register now to share your exceptional talent with us – the stage is yours!') }}</p>
            </div>
        </div>
        <div>
            <div class="w-full lg:w-1/2 mx-auto">
                @livewire('frontend.manjam')
            </div>
        </div>
    </section>

@endsection
