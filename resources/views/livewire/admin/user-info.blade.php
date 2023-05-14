<div>
    <div class="space-y-2">
        <div class="filament-modal-header px-6 py-2">
            <h2 class="filament-modal-heading text-xl font-bold tracking-tight flex align-middle items-center">
                @if ($user->avatar)
                    <img src="/storage/{{ $user->avatar }}" class="w-12 h-12 rounded-full mr-2" alt="">
                @endif
                {{ $user->name }}
                Information
            </h2>
        </div>
        <form wire:submit.prevent="book">
            <div aria-hidden="true" class="filament-hr border-t dark:border-gray-700 px-2"></div>
            <div class="filament-modal-content space-y-2 p-2">


                <div class="px-4 py-2 space-y-4">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                        <dl
                            class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                            <div class="flex flex-col pb-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Full Name</dt>
                                <dd class="text-lg font-semibold">{{ $user->name }}</dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Email</dt>
                                <dd class="text-lg font-semibold">{{ $user->email }}</dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Phone number</dt>
                                <dd class="text-lg font-semibold">+968 {{ $user->phone }}</dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Civil Number</dt>
                                <dd class="text-lg font-semibold">{{ $user->civil_no }}</dd>
                            </div>

                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Education Type</dt>
                                <dd class="text-lg font-semibold">{{ $user->educationType->name }}</dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Employee Type</dt>
                                <dd class="text-lg font-semibold">{{ $user->employeeType->name }}</dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Disability</dt>
                                <dd class="text-lg font-semibold">{{ $user->disability->name }}</dd>
                            </div>
                        </dl>
                        <dl
                            class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                            <div class="flex flex-col pb-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Birth Day</dt>
                                <dd class="text-lg font-semibold">{{ $user->birth_date }}</dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Gender</dt>
                                <dd class="text-lg font-semibold">{{ $user->gender == 0 ? 'Mele' : 'Female' }}</dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Citizen</dt>
                                <dd class="text-lg font-semibold">
                                    {{ $user->citizen == 0 ? 'Omani' : 'None Omani' }}</dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Country</dt>
                                <dd class="text-lg font-semibold">{{ $user->country->name }}</dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Province</dt>
                                <dd class="text-lg font-semibold">{{ $user->province->name }}</dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">State</dt>
                                <dd class="text-lg font-semibold">{{ $user->state->name }}</dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400"></dt>
                                <dd class="text-lg font-semibold">

                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                <div aria-hidden="true" class="filament-hr border-t dark:border-gray-700 px-2"></div>

                <div class="filament-modal-footer px-6 py-2">
                    <div class="filament-modal-actions flex flex-wrap items-center gap-4 rtl:space-x-reverse">
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
