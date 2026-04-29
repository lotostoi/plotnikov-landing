<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use App\Models\LandingBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class PricingSectionPage extends Page
{
    protected string $view = 'filament.pages.sections.base-section-page';
    protected static UnitEnum|string|null $navigationGroup = 'Редактирование контента';
    protected static ?string $navigationLabel = 'Консультации';
    protected static ?string $title = 'Секция «Консультации и цены»';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;
    protected static ?int $navigationSort = 4;

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $blocks = LandingBlock::where('section_code', 'pricing')
            ->orderBy('sort_order')
            ->get()
            ->keyBy('block_key');

        $formData = [];

        // Заголовок и консультации — стандартные блоки
        foreach (['heading', 'online', 'offline'] as $key) {
            $block = $blocks->get($key);
            $formData[$key] = [
                'badge'       => $block?->badge,
                'label'       => $block?->label,
                'title'       => $block?->title,
                'subtitle'    => $block?->subtitle,
                'body'        => $block?->body,
                'button_text' => $block?->button_text,
                'button_url'  => $block?->button_url,
                'is_visible'  => $block?->is_visible ?? true,
            ];
        }

        // Акции — Repeater
        $promos = LandingBlock::where('section_code', 'pricing')
            ->where('block_type', 'promo')
            ->orderBy('sort_order')
            ->get();

        $formData['promos'] = $promos->map(fn (LandingBlock $b): array => [
            'badge'       => $b->badge,
            'title'       => $b->title,
            'subtitle'    => $b->subtitle,
            'body'        => $b->body,
            'button_text' => $b->button_text,
            'is_visible'  => $b->is_visible,
        ])->values()->all();

        $this->form->fill($formData);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Заголовок секции')
                    ->columns(3)
                    ->schema([
                        TextInput::make('heading.badge')->label('Бейдж')->placeholder('Консультации')->maxLength(255),
                        TextInput::make('heading.title')->label('Первая строка')->placeholder('Форматы')->maxLength(255),
                        TextInput::make('heading.subtitle')->label('Вторая строка')->placeholder('и стоимость')->maxLength(255),
                        Toggle::make('heading.is_visible')->label('Показывать секцию')->default(true)->columnSpanFull(),
                    ]),

                Section::make('Онлайн-консультация')
                    ->columns(2)
                    ->schema([
                        TextInput::make('online.title')->label('Название')->placeholder('Онлайн-консультация')->maxLength(255),
                        TextInput::make('online.subtitle')->label('Подзаголовок (где/как)')->placeholder('Из любой точки мира')->maxLength(255),
                        TextInput::make('online.badge')->label('Цена (отображается)')->placeholder('3 500 руб.')->maxLength(100),
                        TextInput::make('online.label')->label('Иконка (Lucide)')->placeholder('video')->maxLength(100),
                        Textarea::make('online.body')
                            ->label('Описание (каждый пункт — с новой строки)')
                            ->rows(4)->columnSpanFull(),
                        TextInput::make('online.button_text')->label('Текст кнопки')->placeholder('Записаться')->maxLength(100),
                        TextInput::make('online.button_url')->label('Ссылка кнопки')->placeholder('#contacts')->maxLength(500),
                        Toggle::make('online.is_visible')->label('Показывать')->default(true)->columnSpanFull(),
                    ]),

                Section::make('Очная консультация')
                    ->columns(2)
                    ->schema([
                        TextInput::make('offline.title')->label('Название')->placeholder('Очная консультация')->maxLength(255),
                        TextInput::make('offline.subtitle')->label('Город')->placeholder('Владивосток, Артём')->maxLength(255),
                        TextInput::make('offline.badge')->label('Цена (отображается)')->placeholder('3 500 руб.')->maxLength(100),
                        TextInput::make('offline.label')->label('Иконка (Lucide)')->placeholder('map-pin')->maxLength(100),
                        Textarea::make('offline.body')
                            ->label('Описание (каждый пункт — с новой строки)')
                            ->rows(4)->columnSpanFull(),
                        TextInput::make('offline.button_text')->label('Текст кнопки')->placeholder('Записаться')->maxLength(100),
                        TextInput::make('offline.button_url')->label('Ссылка кнопки')->placeholder('#contacts')->maxLength(500),
                        Toggle::make('offline.is_visible')->label('Показывать')->default(true)->columnSpanFull(),
                    ]),

                Section::make('Акции и специальные предложения')
                    ->schema([
                        Repeater::make('promos')
                            ->label('')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Название акции')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('subtitle')
                                    ->label('Цена (отображается)')
                                    ->placeholder('2 000 руб./сессию')
                                    ->maxLength(100),

                                TextInput::make('badge')
                                    ->label('Ярлык')
                                    ->placeholder('Акция')
                                    ->maxLength(100),

                                Textarea::make('body')
                                    ->label('Описание')
                                    ->rows(3)
                                    ->columnSpanFull(),

                                TextInput::make('button_text')
                                    ->label('Условия (мелкий текст)')
                                    ->placeholder('1 раз в неделю · осталось 2 места')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Toggle::make('is_visible')
                                    ->label('Показывать')
                                    ->default(true)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Добавить акцию')
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?: 'Новая акция')
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        // Стандартные блоки (heading, online, offline)
        $rows = [];
        $typeMap = ['heading' => 'text', 'online' => 'consult', 'offline' => 'consult'];

        foreach (['heading', 'online', 'offline'] as $key) {
            $d = $state[$key] ?? [];
            $rows[] = [
                'section_code' => 'pricing',
                'block_key'    => $key,
                'block_type'   => $typeMap[$key],
                'badge'        => $d['badge'] ?? null,
                'label'        => $d['label'] ?? null,
                'title'        => $d['title'] ?? null,
                'subtitle'     => $d['subtitle'] ?? null,
                'body'         => $d['body'] ?? null,
                'button_text'  => $d['button_text'] ?? null,
                'button_url'   => $d['button_url'] ?? null,
                'is_visible'   => (bool) ($d['is_visible'] ?? true),
                'sort_order'   => match ($key) { 'heading' => 10, 'online' => 20, 'offline' => 30 },
                'meta'         => null,
            ];
        }

        LandingBlock::upsert(
            $rows,
            ['section_code', 'block_key'],
            ['block_type', 'badge', 'label', 'title', 'subtitle', 'body', 'button_text', 'button_url', 'is_visible'],
        );

        // Акции — удаляем старые, вставляем новые
        LandingBlock::where('section_code', 'pricing')
            ->where('block_type', 'promo')
            ->delete();

        foreach ($state['promos'] ?? [] as $i => $promo) {
            if (empty($promo['title'])) {
                continue;
            }
            LandingBlock::create([
                'section_code' => 'pricing',
                'block_key'    => 'promo_' . ($i + 1),
                'block_type'   => 'promo',
                'badge'        => $promo['badge'] ?? 'Акция',
                'title'        => $promo['title'] ?? null,
                'subtitle'     => $promo['subtitle'] ?? null,
                'body'         => $promo['body'] ?? null,
                'button_text'  => $promo['button_text'] ?? null,
                'is_visible'   => (bool) ($promo['is_visible'] ?? true),
                'sort_order'   => ($i + 1) * 10 + 30,
            ]);
        }

        Notification::make()->title('Сохранено')->success()->send();
    }
}
