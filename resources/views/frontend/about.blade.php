@extends('layouts.landing')

@include('layouts.partials.title', ['title' => 'ما هو مركز الشباب'])

@section('content')
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

    <section class=" relative bg-[url({{ asset('images/bg.svg') }})] bg-fixed w-full bg-cover bg-center mt-20">
        <div class="container mx-auto pt-32 pb-32">
            <h1 class="font-bold text-white text-4xl mt-10 mb-8 text-center">
                أهدافنا
                الاستراتيجـــية
            </h1>
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 lg:gap-4">
                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/1.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">تــنــمــــــيــــة</h1>
                    <p class="text-white text-center">معارف وخبرات الشباب في مجالات الإبداع والابتكار.</p>
                </div>

                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/2.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">تــنــمــــــيــــة</h1>
                    <p class="text-white text-center">معارف وخبرات الشباب في مجالات الإبداع والابتكار.</p>
                </div>

                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/3.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">تعزيــز وتطــويــر</h1>
                    <p class="text-white text-center">التعاون مع المؤسسات الشبابية المحلية والإقليمية والدولية في
                        الأهداف المتعلقة بالمركز.</p>
                </div>


                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/4.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">توفــــيـــــر</h1>
                    <p class="text-white text-center">مساحــــــــــــــات تتناسب مع متطلبات الشباب من مختلف المجالات
                        والاهتمامات.
                    </p>
                </div>

                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/5.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">التــكــامــل</h1>
                    <p class="text-white text-center">مع الجهات والمؤسسات الحكومية والخاصة ومؤسسات المجتمع المدني في
                        دعم وتطوير قطاع الشباب في مختلف المجالات.</p>
                </div>

                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/6.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">اكتشـــاف وتطـــويـــر </h1>
                    <p class="text-white text-center">مهارات و مواهب الشباب وتنميتـــــــــــها
                        وتقديــــــــــــــــــم الاستشارات اللازمة للشباب.
                    </p>
                </div>

                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md">
                    <img src="{{ asset('images/strategis/7.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">تـــعــــزيــــــز</h1>
                    <p class="text-white text-center">مشاركة الشباب في مختلف المشاريع والمبادرات والفعاليات المتنوعة،
                        وتنفيذ برامج ومبادرات تسهم في صقل مهارات ومواهب الشباب.</p>
                </div>

                <div
                    class="backdrop-blur-sm flex flex-col items-center justify-between bg-white/30 rounded-lg p-6 transition-all hover:backdrop-blur-md ">
                    <img src="{{ asset('images/strategis/1.svg') }}" class=" text-white w-16 mb-4" alt="">
                    <h1 class=" text-lime-400 font-bold text-xl">المساهــمـــة </h1>
                    <p class="text-white text-center">في بناء مجتمع شبابي قادر على المشاركة بفاعلية وكفاءة لتحقيق أهداف
                        رؤية عُمان 2040.
                    </p>
                </div>
            </div>
        </div>

    </section>


    <section class="px-7 py-10 lg:p-32">
        <div class="w-full lg:container lg:mx-auto">
            <h1 class="font-bold mb-7 text-lg lg:text-4xl lg:mb-16">
                مؤشرات عمان 2040
            </h1>
            <img src="{{ asset('images/2040.png') }}" alt="">
        </div>
    </section>
@endsection
