<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use App\Models\LandingBlock;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class EducationSectionPage extends Page
{
    protected string $view = 'filament.pages.sections.base-section-page';
    protected static UnitEnum|string|null $navigationGroup = 'Редактирование контента';
    protected static ?string $navigationLabel = 'Образование';
    protected static ?string $title = 'Секция «Образование»';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static ?int $navigationSort = 5;

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $allBlocks = LandingBlock::where('section_code', 'education')
            ->orderBy('sort_order')
            ->get();

        $formData = [];

        // Стандартные блоки (заголовок, стат, подходы)
        foreach ($allBlocks as $block) {
            if (str_starts_with($block->block_key, 'edu_')) {
                continue;
            }
            $formData[$block->block_key] = [
                'label'       => $block->label,
                'badge'       => $block->badge,
                'title'       => $block->title,
                'subtitle'    => $block->subtitle,
                'body'        => $block->body,
                'button_text' => $block->button_text,
                'button_url'  => $block->button_url,
                'is_visible'  => $block->is_visible,
            ];
        }

        // Учебные блоки → Repeater
        $eduCards = $allBlocks->filter(
            fn (LandingBlock $b): bool =>
                $b->block_type === 'card'
                && str_starts_with($b->block_key, 'edu_')
                && !str_contains($b->block_key, '_cert_')
        );

        $formData['education_items'] = $eduCards->map(function (LandingBlock $block) use ($allBlocks): array {
            $prefix = $block->block_key . '_cert_';

            $certs = $allBlocks
                ->filter(fn (LandingBlock $b): bool => str_starts_with($b->block_key, $prefix))
                ->map(fn (LandingBlock $b): array => ['path' => $b->button_url])
                ->values()
                ->all();

            return [
                'title'       => $block->title,
                'subtitle'    => $block->subtitle,
                'badge'       => $block->badge,
                'label'       => $block->label,
                'button_text' => $block->button_text,
                'certs'       => $certs,
            ];
        })->values()->all();

        $this->form->fill($formData);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Фотография секции')
                    ->description('Портретное фото справа. Если не загружено — используется фото по умолчанию.')
                    ->schema([
                        FileUpload::make('heading.button_url')
                            ->label('Фото (портрет)')
                            ->image()
                            ->disk('public')
                            ->directory('education')
                            ->imagePreviewHeight('200')
                            ->imageEditor()
                            ->imageEditorAspectRatios(['3:4', '2:3', null])
                            ->downloadable()
                            ->helperText('Рекомендуется портретная ориентация (3:4).'),
                    ]),

                Section::make('Заголовок секции')
                    ->columns(2)
                    ->schema([
                        TextInput::make('heading.badge')->label('Бейдж')->placeholder('Образование')->maxLength(255),
                        TextInput::make('heading.title')->label('Первая строка')->placeholder('Опыт и')->maxLength(255),
                        TextInput::make('heading.subtitle')->label('Вторая строка')->placeholder('образование')->maxLength(255),
                        Toggle::make('heading.is_visible')->label('Показывать секцию')->default(true)->columnSpanFull(),
                    ]),

                Section::make('Учебные заведения')
                    ->schema([
                        Repeater::make('education_items')
                            ->label('')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Название программы / курса')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('subtitle')
                                    ->label('Учебное заведение')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('badge')
                                    ->label('Статус')
                                    ->placeholder('Завершено / В процессе')
                                    ->maxLength(100),

                                TextInput::make('label')
                                    ->label('Иконка (Lucide)')
                                    ->placeholder('graduation-cap')
                                    ->maxLength(100),

                                TextInput::make('button_text')
                                    ->label('Цвет акцента')
                                    ->placeholder('amber')
                                    ->helperText('amber · teal · rose · violet · sky · green')
                                    ->maxLength(50),

                                Repeater::make('certs')
                                    ->label('Документы / сертификаты')
                                    ->schema([
                                        FileUpload::make('path')
                                            ->label('Файл')
                                            ->image()
                                            ->disk('public')
                                            ->directory('education/certs')
                                            ->imagePreviewHeight('180')
                                            ->imageEditor()
                                            ->imageEditorAspectRatios(['4:3', '3:2', null])
                                            ->downloadable()
                                            ->columnSpanFull(),
                                    ])
                                    ->addActionLabel('Добавить документ')
                                    ->reorderable(false)
                                    ->grid(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->addActionLabel('Добавить учебное заведение')
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?: 'Новое учебное заведение')
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ]),

                Section::make('Опыт (числовые показатели)')
                    ->columns(2)
                    ->schema([
                        TextInput::make('exp_1.title')->label('Опыт 1 — цифра')->placeholder('12+')->maxLength(50),
                        TextInput::make('exp_1.subtitle')->label('Опыт 1 — подпись')->maxLength(255),
                        TextInput::make('exp_1.body')->label('Опыт 1 — уточнение')->maxLength(255),
                        TextInput::make('exp_1.label')->label('Опыт 1 — иконка')->placeholder('clock')->maxLength(100),

                        TextInput::make('exp_2.title')->label('Опыт 2 — цифра')->placeholder('10')->maxLength(50),
                        TextInput::make('exp_2.subtitle')->label('Опыт 2 — подпись')->maxLength(255),
                        TextInput::make('exp_2.body')->label('Опыт 2 — уточнение')->maxLength(255),
                        TextInput::make('exp_2.label')->label('Опыт 2 — иконка')->placeholder('users')->maxLength(100),
                    ]),

                Section::make('Подходы (теги)')
                    ->columns(2)
                    ->schema([
                        TextInput::make('approach_1.title')->label('Подход 1')->maxLength(255),
                        TextInput::make('approach_2.title')->label('Подход 2')->maxLength(255),
                        TextInput::make('approach_3.title')->label('Подход 3')->maxLength(255),
                        TextInput::make('approach_4.title')->label('Подход 4')->maxLength(255),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        // 1. Стандартные блоки (upsert)
        $standardRows = [];
        foreach ($state as $blockKey => $blockData) {
            if ($blockKey === 'education_items' || !is_array($blockData)) {
                continue;
            }
            $standardRows[] = [
                'section_code' => 'education',
                'block_key'    => $blockKey,
                'label'        => $blockData['label'] ?? null,
                'badge'        => $blockData['badge'] ?? null,
                'title'        => $blockData['title'] ?? null,
                'subtitle'     => $blockData['subtitle'] ?? null,
                'body'         => $blockData['body'] ?? null,
                'button_text'  => $blockData['button_text'] ?? null,
                'button_url'   => $blockData['button_url'] ?? null,
                'is_visible'   => (bool) ($blockData['is_visible'] ?? true),
                'meta'         => null,
            ];
        }

        if (!empty($standardRows)) {
            LandingBlock::upsert(
                $standardRows,
                ['section_code', 'block_key'],
                ['label', 'badge', 'title', 'subtitle', 'body', 'button_text', 'button_url', 'is_visible', 'meta'],
            );
        }

        // 2. Блоки учёбы: удаляем все старые, вставляем новые
        LandingBlock::where('section_code', 'education')
            ->where(function ($q): void {
                $q->where(function ($q2): void {
                    $q2->where('block_type', 'card')
                        ->where('block_key', 'like', 'edu_%');
                })->orWhere('block_type', 'cert');
            })
            ->delete();

        foreach ($state['education_items'] ?? [] as $i => $item) {
            $eduKey   = 'edu_' . ($i + 1);
            $sortBase = ($i + 1) * 10;

            LandingBlock::create([
                'section_code' => 'education',
                'block_key'    => $eduKey,
                'block_type'   => 'card',
                'title'        => $item['title'] ?? null,
                'subtitle'     => $item['subtitle'] ?? null,
                'badge'        => $item['badge'] ?? null,
                'label'        => $item['label'] ?? null,
                'button_text'  => $item['button_text'] ?? null,
                'is_visible'   => true,
                'sort_order'   => $sortBase,
            ]);

            foreach ((array) ($item['certs'] ?? []) as $j => $cert) {
                $path = $cert['path'] ?? null;
                if (empty($path)) {
                    continue;
                }
                LandingBlock::create([
                    'section_code' => 'education',
                    'block_key'    => $eduKey . '_cert_' . ($j + 1),
                    'block_type'   => 'cert',
                    'button_url'   => $path,
                    'sort_order'   => $sortBase + $j + 1,
                ]);
            }
        }

        Notification::make()->title('Сохранено')->success()->send();
    }
}
