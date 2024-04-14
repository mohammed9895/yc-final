<x-filament::page>
    @if($open)
        <p>
            يعمل مركز الشباب على فتح فرص التدريب لعدد من الشباب في قسم العمليات، بهدف تمكينهم من تطوير المهارات
            الضرورية لإدارة المساحات بشكل ف ّعال وتنظيم الفعاليات والبرامج بشكل يلبي احتياجات وتطلعات الشباب و تطوير
            مستويات الالتزام بالسلوكيات
            المهنية والأخلاقية.
        </p>
        <p><span class="font-bold">مدة التدر يب :</span>3 أشهر</p>
        <p><span class="font-bold">أن يكون المتقدم من سكان محافظة مسقط</span></p>
        <p><span class="font-bold">أن يكون المتقدم باحثا عن العمل</span></p>
        <p><span class="font-bold">أن يكون المتقدم في الفئة العمرية (٢٠ -٢٩)</span></p>
        <p><span class="font-bold">ساعات العمل: ٧ ساعات</span></p>
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
