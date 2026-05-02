<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use App\Models\LandingBlock;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;
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
                    'title'         => $b->title,
                    'subtitle'      => $b->subtitle,
                    'badge'         => $b->badge,
                    'label'         => $b->label,
                    'body'          => $b->body,
                    'button_text'   => $b->button_text,
                    'button_url'    => $b->button_url,
                    'is_visible'    => $b->is_visible ?? true,
                    'desktop_span'  => $meta['desktop_span'] ?? 'half',
                    'subtitle_icon' => $meta['subtitle_icon'] ?? ($b->block_key === 'offline' ? 'map-pin' : 'globe'),
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
                'badge'      => $heading?->badge,
                'title'      => $heading?->title,
                'subtitle'   => $heading?->subtitle,
                'is_visible' => $heading?->is_visible ?? true,
                'meta'       => $heading?->meta ?? [],
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

                Section::make('Вид карточек консультаций')
                    ->description('Настройте сетку и стиль. Превью обновляется при изменении.')
                    ->columns(2)
                    ->schema([
                        Select::make('heading.meta.card_cols')
                            ->label('Количество колонок (десктоп)')
                            ->options([
                                '2' => '½ экрана — 2 колонки',
                                '3' => '⅓ экрана — 3 колонки',
                                '1' => 'Полный экран — 1 колонка',
                            ])
                            ->default('2')
                            ->native(false)
                            ->live(),

                        Select::make('heading.meta.card_variant')
                            ->label('Стиль карточки консультации')
                            ->options([
                                'default'  => 'Default — рамка, градиент при ховере',
                                'bordered' => 'Bordered — акцентная рамка',
                                'minimal'  => 'Minimal — подчёркивание, без фона',
                                'elevated' => 'Elevated — без рамки, тень',
                            ])
                            ->default('default')
                            ->native(false)
                            ->live(),

                        Select::make('heading.meta.promo_cols')
                            ->label('Количество колонок акций (десктоп)')
                            ->options([
                                '2' => '½ экрана — 2 колонки',
                                '3' => '⅓ экрана — 3 колонки',
                                '1' => 'Полный экран — 1 колонка',
                            ])
                            ->default('3')
                            ->native(false)
                            ->live(),

                        Placeholder::make('pricing_card_preview')
                            ->label('Превью — светлая и тёмная тема')
                            ->dehydrated(false)
                            ->live()
                            ->content(function (Get $get): HtmlString {
                                $cols    = $get('heading.meta.card_cols') ?: '2';
                                $variant = $get('heading.meta.card_variant') ?: 'default';
                                return new HtmlString(self::buildCardPreview($cols, $variant));
                            })
                            ->columnSpanFull(),
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
                                    ->label('Ширина этой карточки (десктоп)')
                                    ->options([
                                        'half' => 'Обычная — заполняет один слот сетки',
                                        'full' => 'Полная ширина — на весь ряд',
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
        $meta    = $heading['meta'] ?? [];

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
                'meta'        => [
                    'card_cols'    => $meta['card_cols'] ?? '2',
                    'card_variant' => $meta['card_variant'] ?? 'default',
                    'promo_cols'   => $meta['promo_cols'] ?? '3',
                ],
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

    /**
     * Inline-styled HTML-превью карточек консультаций в светлой и тёмной теме.
     */
    private static function buildCardPreview(string $cols, string $variant): string
    {
        $sampleCards = [
            [
                'emoji' => '🎥',
                'title' => 'Онлайн',
                'sub'   => '🌐 Из любой точки мира',
                'price' => '3 500 руб.',
                'items' => ['55 минут', 'Zoom / Telegram', 'Запись сессии по запросу'],
            ],
            [
                'emoji' => '📍',
                'title' => 'Очно',
                'sub'   => '📌 Владивосток, Артём',
                'price' => '3 500 руб.',
                'items' => ['55 минут', 'Приватный кабинет', 'Гибкий график'],
            ],
            [
                'emoji' => '🔄',
                'title' => 'Регулярная терапия',
                'sub'   => '🌐 Онлайн или очно',
                'price' => '2 000 руб.',
                'items' => ['1 раз в неделю', 'Скидка при регулярности', 'Осталось 2 места'],
            ],
        ];

        $colsInt      = max(1, min(3, (int) $cols));
        $cardCount    = min($colsInt === 1 ? 2 : $colsInt, 3);
        $previewCards = array_slice($sampleCards, 0, $cardCount);
        $gridCols     = $colsInt === 1 ? '1fr' : "repeat({$colsInt}, 1fr)";
        $gridStyle    = "display:grid;grid-template-columns:{$gridCols};gap:8px;";

        $accent = '#f59e0b';

        $themes = [
            [
                'label'  => '☀ Светлая тема',
                'bg'     => '#fdf8f0',
                'cardBg' => '#ffffff',
                'border' => '#e5dcc5',
                'title'  => '#1a1210',
                'sub'    => '#7c6c5c',
                'price'  => '#c87920',
                'item'   => '#6c6050',
                'meta'   => '#a09080',
                'btn'    => '#c87920',
            ],
            [
                'label'  => '🌙 Тёмная тема',
                'bg'     => '#14171c',
                'cardBg' => '#1e2128',
                'border' => '#2d3139',
                'title'  => '#e8ddd0',
                'sub'    => '#8a8a9a',
                'price'  => '#f59e0b',
                'item'   => '#888896',
                'meta'   => '#555566',
                'btn'    => '#f59e0b',
            ],
        ];

        $renderCard = static function (array $c, array $t, string $v) use ($accent): string {
            $baseStyle = match ($v) {
                'bordered' => "display:flex;flex-direction:column;gap:.7rem;padding:1.1rem 1.2rem;"
                    . "border-radius:12px;border:2px solid {$accent}44;background:{$t['cardBg']};",

                'minimal'  => "display:flex;flex-direction:column;gap:.7rem;padding:1.1rem 1.2rem 1.3rem;"
                    . "border-radius:0;border:none;border-bottom:2px solid {$t['border']};background:transparent;",

                'elevated' => "display:flex;flex-direction:column;gap:.7rem;padding:1.1rem 1.2rem;"
                    . "border-radius:12px;border:none;background:{$t['cardBg']};"
                    . "box-shadow:0 8px 24px -8px rgba(0,0,0,.18);",

                default    => "display:flex;flex-direction:column;gap:.7rem;padding:1.1rem 1.2rem;"
                    . "border-radius:12px;border:1px solid {$t['border']};background:{$t['cardBg']};",
            };

            $iconHtml  = "<span style='font-size:1.3rem;'>{$c['emoji']}</span>";
            $titleHtml = "<span style='font-size:.83rem;font-weight:700;color:{$t['title']};'>{$c['title']}</span>";
            $subHtml   = "<span style='font-size:.7rem;color:{$t['sub']};'>{$c['sub']}</span>";
            $priceHtml = "<span style='font-size:1.25rem;font-weight:800;color:{$t['price']};'>{$c['price']}</span>";

            $itemsHtml = '';
            foreach (array_slice($c['items'], 0, 2) as $item) {
                $itemsHtml .= "<div style='font-size:.7rem;color:{$t['item']};'>✓ {$item}</div>";
            }

            $btnHtml = "<span style='display:inline-flex;align-items:center;gap:.35rem;font-size:.72rem;"
                . "font-weight:700;color:#fff;padding:.35rem .9rem;border-radius:99px;"
                . "background:{$t['btn']};align-self:flex-start;margin-top:auto;'>Записаться →</span>";

            return "<div style='{$baseStyle}'>"
                . "<div style='display:flex;align-items:center;gap:.5rem;'>{$iconHtml}{$titleHtml}</div>"
                . $subHtml . $priceHtml . $itemsHtml . $btnHtml
                . "</div>";
        };

        $html = '<div style="display:flex;gap:10px;font-family:Manrope,system-ui,sans-serif;">';

        foreach ($themes as $t) {
            $html .= "<div style='flex:1;min-width:0;background:{$t['bg']};padding:10px;border-radius:9px;'>";
            $html .= "<p style='font-size:10px;text-transform:uppercase;letter-spacing:.07em;"
                . "color:{$t['meta']};margin:0 0 7px;font-weight:600;'>{$t['label']}</p>";
            $html .= "<div style='{$gridStyle}'>";
            foreach ($previewCards as $card) {
                $html .= $renderCard($card, $t, $variant);
            }
            $html .= '</div></div>';
        }

        $html .= '</div>';

        return $html;
    }
}
