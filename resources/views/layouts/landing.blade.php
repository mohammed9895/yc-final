<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'en' ? 'lrt' : 'rtl' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Youth Center</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />

    <link href="
        https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css
        "
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    @livewireStyles
</head>

<body>
    @include('layouts.partials.nav')
    @yield('content')
    <section class="py-10 lg:py-32 bg-blue-700 lg:rounded-tl-[100px]">
        <div class="container mx-auto">
            <div class="bg-white rounded-xl">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                    @livewire('frontend.contact-form')
                    <div>
                        <iframe
                            class="w-full rounded-b-xl rtl:lg:rounded-l-xl lg:rounded-r-xl
                            "
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7312.769871711222!2d58.40432949357911!3d23.590523900000008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e91ff1beff66c19%3A0xdb4811de1e38911d!2sYouth%20Center!5e0!3m2!1sen!2som!4v1682611540288!5m2!1sen!2som"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
            <div class="flex justify-between flex-col lg:flex-row text-center text-white mt-4">
                <div>
                    {{ __('جميع الحقوق محفوظة لـ مركز الشباب - سلطنة عمان') }}
                </div>
                <div class="mt-10 lg:mt-0">
                    <ul class="flex justify-center space-x-3 lg:space-x-3">
                        <li>
                            <a href="#">{{ __('سياسة الخصوصية') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ __('الشروط والأحكام') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ __('أكثر الأسئلة تكراراً') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex justify-center mt-10">
                <ul class="flex space-x-3">
                    <li class="rtl:ml-3">
                        <a href="#">
                            <i class="fab fa-facebook fa-xl text-white hover:text-lime-400 transition-all"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fab fa-twitter fa-xl text-white hover:text-lime-400 transition-all"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fab fa-youtube fa-xl text-white hover:text-lime-400 transition-all"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fab fa-instagram fa-xl text-white hover:text-lime-400 transition-all"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fab fa-linkedin fa-xl text-white hover:text-lime-400 transition-all"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fab fa-snapchat fa-xl text-white hover:text-lime-400 transition-all"></i>
                        </a>
                    </li>
                    <li class="text-white uppercase">
                        youthcenter_om
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                rtl: true,
                loop: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 6
                    }
                }
            });
            $(document).scroll(function() {
                var $nav = $(".navbar-fixed-top");
                $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
            });
        });
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-N19JTR2SPE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-N19JTR2SPE');
    </script>

    <!-- Alpine v3 -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Focus plugin -->
    <script defer src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>

    @livewire('livewire-ui-modal')

    @livewireScripts

</body>

</html>
