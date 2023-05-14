<div>
    <form wire:submit.prevent="submitForm">
        <div class="px-3 py-4">
            <div class="grid grid-cols-2 gap-2 mb-5">
                <div>
                    <input type="text" wire:model="fullname" class="border border-gray-300 rounded-md px-2 py-4 w-full"
                        placeholder="{{ __('الاسم والقبيلة') }}" required>
                    @error('fullname')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <input type="number" wire:model="phone" class="border border-gray-300 rounded-md px-2 py-4 w-full"
                        placeholder="{{ __('رقم الهاتف') }}">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 mb-5">
                <div>
                    <input type="email" wire:model="email" class="border border-gray-300 rounded-md px-2 py-4 w-full"
                        placeholder="{{ __('البريد الإلكتوني') }}">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 mb-5">
                <div>
                    <input type="text" wire:model="subject"
                        class="border border-gray-300 rounded-md px-2 py-4 w-full"
                        placeholder="{{ __('الموضـــــــــــــوع') }}">
                    @error('subject')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1">
                <div>
                    <textarea placeholder="{{ __('الرسالة...') }}" wire:model="message"
                        class="border min-h-[118px] max-h-[118px] border-gray-300 rounded-md px-2 py-4 h-full w-full"></textarea>
                    @error('message')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>


            <div>
                    @if (session()->has('message'))

                        <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
  <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
  <span class="sr-only">Info</span>
  <div>
     {{ session('message') }}
  </div>
</div>
                    @endif
                </div>
            <button
                class="text-white mt-5 bg-lime-400 hover:bg-lime-400 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 dark:bg-lime-400 dark:hover:bg-lime-400 dark:focus:ring-lime-400">{{ __('أرسال') }}</button>

        </div>
    </form>
</div>
