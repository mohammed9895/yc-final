<div class="">
    <div class="space-y-2">
        <div class="filament-modal-header px-6 py-2">
            <h2 class="filament-modal-heading text-xl font-bold tracking-tight">
                Request a Talent
            </h2>
        </div>
        <form wire:submit.prevent="request">
            <div aria-hidden="true" class="filament-hr border-t  px-2"></div>
            <div class="filament-modal-content space-y-2 p-2">
                <div class="px-4 py-2 space-y-2">
                    @if(session('error'))
                        <div class="bg-red-200 p-4 text-red-700 mb-4 rounded flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 h-6 text-red-700">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                            </svg>
                            <p class="ml-2">{{ session('error') }}</p>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="bg-green-200 p-4 text-green-700-700 mb-4 rounded flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 h-6 text-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                            </svg>
                            <p class="ml-2">{{ session('success') }}</p>
                        </div>
                    @endif
                    <label for="reason" class="">Reason</label>
                    <textarea wire:model="reason" id="reason" required
                              class="block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70  dark:focus:border-primary-500 border-gray-300"></textarea>
                </div>
            </div>
            <div class="space-y-2">
                <div aria-hidden="true" class="filament-hr border-t px-2"></div>

                <div class="filament-modal-footer px-6 py-2">
                    <div class="filament-modal-actions flex flex-wrap items-center gap-4 rtl:space-x-reverse">
                        <button type="submit"
                                class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-purple-700 hover:bg-purple-600 focus:bg-primary-700 focus:ring-offset-primary-700 filament-tables-modal-button-action">
                            Send Now
                        </button>

                        <button type="button"
                                class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800 filament-tables-modal-button-action"
                                wire:click="$emit('closeModal')">
                            <span class="flex items-center gap-1">
                                <span class="">
                                    Cancel
                                </span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <button tabindex="-1" type="button" class="absolute top-2 right-2 rtl:right-auto rtl:left-2"
            wire:click="$emit('closeModal')">
        <svg title="Close" tabindex="-1" class="filament-modal-close-button h-4 w-4 cursor-pointer text-gray-400"
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">
            Close
        </span>
    </button>
</div>
