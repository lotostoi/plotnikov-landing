<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use App\Models\LandingPageContent;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Livewire\Attributes\Locked;
use UnitEnum;

abstract class BaseSettingsPage extends Page
{
    protected string $view = 'filament.pages.settings.base-settings-page';
    protected static UnitEnum|string|null $navigationGroup = 'Настройки';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    #[Locked]
    public ?int $recordId = null;

    public function mount(): void
    {
        $record = LandingPageContent::query()->firstOrFail();
        $this->recordId = $record->id;
        $this->form->fill($record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components($this->getFormComponents());
    }

    /** @return array<mixed> */
    abstract protected function getFormComponents(): array;

    public function save(): void
    {
        $record = LandingPageContent::query()->findOrFail($this->recordId);
        $record->update($this->form->getState());

        Notification::make()
            ->title('Сохранено')
            ->success()
            ->send();
    }
}
