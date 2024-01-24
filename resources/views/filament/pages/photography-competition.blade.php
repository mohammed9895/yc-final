<x-filament::page>
    @if($open)
        @if(app()->currentLocale() == 'ar')
            <p>
                يسر مركز الشباب و مجموعة كيمجي رامداس بالتعاون مع نيكون عن إطلاق مسابقة منظرة عمانية بنسختها الثانية.
                بمناسبه تولي حضره صاحب الجلاله السلطان هيثم بن طارق مقاليد الحكم .
            </p>
            <p><span class="font-bold">مدة المسابقة :</span> من ١٤ يناير إلى ٣١ يناير</p>
            <table class="border-collapse border border-slate-400 dark:bg-gray-900 bg-white w-full">
                <thead>
                <th class="border border-slate-300 p-3">التاريخ</th>
                <th class="border border-slate-300 p-3">الفعالية</th>
                </thead>
                <tbody>
                <tr>
                    <td class="border border-slate-300 p-2">14 يناير</td>
                    <td class="border border-slate-300 p-2">إعلان عن المسابقة</td>
                </tr>
                <tr>
                    <td class="border border-slate-300 p-2">18 يناير</td>
                    <td class="border border-slate-300 p-2">إغلاق المشاركة</td>
                </tr>
                <tr>
                    <td class="border border-slate-300 p-2">24 يناير</td>
                    <td class="border border-slate-300 p-2">اختيار المتأهلين والإعلان عنهم</td>
                </tr>
                <tr>
                    <td class="border border-slate-300 p-2">26 يناير</td>
                    <td class="border border-slate-300 p-2">جولة التصوير في مطرح</td>
                </tr>
                <tr>
                    <td class="border border-slate-300 p-2">31 يناير</td>
                    <td class="border border-slate-300 p-2">يوم الحفل وإعلان الفائزين</td>
                </tr>
                </tbody>
            </table>
            <p class="font-bold">سيتم اختيار 15 متاهل للقيام بالتصوير الحي في مطرح بتاريخ 26 يوم الجمعة من الساعة 2:30
                الى 6
                مساءاً</p>
        @else
            <p>
                Youth Center and Kimji Ramdas Group, in collaboration with Nikon, are pleased to announce the launch of
                the
                second edition of Omani Mirror Photography Contest.On the occasion of His Majesty Sultan Haitham bin
                Tariq
                assuming the reins of power
            </p>
            <p><span class="font-bold"><span class="font-bold">Contest Duration:</span> January 14th  to 31st</p>
            <table class="border-collapse border border-slate-400 bg-white dark:bg-gray-900 w-full">
                <thead>
                <th class="border border-slate-300 p-3">Date</th>
                <th class="border border-slate-300 p-3">Event</th>
                </thead>
                <tbody>
                <tr>
                    <td class="border border-slate-300 p-2">14 January</td>
                    <td class="border border-slate-300 p-2">Contest Announcement</td>
                </tr>
                <tr>
                    <td class="border border-slate-300 p-2">18 January</td>
                    <td class="border border-slate-300 p-2">Participation Deadline</td>
                </tr>
                <tr>
                    <td class="border border-slate-300 p-2">24 January</td>
                    <td class="border border-slate-300 p-2">Selection of qualifiers and results announcement</td>
                </tr>
                <tr>
                    <td class="border border-slate-300 p-2">26 January</td>
                    <td class="border border-slate-300 p-2">Photography tour in Mutrah</td>
                </tr>
                <tr>
                    <td class="border border-slate-300 p-2">31 January</td>
                    <td class="border border-slate-300 p-2">Ceremony and Winners Announcement</td>
                </tr>
                </tbody>
            </table>
            <p class="font-bold">15 qualified individuals will be selected to conduct live shooting in Mutrah on the
                26th of
                January from 14:30 to 18:00.
            </p>
        @endif
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
