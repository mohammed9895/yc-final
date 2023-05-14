@extends('layouts.landing')


@section('content')
    <section
        class="w-full relative rounded-bl-[100px]  bg-fixed bg-[url({{ asset('images/hero.jpg') }})] bg-fixed bg-cover bg-center h-screen">
        <div
            class="absolute top-0 left-0 w-full h-full z-10 rounded-bl-[100px] bg-gradient-to-tr from-fuchsia-500 to-purple-900 opacity-50">
        </div>
        <div class="container relative flex-col mx-auto z-50">
            <div
                class="flex justify-center text-center items-center h-screen md:justify-start md:rtl:text-right  md:text-left">
                <div class="text-3xl md:text-6xl space-y-5 text-white capitalize">
                    <h1 class="text-light">{{ __('hero_1') }}</h1>
                    <h1 class="text-bold">{{ __('hero_2') }}</h1>
                    <h1 class="text-bold">{!! __('hero_3') !!}</h1>
                    <a href="#"
                        class="inline-block text-lg bg-lime-400 rounded-lg px-3 py-2 text-white">{{ __('learn_more') }}</a>
                    <a href="#"
                        class="inline-block text-lg border-lime-400 rounded-lg px-3 py-2 text-white">{{ __('statistices') }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-28">
        <div class="container mx-auto">
            <div class="flex flex-col space-y-11 justify-between md:flex-row md:space-y-0">
                @foreach ($statistices as $statistice)
                    <div class="flex items-center flex-col">
                        <img src="/storage/{{ $statistice->icon }}" class=" w-20 h-20" alt="">
                        <div class="text-center">
                            <h1 class="text-5xl font-bold text-blue-600 mt-5">{!! $statistice->number !!}</h1>
                            <h1 class="text-3xl">{!! $statistice->title !!}</h1>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class=" mb-20">
        <div class="container mx-auto rounded-lg">


            <div class="flex justify-between flex-col lg:flex-row items-center">
                <div
                    class="w-full lg:w-1/2 h-[500px] rounded-tl-lg rtl:rounded-tr-lg bg-cover bg-center bg-[url('{{ asset('images/sultan.jpeg') }}')]">

                </div>
                <div
                    class="w-full lg:w-1/2 py-4 flex rounded-tr-lg rtl:rounded-tl-lg justify-center flex-col h-auto md:h-[500px] bg-[#030f47] px-8 text-white">
                    <p class="text-3xl leading-10 mb-5">
                        {{ __('slutan_msg') }}
                    </p>
                    <p>
                        {{ __('slutan_pref') }}
                        <br>
                        {{ __('slutan_name') }}
                    </p>
                </div>
            </div>
            <div class="flex justify-between flex-col-reverse lg:flex-row items-center">
                <div
                    class="w-full rounded-bl-lg py-4  rtl:rounded-br-lg lg:w-1/2 flex justify-center h-auto flex-col md:h-[500px] bg-[#030f47] px-8 text-white">
                    <p class="text-3xl leading-10 mb-5">
                        {{ __('yaz_msg') }}
                    </p>
                    <p>
                        {{ __('yaz_name') }}
                        <br>
                        {{ __('yaz_pos') }}
                    </p>
                </div>
                <div
                    class="w-full lg:w-1/2 rounded-br-lg rtl:rounded-bl-lg h-[500px] bg-cover bg-center bg-[url('{{ asset('images/y2.png') }}')]">

                </div>
            </div>
        </div>
    </section>

    <section
        class="relative w-full bg-[length:100%] bg-revert bg-no-repeat lg:bg-[url({{ asset('images/waves.svg') }})] z-10">
        <div class="container mx-auto">
            <div class="text-center pt-72">
                <h1 class="font-bold text-4xl">
                    {{ __('partnaers') }}
                </h1>
                <div class="owl-carousel owl-theme">
                    <div>
                        <img src="{{ asset('images/comps/oc.svg') }}" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('images/comps/ithca.svg') }}" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('images/comps/grand.svg') }}" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('images/comps/oxy.svg') }}" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('images/comps/pdo.svg') }}" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('images/comps/sme.svg') }}" alt="">
                    </div>
                </div>
                <h1 class="font-bold text-4xl mb-8  md:pt-9  lg:text-black">
                    {{ __('paths') }}
                </h1>
                <div class="w-full lg:w-1/2 flex flex-wrap mx-auto">
                    <div class="mb-8 lg:mb-0 w-full grid grid-1 md:grid-cols-2 gap-3 px-4">
                        @foreach ($paths as $path)
                            <div class="odd:bg-[#041044] even:bg-[#730ad9] py-6 pl-6 pr-4 shadow rounded-lg ">
                                <a href="/paths/{{ $path->id }}">
                                    <img src="{{ '/storage/' . $path->icon }}" class="w-16 mb-4" alt="">
                                    <h4 class="mb-2 rtl:text-right text-2xl text-white font-bold font-heading">
                                        {{ $path->name }}
                                    </h4>
                                    <p class="text-white rtl:text-right leading-loose">
                                        {{ $path->description }}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        </div>

    </section>

    <section class=" relative bg-[url({{ asset('images/bg.svg') }})] bg-fixed w-full bg-cover bg-center mt-20">
        <div class="container mx-auto pt-32 pb-32">
            <h1 class="font-bold text-white text-4xl mt-10 mb-8 text-center">
                {{ __('goals') }}
            </h1>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 lg:gap-4">
                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/1.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">{{ __('تــنــمــــــيــــة') }}</h1>
                    <p class="text-white text-center">
                        @if(app()->getLocale() == 'ar')
                            {{ __('معارف وخبرات الشباب في مجالات الإبداع والابتكار.') }}
                            @else 
                             youth knowledge and experiences in the fields of creativity and innovation

                            @endif
                        </p>
                </div>


                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/3.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">{{ __('تعزيــز وتطــويــر') }}</h1>
                    <p class="text-white text-center">
                        @if(app()->getLocale() == 'ar')
                        التعاون مع الموؤسسات الشبابية المحلية و الإقليمية و الدولية في الأهداف المتعلقة بالمركز 
                            @else 
                             cooperation with local, regional and international youth organizations in the objectives related to the center
                            @endif
                        </p>
                </div>


                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/4.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">{{ __('توفــــيـــــر') }}
                    </h1>
                    <p class="text-white text-center">
                        @if(app()->getLocale() == 'ar')
                        مساحات مع متطلبات الشباب من مختلف المجالات و الإهتمامات 
                        
                            @else 
                             spaces with the requirements of young people from various fields and interests
                            @endif
                        </p>
                </div>

                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/5.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">{{ __('التــكــامــل') }}</h1>
                    <p class="text-white text-center">
                        @if(app()->getLocale() == 'ar')
                        مع الجهات و الموؤسسات الحكومية و الخاصة و مؤسسات المجتمع المدني في دعم و تطوير قطاع الشباب في مختلف المجالات 
                        
                            @else 
 with governmental and private institutions and civil society institutions in supporting and developing the youth sector in various fields
                            @endif
                        </p>
                </div>

                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/6.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">{{ __('اكتشـــاف وتطـــويـــر') }}</h1>
                    <p class="text-white text-center">
                        @if(app()->getLocale() == 'ar')
                        
                        مهارات ، مواهب الشباب و تنميتها و تقديم الإستشارات اللازمة للشباب 
                        
                            @else 
 the skills and talents of young people, and providing them with the necessary consultations

                            @endif
                        </p>
                </div>

                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/7.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">{{ __('تـــعــــزيــــــز') }}</h1>
                    <p class="text-white text-center">
                        @if(app()->getLocale() == 'ar')
       
       مشاركة الشباب في مختلف المشاريع و المبادرات و الفعاليات المتنوعة و تنفيذ برامج و مبادرات تسهم في صقل و مهارات ، مواهب الشباب 

                        
                            @else 
 youth participation in various projects, initiatives and events, and implementing programs and initiatives that contribute to refining the skills and talents of young people

                            @endif
                        </p>
                </div>

                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md ">
                    <img src="{{ asset('images/strategis/1.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">{{ __('المساهــمـــة') }} </h1>
                    <p class="text-white text-center">
                        @if(app()->getLocale() == 'ar')
في بناء مجتمع شبابي قادر على المشاركة بفعالية و كفاءة لتحقيق رؤية عمان 2040 
                        
                            @else 
to building a youth community that is able to participate effectively and efficiently to achieve the vision of Oman 2040


                            @endif
                        </p>
                    </p>
                </div>
            </div>
        </div>

    </section>


    <section class="px-7 py-10 lg:p-32">
        <div class="w-full lg:container lg:mx-auto">
            <h1 class="font-bold mb-7 text-lg lg:text-4xl lg:mb-16">
                {{ __('2040') }}
            </h1>
            <img src="{{ asset('images/2040.png') }}" alt="">
        </div>
    </section>
@endsection
