<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use App\Models\LandingBlock;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use UnitEnum;

abstract class BaseSectionPage extends Page
{
    protected string $view = 'filament.pages.sections.base-section-page';
    protected static UnitEnum|string|null $navigationGroup = 'Редактирование контента';

    protected static string $sectionCode = '';

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $blocks = LandingBlock::where('section_code', static::$sectionCode)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('block_key');

        $formData = [];
        foreach ($blocks as $key => $block) {
            $formData[$key] = [
                'label'       => $block->label,
                'badge'       => $block->badge,
                'title'       => $block->title,
                'subtitle'    => $block->subtitle,
                'body'        => $block->body,
                'button_text' => $block->button_text,
                'button_url'  => $block->button_url,
                'is_visible'  => $block->is_visible,
                'meta'        => $block->meta ?? [],
            ];
        }

        $this->form->fill($formData);
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
        $state = $this->form->getState();

        $rows = [];
        foreach ($state as $blockKey => $blockData) {
            $meta = $blockData['meta'] ?? null;
            $rows[] = [
                'section_code' => static::$sectionCode,
                'block_key'    => $blockKey,
                'label'        => $blockData['label'] ?? null,
                'badge'        => $blockData['badge'] ?? null,
                'title'        => $blockData['title'] ?? null,
                'subtitle'     => $blockData['subtitle'] ?? null,
                'body'         => $blockData['body'] ?? null,
                'button_text'  => $blockData['button_text'] ?? null,
                'button_url'   => $blockData['button_url'] ?? null,
                'is_visible'   => (bool) ($blockData['is_visible'] ?? true),
                'meta'         => is_array($meta) && !empty($meta) ? json_encode($meta) : null,
            ];
        }

        if (!empty($rows)) {
            LandingBlock::upsert(
                $rows,
                ['section_code', 'block_key'],
                ['label', 'badge', 'title', 'subtitle', 'body', 'button_text', 'button_url', 'is_visible', 'meta'],
            );
        }

        Notification::make()
            ->title('Сохранено')
            ->success()
            ->send();
    }
}
