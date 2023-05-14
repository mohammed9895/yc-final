<section
    class="w-full relative rounded-bl-[100px] h-72 bg-fixed bg-[url({{ asset('images/hero.jpg') }})] bg-cover bg-center">
    <div
        class="absolute top-0 left-0 w-full h-full z-10 rounded-bl-[100px] bg-gradient-to-tr from-fuchsia-500 to-purple-900 opacity-50">
    </div>
    <div class="container relative flex-col mx-auto z-50">
        <div class="flex justify-center text-center items-center h-72 md:justify-start md:rtl:text-right">
            <div class="text-6xl space-y-5 text-white capitalize">
                <h1 class="text-bold">{{ $title }}</h1>
            </div>
        </div>
    </div>
</section>
