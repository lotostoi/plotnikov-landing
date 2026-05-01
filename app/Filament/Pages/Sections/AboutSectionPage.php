<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use App\Models\LandingBlock;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
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
                'button_url'            => $block->button_url,
                'photo_mobile'          => $block->meta['photo_mobile'] ?? null,
                'photo_mobile_position' => $block->meta['photo_mobile_position'] ?? '50% 20%',
                'is_visible'            => $block->is_visible,
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
                'meta'         => [
                    'photo_mobile'          => $slide['photo_mobile'] ?? null,
                    'photo_mobile_position' => $slide['photo_mobile_position'] ?? '50% 20%',
                ],
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

                            Hidden::make('photo_mobile_position')
                                ->default('50% 20%'),

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
                                ->label('Превью на телефоне — кликните на фото чтобы выбрать фокус')
                                ->helperText('Оранжевая точка — текущий фокус. Нажмите в нужное место фото чтобы сдвинуть кадрирование.')
                                ->dehydrated(false)
                                ->live()
                                ->content(function (Get $get, Placeholder $component): HtmlString {
                                    $photo        = $get('button_url');
                                    $photoMobile  = $get('photo_mobile');
                                    $title        = $get('title') ?: 'Заголовок слайда';
                                    $body         = $get('body') ?: '';
                                    $position     = $get('photo_mobile_position') ?: '50% 20%';

                                    // Полный текст — чтобы карточка в превью занимала столько же места, сколько на телефоне
                                    $bodyFull = nl2br(e(strip_tags($body)));

                                    $imageRaw = $photoMobile ?: $photo;
                                    $url      = self::resolveSlideImageUrl($imageRaw);

                                    // Вычисляем wire-path для $wire.set() в Alpine
                                    $statePath   = $component->getStatePath();
                                    $parentPath  = substr($statePath, 0, (int) strrpos($statePath, '.'));
                                    $posWirePath = $parentPath . '.photo_mobile_position';

                                    if ($url === null) {
                                        return new HtmlString(
                                            '<div style="width:100%;max-width:390px;min-height:140px;border-radius:12px;'
                                            . 'background:#f3f4f6;display:flex;align-items:center;justify-content:center;'
                                            . 'color:#6b7280;font-size:.875rem;padding:1rem;text-align:center;">'
                                            . 'Загрузите фото — здесь появится превью с фокус-пикером.'
                                            . '</div>'
                                        );
                                    }

                                    $safeUrl         = e($url);
                                    $safeTitle       = e($title);
                                    $safePosition    = e($position);
                                    $safePosWirePath = e($posWirePath);

                                    $html = <<<HTML
<div
  x-data="{
    pos: '',
    url: '',
    wirePath: '',
    updateFocal(e) {
      var rect = e.currentTarget.getBoundingClientRect();
      var x = Math.round((e.clientX - rect.left) / rect.width * 100);
      var y = Math.round((e.clientY - rect.top) / rect.height * 100);
      this.pos = x + '% ' + y + '%';
      \$wire.set(this.wirePath, this.pos);
    },
    kw(v) {
      return {'left':'0%','center':'50%','right':'100%','top':'0%','bottom':'100%'}[v] || v;
    },
    get dotX() { var p = this.pos.split(' '); return this.kw(p[0] || '50%'); },
    get dotY() { var p = this.pos.split(' '); return this.kw(p[1] || '30%'); }
  }"
  x-init="pos = \$el.dataset.pos; url = \$el.dataset.url; wirePath = \$el.dataset.wirePath"
  data-pos="{$safePosition}"
  data-url="{$safeUrl}"
  data-wire-path="{$safePosWirePath}"
  style="font-family:Manrope,system-ui,sans-serif;max-width:390px;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px -8px rgba(0,0,0,.15);border:1px solid #e5e7eb;"
>
  <!-- Фото: фиксированная высота 220px, кликается для выбора фокуса -->
  <div
    style="position:relative;width:100%;height:220px;overflow:hidden;cursor:crosshair;background:#f3f4f6;"
    @click="updateFocal(\$event)"
  >
    <img
      :src="url"
      alt=""
      :style="'width:100%;height:100%;object-fit:cover;object-position:' + pos"
    >
    <!-- Счётчик -->
    <div style="position:absolute;top:0.65rem;right:0.65rem;background:rgba(0,0,0,.45);color:#fff;font-size:0.7rem;font-weight:700;padding:0.2rem 0.65rem;border-radius:2rem;pointer-events:none;backdrop-filter:blur(6px);">01 / 01</div>
    <!-- Фокус-точка -->
    <div
      :style="'position:absolute;width:20px;height:20px;border-radius:50%;background:rgba(251,146,60,.95);border:2.5px solid #fff;box-shadow:0 2px 10px rgba(0,0,0,.6);transform:translate(-50%,-50%);pointer-events:none;z-index:10;left:' + dotX + ';top:' + dotY"
    ></div>
  </div>
  <!-- Текст: нормальный поток, без наложения -->
  <div style="padding:1rem 1.1rem 1.15rem;background:#fff;border-top:1px solid #e5e7eb;">
    <div style="font-size:1.1rem;font-weight:700;line-height:1.2;margin-bottom:0.4rem;color:#111827;">{$safeTitle}</div>
    <div style="font-size:0.875rem;line-height:1.6;color:#6b7280;">{$bodyFull}</div>
  </div>
  <p style="font-size:0.7rem;color:#9ca3af;margin:0;padding:0.35rem 1.1rem 0.5rem;background:#fff;border-top:1px solid #f3f4f6;">
    Фокус фото: <span x-text="pos" style="font-weight:600;color:#374151;"></span> — кликните на фото чтобы изменить
  </p>
</div>
HTML;

                                    return new HtmlString($html);
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
