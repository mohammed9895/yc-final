@extends('layouts.manjam')

@section('content')
    <section class="mt-10 relative">
        <h1 class="text-6xl font-bold text-[#161849] text-center leading-[70px]">

            <span class="text-[#684e9a] relative">
                {{ $talentType->name }}
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

    <div class="container mx-auto mt-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            @foreach($talentType->talents as $talent)
                <div class="mb-5">
                    <div
                        class="w-full h-[500px]"
                        style="background: url(/storage/{{ $talent->personal_image }}); background-size: cover;"
                    ></div>
                    <div class="bg-slate-100 p-4 ">
                        <div class="inline-block text-sm bg-slate-300 text-slate-800 p-1 px-3 mb-4">
                            {{ $talent->talentType->name }}
                        </div>
                        <h1 class="text-xl text-slate-800 font-bold">
                            {{ $talent->user->name }}
                        </h1>
                        <a class="bg-[#684e9a] text-white inline-block p-3 mt-2 cursor-pointer"
                           wire:click="$emit('openModal', 'manjam.talent-request-model', {{ json_encode(['talent_id' => $talent->id], JSON_UNESCAPED_UNICODE) }})">Request
                            Contact</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
