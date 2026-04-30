<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use App\Models\LandingBlock;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;

class AboutSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'about';
    protected static ?string $navigationLabel = 'Обо мне';
    protected static ?string $title = 'Секция «Обо мне»';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;
    protected static ?int $navigationSort = 3;

    public function mount(): void
    {
        $heading = LandingBlock::where('section_code', 'about')
            ->where('block_key', 'heading')
            ->first();

        $slides = LandingBlock::where('section_code', 'about')
            ->where('block_type', 'about_slide')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (LandingBlock $block): array => [
                'label'        => $block->label,
                'title'        => $block->title,
                'body'         => $block->body,
                'button_url'   => $block->button_url,
                'photo_mobile' => $block->meta['photo_mobile'] ?? null,
                'is_visible'   => $block->is_visible,
            ])
            ->toArray();

        $this->form->fill([
            'heading' => [
                'badge'      => $heading?->badge,
                'title'      => $heading?->title,
                'subtitle'   => $heading?->subtitle,
                'is_visible' => $heading?->is_visible ?? true,
            ],
            'slides' => $slides,
        ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $headingData = $state['heading'] ?? [];
        LandingBlock::upsert(
            [[
                'section_code' => 'about',
                'block_key'    => 'heading',
                'badge'        => $headingData['badge'] ?? null,
                'title'        => $headingData['title'] ?? null,
                'subtitle'     => $headingData['subtitle'] ?? null,
                'is_visible'   => (bool) ($headingData['is_visible'] ?? true),
                'label'        => null,
                'body'         => null,
                'button_text'  => null,
                'button_url'   => null,
                'meta'         => null,
            ]],
            ['section_code', 'block_key'],
            ['badge', 'title', 'subtitle', 'is_visible'],
        );

        LandingBlock::where('section_code', 'about')
            ->where('block_type', 'about_slide')
            ->delete();

        foreach (($state['slides'] ?? []) as $i => $slide) {
            LandingBlock::create([
                'section_code' => 'about',
                'block_key'    => 'slide_' . ($i + 1),
                'block_type'   => 'about_slide',
                'sort_order'   => $i + 10,
                'label'        => $slide['label'] ?? null,
                'title'        => $slide['title'] ?? null,
                'body'         => $slide['body'] ?? null,
                'button_url'   => $slide['button_url'] ?? null,
                'is_visible'   => (bool) ($slide['is_visible'] ?? true),
                'meta'         => ['photo_mobile' => $slide['photo_mobile'] ?? null],
            ]);
        }

        Notification::make()
            ->title('Сохранено')
            ->success()
            ->send();
    }

    protected function getFormComponents(): array
    {
        return [
            Section::make('Заголовок секции')
                ->columns(2)
                ->schema([
                    TextInput::make('heading.badge')
                        ->label('Бейдж')
                        ->placeholder('Обо мне')
                        ->maxLength(255),
                    TextInput::make('heading.title')
                        ->label('Первая строка заголовка')
                        ->placeholder('Немного')
                        ->maxLength(255),
                    TextInput::make('heading.subtitle')
                        ->label('Вторая строка заголовка')
                        ->placeholder('обо мне')
                        ->maxLength(255),
                    Toggle::make('heading.is_visible')
                        ->label('Показывать секцию')
                        ->default(true)
                        ->columnSpanFull(),
                ]),

            Section::make('Слайды')
                ->description('Перетащите слайды для изменения порядка. Рекомендуется до 450 символов текста на слайд (~10 строк).')
                ->schema([
                    Repeater::make('slides')
                        ->label('')
                        ->schema([
                            TextInput::make('title')
                                ->label('Заголовок слайда')
                                ->placeholder('Здравствуйте, я Александр')
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->columnSpanFull(),

                            TextInput::make('label')
                                ->label('Иконка (Lucide)')
                                ->placeholder('message-circle')
                                ->helperText('Название с lucide.dev: user, heart, flame, graduation-cap…')
                                ->maxLength(100),

                            Toggle::make('is_visible')
                                ->label('Показывать слайд')
                                ->default(true),

                            FileUpload::make('button_url')
                                ->label('Фото — Desktop')
                                ->image()
                                ->disk('public')
                                ->directory('about/slides')
                                ->imagePreviewHeight('160')
                                ->imageEditor()
                                ->imageEditorAspectRatios(['16:9', '4:3', null])
                                ->downloadable()
                                ->live(),

                            FileUpload::make('photo_mobile')
                                ->label('Фото — Mobile (необязательно)')
                                ->image()
                                ->disk('public')
                                ->directory('about/slides/mobile')
                                ->imagePreviewHeight('160')
                                ->imageEditor()
                                ->imageEditorAspectRatios(['9:16', '3:4', null])
                                ->helperText('Если не загружено — используется Desktop-фото')
                                ->downloadable()
                                ->live(),

                            Textarea::make('body')
                                ->label('Текст слайда')
                                ->helperText('Абзацы разделяйте пустой строкой (два Enter).')
                                ->live(onBlur: true)
                                ->hint(fn (string $state = ''): string => mb_strlen($state) > 0
                                    ? mb_strlen($state) . ' символов' . (mb_strlen($state) > 450 ? ' ⚠ превышает рекомендуемые 450' : '')
                                    : ''
                                )
                                ->rows(6)
                                ->columnSpanFull(),

                            Placeholder::make('slide_preview')
                                ->label('Превью как в слайдере на телефоне')
                                ->helperText('Те же высота блока, градиент и подложка текста, что на лендинге (мобайл). Сначала mobile-фото, иначе desktop — как <picture> на сайте.')
                                ->dehydrated(false)
                                ->live()
                                ->content(function (Get $get): HtmlString {
                                    $photo        = $get('button_url');
                                    $photoMobile = $get('photo_mobile');
                                    $title        = $get('title') ?: 'Заголовок слайда';
                                    $body         = $get('body') ?: '';

                                    $bodyPreview = mb_substr(strip_tags($body), 0, 160)
                                        . (mb_strlen($body) > 160 ? '…' : '');

                                    $imageRaw = $photoMobile ?: $photo;
                                    $url      = self::resolveSlideImageUrl($imageRaw);

                                    if ($url === null) {
                                        return new HtmlString(
                                            '<div style="width:100%;max-width:390px;min-height:140px;border-radius:12px;'
                                            . 'background:#f3f4f6;display:flex;align-items:center;justify-content:center;'
                                            . 'color:#6b7280;font-size:.875rem;padding:1rem;text-align:center;">'
                                            . 'Загрузите фото (desktop или mobile) — здесь будет то же кадрирование, что в слайдере.'
                                            . '</div>'
                                        );
                                    }

                                    // Совпадает с landing.css: .about-slider (мобайл) + градиент + текстовая карточка
                                    return new HtmlString(
                                        '<div style="position:relative;width:100%;max-width:390px;height:min(72svh, 520px);'
                                        . 'min-height:280px;border-radius:12px;overflow:hidden;font-family:Manrope,system-ui,sans-serif;'
                                        . 'box-shadow:0 8px 32px rgba(0,0,0,.18);">'

                                        . '<img src="' . e($url) . '" alt="" style="position:absolute;inset:0;'
                                        . 'width:100%;height:100%;object-fit:cover;object-position:center top;">'

                                        . '<div style="position:absolute;inset:0;pointer-events:none;'
                                        . 'background:linear-gradient(to bottom,'
                                        . 'transparent 0%,transparent 25%,'
                                        . 'rgba(0,0,0,.38) 50%,rgba(0,0,0,.74) 72%,rgba(0,0,0,.92) 100%);"></div>'

                                        . '<div style="position:absolute;bottom:0;left:0;right:0;'
                                        . 'padding:1rem 1.15rem 1.1rem;'
                                        . 'background:rgba(0,0,0,.52);'
                                        . 'backdrop-filter:blur(22px);-webkit-backdrop-filter:blur(22px);'
                                        . 'border-radius:1.25rem 1.25rem 0 0;">'
                                        . '<div style="color:#fff!important;font-size:clamp(1.15rem,4vw,1.35rem);'
                                        . 'font-weight:700;line-height:1.15;margin-bottom:.35rem;">' . e($title) . '</div>'
                                        . '<div style="color:rgba(255,255,255,.85)!important;font-size:.875rem;line-height:1.55;">'
                                        . e($bodyPreview) . '</div>'
                                        . '</div>'

                                        . '</div>'
                                    );
                                })
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->reorderable()
                        ->deletable()
                        ->addActionLabel('Добавить слайд')
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?: 'Новый слайд')
                        ->columnSpanFull(),
                ]),
        ];
    }

    /**
     * Как в {@see LandingPageController}: путь из БД / FileUpload → URL для <img>.
     */
    private static function resolveSlideImageUrl(mixed $raw): ?string
    {
        if ($raw === null || $raw === '') {
            return null;
        }

        if (is_array($raw)) {
            $raw = reset($raw);
        }

        if (! is_string($raw) || $raw === '') {
            return null;
        }

        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
            return $raw;
        }

        return asset('storage/' . ltrim($raw, '/'));
    }
}
