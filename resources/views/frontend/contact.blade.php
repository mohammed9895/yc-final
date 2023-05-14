@extends('layouts.landing')

@include('layouts.partials.title', ['title' => __('contact_us')])

@section('content')
    <section class="container mx-auto py-32">
        <div class="flex flex-col justify-between items-center lg:flex-row">
            <div>
                <h1 class="text-4xl font-bold mb-4 text-blue-700">{{ __('working_hours') }}</h1>
                <p class="flex items-center align-middle justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 ml-3">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('8:00 am - 10:00 pm') }}
                <h1 class="text-4xl mt-10 font-bold mb-4 text-blue-700">{{ __('contact') }}</h1>
                <p class="flex items-center align-middle justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>

                    <a href="tel:+96871111464">+968 71111464</a>
                </p>
            </div>
            <div>
                <img src="{{ asset('images/contact.svg') }}" class=" w-56" alt="">
            </div>
        </div>
    </section>
@endsection
