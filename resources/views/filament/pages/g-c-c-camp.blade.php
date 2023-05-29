<x-filament::page>
    <div class="col-span-full">
        <div id="maalomat-asasy" class="filament-forms-section-component rounded-xl border border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-800">
            <div class="filament-forms-section-header-wrapper flex rtl:space-x-reverse overflow-hidden rounded-t-xl min-h-[56px] px-4 py-2 items-center bg-gray-100 dark:bg-gray-900">
                <div class="filament-forms-section-header flex-1 space-y-1">
                    <h3 class="font-bold tracking-tight pointer-events-none flex flex-row items-center text-xl">
                        ضوابط المشاركة
                    </h3>

                </div>

            </div>

            <div class="filament-forms-section-content-wrapper">
                <div class="filament-forms-section-content p-6">
                    <div class="grid grid-cols-1 filament-forms-component-container gap-6">
                        <ul>
                            <ul>
                                <li>١-أن يكون المشارك من عمر ١٩ إلى ٢٥ سنة</li>
                                <li>٢-أن يكون المشارك عماني الجنسية</li>
                                <li>٣-أن يكون المشارك باحث عن عمل</li>
                                <li>٤-يحط بعين الأعتبار للمشاركين حاصل على شهادات مشاركات محلية او دولية أو الحاصلين على جوائز محلية لإنجازات وطنية</li>
                                <li>٥-أن يملك المشارك مهارات فنية او عملية</li>
                                <li>٦-أن يلتزم بتمثيل سلطنة عمان بأحسن صورة</li>
                                <li>٧-سوف يتم الأخذ بعين الإعتبار في إختيار المشاركين بناءاً على الأسئلة المرفقة</li>
                            </ul>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form wire:submit.prevent="register">
        {{ $this->form }}
        <button
            class="filament-button mt-4 filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2rem] px-3 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">{{ __('Register') }}</button>
    </form>

    {{ $this->table }}
</x-filament::page>
