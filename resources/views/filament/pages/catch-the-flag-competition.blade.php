<x-filament::page>
    <div class="col-span-full">
        <div id="maalomat-asasy"
             class="filament-forms-section-component rounded-xl border border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-800">
            <div
                class="filament-forms-section-header-wrapper flex rtl:space-x-reverse overflow-hidden rounded-t-xl min-h-[56px] px-4 py-2 items-center bg-gray-100 dark:bg-gray-900">
                <div class="filament-forms-section-header flex-1 space-y-1">
                    <h3 class="font-bold tracking-tight pointer-events-none flex flex-row items-center text-xl">
                        ضوابط المشاركة
                    </h3>
                    <p>
                        مسابقة تنافسية تهدف إلى اختبار مهارات الأمن السيبراني وقدرات الاختراق الإيجابية، يتنافس
                        المشاركون في حل تحديات تقنية وأمنية. تعزز المسابقة للمشاركين في تطوير مهاراتهم والتعلم التجريبي
                        مشابهًا لبيئة العمل وكسب الثقة وعرض مهاراتهم وخبراتهم للشركات والمؤسسات.

                    </p>
                </div>

            </div>

            <div class="filament-forms-section-content-wrapper">
                <div class="filament-forms-section-content p-6">
                    <div class="grid grid-cols-1 filament-forms-component-container gap-6">
                        <ul>
                            <ul>
                                <li>تاريخ المسابقة: 16 أغسطس 2024</li>
                                <li>الوقت:9:00٠ صباحًا - 5:00 مساءً
                                </li>
                                <li>الموقع: مجمع السلطان قابوس الشبابي للثقافة والترفيه، محافظة ظفار.
                                </li>
                                <li>الفريق يتكون من ٣ أفراد.
                                </li>
                                <li>الجوائز:
                                </li>
                                <li>المركز الأول: 1500 ريال</li>
                                <li>المركز الثاني: 1200 ريال</li>
                                <li>المركز الثالث: 1000 ريال</li>
                            </ul>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($open)
        @if($isRegistered > 0)
            <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                 role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3 rtl:mr-0 ml-3"
                     fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                          clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    {{ __('You have already registered') }}
                </div>
            </div>
        @else
            <form wire:submit.prevent="register">
                {{ $this->form }}
                <button
                    class="filament-button mt-4 filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2rem] px-3 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">{{ __('Register') }}</button>
            </form>
        @endif
    @else
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
             role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3 rtl:mr-0 ml-3"
                 fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                      clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                {{ __('Registration is closed') }}
            </div>
        </div>
    @endif
</x-filament::page>
