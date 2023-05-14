<x-filament::page>
    @if (session()->has('verified'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            {{ session('verified') }}
        </div>
    @endif
    @if (!Auth::user()->hasVerifiedPhone())
        @livewire('user.verifiy-user')
    @endif
</x-filament::page>
