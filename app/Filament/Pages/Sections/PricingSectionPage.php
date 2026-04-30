<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use App\Models\LandingBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
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
            ->orderBy('id')
            ->get()
            ->keyBy('block_key');

        $heading = $blocks->get('heading');

        $consults = LandingBlock::where('section_code', 'pricing')
            ->where('block_type', 'consult')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(function (LandingBlock $b): array {
                $meta = $b->meta ?? [];

                return [
                    'title'          => $b->title,
                    'subtitle'       => $b->subtitle,
                    'badge'          => $b->badge,
                    'label'          => $b->label,
                    'body'           => $b->body,
                    'button_text'    => $b->button_text,
                    'button_url'     => $b->button_url,
                    'is_visible'     => $b->is_visible ?? true,
                    'desktop_span'   => $meta['desktop_span'] ?? 'half',
                    'subtitle_icon'  => $meta['subtitle_icon'] ?? ($b->block_key === 'offline' ? 'map-pin' : 'globe'),
                ];
            })
            ->values()
            ->all();

        $promos = LandingBlock::where('section_code', 'pricing')
            ->where('block_type', 'promo')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $this->form->fill([
            'heading' => [
                'badge'       => $heading?->badge,
                'title'       => $heading?->title,
                'subtitle'    => $heading?->subtitle,
                'is_visible'  => $heading?->is_visible ?? true,
            ],
            'consults' => $consults,
            'promos'   => $promos->map(fn (LandingBlock $b): array => [
                'badge'       => $b->badge,
                'title'       => $b->title,
                'subtitle'    => $b->subtitle,
                'body'        => $b->body,
                'button_text' => $b->button_text,
                'is_visible'  => $b->is_visible,
            ])->values()->all(),
        ]);
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

                Section::make('Карточки консультаций')
                    ->description('Перетащите строки за ручку слева, чтобы изменить порядок. Пустые карточки при сохранении не создаются. Удаление — кнопка корзины у строки.')
                    ->schema([
                        Repeater::make('consults')
                            ->label('')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Название')
                                    ->placeholder('Онлайн-консультация')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('subtitle')
                                    ->label('Подзаголовок (где / как)')
                                    ->placeholder('Из любой точки мира')
                                    ->maxLength(255),

                                TextInput::make('badge')
                                    ->label('Цена (как на карточке)')
                                    ->placeholder('3 500 руб.')
                                    ->maxLength(100),

                                TextInput::make('label')
                                    ->label('Иконка карточки (Lucide)')
                                    ->placeholder('video')
                                    ->maxLength(100),

                                Select::make('subtitle_icon')
                                    ->label('Иконка у подзаголовка')
                                    ->options([
                                        'globe'   => 'Глобус (онлайн)',
                                        'map-pin' => 'Метка (адрес / город)',
                                    ])
                                    ->default('globe'),

                                Select::make('desktop_span')
                                    ->label('Ширина на десктопе (от md)')
                                    ->options([
                                        'half' => 'Половина ряда — две карточки в ряд',
                                        'full' => 'На всю ширину сетки (одна карточка в ряд)',
                                    ])
                                    ->default('half')
                                    ->columnSpanFull(),

                                Textarea::make('body')
                                    ->label('Описание (каждый пункт — с новой строки)')
                                    ->rows(4)
                                    ->columnSpanFull(),

                                TextInput::make('button_text')
                                    ->label('Текст кнопки')
                                    ->placeholder('Записаться')
                                    ->maxLength(100),

                                TextInput::make('button_url')
                                    ->label('Ссылка кнопки')
                                    ->placeholder('#contacts')
                                    ->maxLength(500),

                                Toggle::make('is_visible')
                                    ->label('Показывать')
                                    ->default(true)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->reorderable()
                            ->deletable()
                            ->addActionLabel('Добавить консультацию')
                            ->collapsible()
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?: 'Новая консультация')
                            ->columnSpanFull(),
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

        $heading = $state['heading'] ?? [];
        LandingBlock::updateOrCreate(
            [
                'section_code' => 'pricing',
                'block_key'    => 'heading',
            ],
            [
                'block_type'  => 'text',
                'badge'       => $heading['badge'] ?? null,
                'title'       => $heading['title'] ?? null,
                'subtitle'    => $heading['subtitle'] ?? null,
                'is_visible'  => (bool) ($heading['is_visible'] ?? true),
                'label'       => null,
                'body'        => null,
                'button_text' => null,
                'button_url'  => null,
                'meta'        => null,
            ],
        );

        LandingBlock::where('section_code', 'pricing')
            ->where('block_type', 'consult')
            ->delete();

        $consultIdx = 0;
        foreach ($state['consults'] ?? [] as $row) {
            if (empty(trim((string) ($row['title'] ?? '')))) {
                continue;
            }
            $consultIdx++;
            LandingBlock::create([
                'section_code' => 'pricing',
                'block_key'    => 'consult_' . $consultIdx,
                'block_type'   => 'consult',
                'label'        => $row['label'] ?? 'video',
                'badge'        => $row['badge'] ?? null,
                'title'        => $row['title'] ?? null,
                'subtitle'     => $row['subtitle'] ?? null,
                'body'         => $row['body'] ?? null,
                'button_text'  => $row['button_text'] ?? null,
                'button_url'   => $row['button_url'] ?? null,
                'is_visible'   => (bool) ($row['is_visible'] ?? true),
                'sort_order'   => $consultIdx * 10,
                'meta'         => [
                    'desktop_span'  => $row['desktop_span'] ?? 'half',
                    'subtitle_icon' => $row['subtitle_icon'] ?? 'globe',
                ],
            ]);
        }

        LandingBlock::where('section_code', 'pricing')
            ->where('block_type', 'promo')
            ->delete();

        $promoIdx = 0;
        foreach ($state['promos'] ?? [] as $promo) {
            if (empty($promo['title'])) {
                continue;
            }
            $promoIdx++;
            LandingBlock::create([
                'section_code' => 'pricing',
                'block_key'    => 'promo_' . $promoIdx,
                'block_type'   => 'promo',
                'badge'        => $promo['badge'] ?? 'Акция',
                'title'        => $promo['title'] ?? null,
                'subtitle'     => $promo['subtitle'] ?? null,
                'body'         => $promo['body'] ?? null,
                'button_text'  => $promo['button_text'] ?? null,
                'is_visible'   => (bool) ($promo['is_visible'] ?? true),
                'sort_order'   => $promoIdx * 10 + 100,
            ]);
        }

        Notification::make()->title('Сохранено')->success()->send();
    }
}
