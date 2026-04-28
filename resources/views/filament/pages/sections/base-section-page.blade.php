<x-filament-panels::page>
    <form wire:submit="save" class="fi-sc-form">
        {{ $this->form }}

        <div style="margin-top: 1.5rem;">
            <x-filament::button type="submit" color="primary" icon="heroicon-o-check">
                Сохранить изменения
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
