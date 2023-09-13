@extends('layouts.manjam')

@section('content')
    <section class="mt-10 relative mb-20">
        <h1 class="text-6xl font-bold text-[#161849] text-center leading-[70px]">
            <span class="text-[#684e9a] relative">
                {{ __('All Categories') }}
                <i>
                    <img src="{{ asset('images/line.svg') }}" class="absolute w-full left-0 -bottom-3" alt="">
                </i>
            </span>
        </h1>
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

    <div class="container mx-auto mt-24">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-20 gap-3">
            @foreach($talent_types as $type)
                <a href="/manjam/categories/{{ $type->id }}"
                   class="block bg-white p-5 flex items-center hover:shadow-lg hover:cursor-pointer">
                    <div class="bg-[#cab5f4] p-8">
                        <x-icon name="{{ $type->icon }}" class="w-10 h-10 text-[#684e9a]"/>
                    </div>
                    <div class="ml-4 rtl:mr-4">
                        <h1 class="text-2xl text-slate-800 font-bold"> {{ $type->name }}</h1>
                        <p class="text-slate-500">{{ $type->talents_count }}+ {{ __('Talent Registered') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

@endsection
