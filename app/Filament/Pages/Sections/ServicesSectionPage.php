<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;

class ServicesSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'services';
    protected static ?string $navigationLabel = 'Услуги';
    protected static ?string $title = 'Секция «Услуги»';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;
    protected static ?int $navigationSort = 4;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Заголовок секции')
                ->columns(2)
                ->schema([
                    TextInput::make('heading.badge')->label('Бейдж')->placeholder('Услуги')->maxLength(255),
                    TextInput::make('heading.title')->label('Первая строка')->placeholder('С чем я')->maxLength(255),
                    TextInput::make('heading.subtitle')->label('Вторая строка')->placeholder('работаю')->maxLength(255),
                    Textarea::make('heading.body')->label('Подзаголовок / подходы')->rows(2)->columnSpanFull(),
                    Toggle::make('heading.is_visible')->label('Показывать секцию')->default(true)->columnSpanFull(),
                ]),

            Section::make('Вид карточек')
                ->description('Настройте размер и стиль карточек на десктопе. Превью обновляется автоматически.')
                ->columns(2)
                ->schema([
                    Select::make('heading.meta.card_cols')
                        ->label('Ширина карточки (десктоп)')
                        ->options([
                            '3' => '⅓ экрана — 3 колонки',
                            '2' => '½ экрана — 2 колонки',
                            '1' => 'Полный экран — 1 колонка',
                        ])
                        ->default('3')
                        ->native(false)
                        ->live(),

                    Select::make('heading.meta.card_variant')
                        ->label('Стиль карточки')
                        ->options([
                            'default'  => 'Default — фоновое число + градиент снизу',
                            'minimal'  => 'Minimal — иконка, заголовок, текст',
                            'bordered' => 'Bordered — цветная рамка слева',
                            'filled'   => 'Filled — заливка акцентным цветом',
                        ])
                        ->default('default')
                        ->native(false)
                        ->live(),

                    Placeholder::make('card_layout_preview')
                        ->label('Превью — светлая и тёмная тема')
                        ->dehydrated(false)
                        ->live()
                        ->content(function (Get $get): HtmlString {
                            $cols    = $get('heading.meta.card_cols') ?: '3';
                            $variant = $get('heading.meta.card_variant') ?: 'default';
                            return new HtmlString(self::buildCardPreview($cols, $variant));
                        })
                        ->columnSpanFull(),
                ]),

            Section::make('С чем работаю — карточки проблем')
                ->description('Иконка — название из Lucide Icons. Цвет акцента: amber, rose, teal, violet, emerald, indigo.')
                ->columns(3)
                ->schema([
                    TextInput::make('issue_1.title')->label('Карточка 1 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_1.label')->label('Иконка (Lucide)')->placeholder('heart-crack')->maxLength(100),
                    TextInput::make('issue_1.badge')->label('Цвет акцента')->placeholder('rose')->maxLength(50),
                    Textarea::make('issue_1.body')->label('Описание')->rows(2)->columnSpanFull(),

                    TextInput::make('issue_2.title')->label('Карточка 2 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_2.label')->label('Иконка (Lucide)')->placeholder('zap')->maxLength(100),
                    TextInput::make('issue_2.badge')->label('Цвет акцента')->placeholder('amber')->maxLength(50),
                    Textarea::make('issue_2.body')->label('Описание')->rows(2)->columnSpanFull(),

                    TextInput::make('issue_3.title')->label('Карточка 3 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_3.label')->label('Иконка (Lucide)')->placeholder('compass')->maxLength(100),
                    TextInput::make('issue_3.badge')->label('Цвет акцента')->placeholder('teal')->maxLength(50),
                    Textarea::make('issue_3.body')->label('Описание')->rows(2)->columnSpanFull(),

                    TextInput::make('issue_4.title')->label('Карточка 4 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_4.label')->label('Иконка (Lucide)')->placeholder('mountain-snow')->maxLength(100),
                    TextInput::make('issue_4.badge')->label('Цвет акцента')->placeholder('violet')->maxLength(50),
                    Textarea::make('issue_4.body')->label('Описание')->rows(2)->columnSpanFull(),

                    TextInput::make('issue_5.title')->label('Карточка 5 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_5.label')->label('Иконка (Lucide)')->placeholder('battery-low')->maxLength(100),
                    TextInput::make('issue_5.badge')->label('Цвет акцента')->placeholder('emerald')->maxLength(50),
                    Textarea::make('issue_5.body')->label('Описание')->rows(2)->columnSpanFull(),

                    TextInput::make('issue_6.title')->label('Карточка 6 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_6.label')->label('Иконка (Lucide)')->placeholder('users-round')->maxLength(100),
                    TextInput::make('issue_6.badge')->label('Цвет акцента')->placeholder('indigo')->maxLength(50),
                    Textarea::make('issue_6.body')->label('Описание')->rows(2)->columnSpanFull(),
                ]),

            Section::make('Форматы работы')
                ->columns(3)
                ->schema([
                    TextInput::make('format_1.title')->label('Формат 1')->placeholder('Онлайн')->maxLength(255),
                    TextInput::make('format_2.title')->label('Формат 2')->placeholder('Очно')->maxLength(255),
                    TextInput::make('format_3.title')->label('Формат 3')->placeholder('55 минут')->maxLength(255),
                    Textarea::make('format_1.body')->label('Описание 1')->rows(2),
                    Textarea::make('format_2.body')->label('Описание 2')->rows(2),
                    Textarea::make('format_3.body')->label('Описание 3')->rows(2),
                ]),

            Section::make('Стандартная консультация (цена)')
                ->columns(2)
                ->schema([
                    TextInput::make('price_regular.title')->label('Заголовок')->maxLength(255),
                    TextInput::make('price_regular.subtitle')->label('Подзаголовок')->maxLength(255),
                    Textarea::make('price_regular.body')->label('Описание')->rows(2)->columnSpanFull(),
                    TextInput::make('price_regular.meta.price')
                        ->label('Цена (число)')
                        ->numeric()
                        ->placeholder('3500'),
                    TextInput::make('price_regular.meta.currency')
                        ->label('Валюта')
                        ->placeholder('RUB')
                        ->maxLength(10),
                ]),

            Section::make('Акция / регулярная терапия (цена)')
                ->columns(2)
                ->schema([
                    TextInput::make('price_promo.badge')->label('Бейдж')->placeholder('Акция')->maxLength(100),
                    TextInput::make('price_promo.title')->label('Заголовок')->maxLength(255),
                    TextInput::make('price_promo.subtitle')->label('Подзаголовок')->maxLength(255),
                    Textarea::make('price_promo.body')->label('Описание')->rows(2)->columnSpanFull(),
                    TextInput::make('price_promo.meta.price')
                        ->label('Цена (число)')
                        ->numeric()
                        ->placeholder('2000'),
                    TextInput::make('price_promo.meta.currency')
                        ->label('Валюта')
                        ->placeholder('RUB')
                        ->maxLength(10),
                    TextInput::make('price_promo.meta.left_places')
                        ->label('Осталось мест')
                        ->numeric()
                        ->placeholder('2'),
                ]),
        ];
    }

    /**
     * Возвращает HTML-превью карточек в светлой и тёмной теме.
     * Все стили inline — не зависит от landing.css.
     */
    private static function buildCardPreview(string $cols, string $variant): string
    {
        $sampleCards = [
            [
                'emoji'    => '💔',
                'accent'   => '#fb7185',
                'accentBg' => 'rgba(251,113,133,.13)',
                'title'    => 'Тревога',
                'desc'     => 'Навязчивые мысли и постоянное беспокойство',
            ],
            [
                'emoji'    => '⚡',
                'accent'   => '#f59e0b',
                'accentBg' => 'rgba(245,158,11,.13)',
                'title'    => 'Выгорание',
                'desc'     => 'Нет сил ни на работу, ни на близких',
            ],
            [
                'emoji'    => '🧭',
                'accent'   => '#2dd4bf',
                'accentBg' => 'rgba(45,212,191,.13)',
                'title'    => 'Кризис',
                'desc'     => 'Потеря смысла, ощущение тупика',
            ],
        ];

        $colsInt      = max(1, min(3, (int) $cols));
        $cardCount    = $colsInt === 1 ? 2 : $colsInt;
        $previewCards = array_slice($sampleCards, 0, $cardCount);
        $gridCols     = $colsInt === 1 ? '1fr' : "repeat({$colsInt}, 1fr)";
        $gridStyle    = "display:grid;grid-template-columns:{$gridCols};gap:8px;";

        $themes = [
            [
                'label'  => '☀ Светлая тема',
                'bg'     => '#fdf8f0',
                'cardBg' => '#ffffff',
                'border' => '#e5dcc5',
                'title'  => '#1a1210',
                'desc'   => '#7c6c5c',
                'meta'   => '#a09080',
            ],
            [
                'label'  => '🌙 Тёмная тема',
                'bg'     => '#14171c',
                'cardBg' => '#1e2128',
                'border' => '#2d3139',
                'title'  => '#e8ddd0',
                'desc'   => '#8a8a9a',
                'meta'   => '#666677',
            ],
        ];

        $renderCard = static function (array $c, array $t, string $v, int $i): string {
            $num  = str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);
            $base = "position:relative;padding:.9rem 1rem 1.05rem;border-radius:9px;"
                . "overflow:hidden;display:flex;flex-direction:column;gap:.5rem;"
                . "background:{$t['cardBg']};border:1px solid {$t['border']};";

            $numHtml  = "<span style='position:absolute;top:-4px;right:7px;"
                . "font-size:3rem;font-weight:900;line-height:1;"
                . "color:{$c['accent']};opacity:.08;pointer-events:none;'>{$num}</span>";
            $iconHtml = "<span style='display:inline-flex;align-items:center;justify-content:center;"
                . "width:2rem;height:2rem;border-radius:.5rem;"
                . "background:{$c['accentBg']};font-size:.95rem;flex-shrink:0;'>{$c['emoji']}</span>";
            $titleHtml = "<span style='font-size:.8rem;font-weight:700;"
                . "color:{$t['title']};line-height:1.2;'>{$c['title']}</span>";
            $descHtml  = "<span style='font-size:.72rem;line-height:1.45;"
                . "color:{$t['desc']};'>{$c['desc']}</span>";
            $lineHtml  = "<span style='position:absolute;bottom:0;left:0;right:0;"
                . "height:3px;background:linear-gradient(90deg,{$c['accent']},transparent);'></span>";

            return match ($v) {
                'minimal'  => "<div style='{$base}gap:.4rem;padding:.8rem;'>"
                    . "{$iconHtml}{$titleHtml}{$descHtml}</div>",

                'bordered' => "<div style='{$base}border-left:3px solid {$c['accent']};'>"
                    . "{$iconHtml}{$titleHtml}{$descHtml}</div>",

                'filled'   => "<div style='{$base}background:{$c['accentBg']};"
                    . "border-color:{$c['accent']}55;'>"
                    . "{$iconHtml}{$titleHtml}{$descHtml}</div>",

                default    => "<div style='{$base}'>"
                    . "{$numHtml}{$iconHtml}{$titleHtml}{$descHtml}{$lineHtml}</div>",
            };
        };

        $html = '<div style="display:flex;gap:10px;font-family:Manrope,system-ui,sans-serif;">';

        foreach ($themes as $t) {
            $html .= "<div style='flex:1;min-width:0;background:{$t['bg']};padding:10px;border-radius:9px;'>";
            $html .= "<p style='font-size:10px;text-transform:uppercase;letter-spacing:.07em;"
                . "color:{$t['meta']};margin:0 0 7px;font-weight:600;'>{$t['label']}</p>";
            $html .= "<div style='{$gridStyle}'>";
            foreach ($previewCards as $i => $card) {
                $html .= $renderCard($card, $t, $variant, $i);
            }
            $html .= '</div></div>';
        }

        $html .= '</div>';

        return $html;
    }
}
