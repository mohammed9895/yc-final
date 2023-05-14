<x-filament::page>
    <form wire:submit.prevent="register">
        {{ $this->form }}
    </form>

    {{ $this->table }}
</x-filament::page>
