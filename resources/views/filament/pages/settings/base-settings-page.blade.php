<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <x-filament::button type="submit" color="primary" icon="heroicon-o-check">
            Сохранить
        </x-filament::button>
    </x-filament-panels::form>
</x-filament-panels::page>
