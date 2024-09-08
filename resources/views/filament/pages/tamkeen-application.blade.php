<x-filament::page>
    <img src="{{ asset('images/Asset 2.svg') }}" width="200" alt="">
    <form wire:submit.prevent="register">
        {{ $this->form }}
        <button
            class="filament-button mt-4 filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2rem] px-3 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">{{ __('Register') }}</button>
    </form>
</x-filament::page>
