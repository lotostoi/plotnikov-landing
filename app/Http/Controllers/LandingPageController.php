<?php

namespace App\Http\Controllers;

use App\Http\Concerns\RecordsPageView;
use App\Models\Article;
use App\Models\LandingBlock;
use App\Models\LandingPageContent;
use Database\Seeders\LandingBlocksSeeder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class LandingPageController extends Controller
{
    use RecordsPageView;
    public function __invoke(): View
    {
        $content = LandingPageContent::query()->first();

        if (! $content) {
            $content = LandingPageContent::query()->create($this->defaults());
        }

        $this->recordPageView('/');

        $images = [
            'hero'      => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7896_resized-nd2q5Sfs8MaKUDmtG8jYjZkb33cvj6.jpeg',
            'about'     => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7891_resized-VcwCPl7QQgWdCieGIyVbOxHgaXxQc6.jpeg',
            'education' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7906_resized-HaErVaZcvFJVFnHdfUL8pDRBTSodQq.jpeg',
            'contacts'  => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7900_resized-4RkFl3kS879RMqqDHNSTMuqrYSE6C9.jpeg',
        ];

        if (! LandingBlock::query()->exists()) {
            (new LandingBlocksSeeder)->run();
        }

        $visibleBlocks = LandingBlock::query()->visible()->ordered()->get()->groupBy('section_code');

        $headerBlocks = $visibleBlocks->get('header', collect());
        $heroBlocks = $visibleBlocks->get('hero', collect());
        $aboutBlocks = $visibleBlocks->get('about', collect());
        $serviceBlocks  = $visibleBlocks->get('services', collect());
        $pricingBlocks  = $visibleBlocks->get('pricing', collect());
        $educationBlocks = $visibleBlocks->get('education', collect());
        $reviewBlocks = $visibleBlocks->get('reviews', collect());
        $blogBlocks = $visibleBlocks->get('blog', collect());
        $faqBlocks = $visibleBlocks->get('faq', collect());
        $contactBlocks = $visibleBlocks->get('contacts', collect());
        $footerBlocks = $visibleBlocks->get('footer', collect());

        $headerBrand = $this->findByKey($headerBlocks, 'brand');
        $headerCta = $this->findByKey($headerBlocks, 'cta');
        $heroHeading = $this->findByKey($heroBlocks, 'heading');
        $heroPrimaryCta = $this->findByKey($heroBlocks, 'cta_primary');
        $heroSecondaryCta = $this->findByKey($heroBlocks, 'cta_secondary');
        $heroFormat = $this->findByKey($heroBlocks, 'format_badge');
        $aboutHeading = $this->findByKey($aboutBlocks, 'heading');
        $serviceHeading = $this->findByKey($serviceBlocks, 'heading');
        $educationHeading = $this->findByKey($educationBlocks, 'heading');
        $reviewsHeading = $this->findByKey($reviewBlocks, 'heading');
        $blogHeading = $this->findByKey($blogBlocks, 'heading');
        $blogAllCta = $this->findByKey($blogBlocks, 'cta_all');
        $faqHeading = $this->findByKey($faqBlocks, 'heading');
        $contactsHeading = $this->findByKey($contactBlocks, 'heading');
        $contactsFreeCall = $this->findByKey($contactBlocks, 'free_call');
        $contactsTelegram = $this->findByKey($contactBlocks, 'cta_telegram');
        $contactsWhatsapp = $this->findByKey($contactBlocks, 'cta_whatsapp');
        $contactsMax            = $this->findByKey($contactBlocks, 'cta_max');
        $contactsTelegramChannel = $this->findByKey($contactBlocks, 'telegram_channel');
        $contactsNickname = $this->findByKey($contactBlocks, 'nickname');
        $contactsPhone    = $this->findByKey($contactBlocks, 'phone');
        $contactsLocation = $this->findByKey($contactBlocks, 'location');
        $footerBrand = $this->findByKey($footerBlocks, 'brand');
        $footerCopyright = $this->findByKey($footerBlocks, 'copyright');

        // Переопределяем фото секций загруженными файлами (если они есть в heading.button_url)
        $resolvePhoto = static function (?string $raw): ?string {
            if (empty($raw)) {
                return null;
            }
            return str_starts_with($raw, 'http') ? $raw : asset('storage/' . $raw);
        };
        if ($uploaded = $resolvePhoto($heroHeading?->button_url)) {
            $images['hero'] = $uploaded;
        }
        if ($uploaded = $resolvePhoto($educationHeading?->button_url)) {
            $images['education'] = $uploaded;
        }
        if ($uploaded = $resolvePhoto($contactsHeading?->button_url)) {
            $images['contacts'] = $uploaded;
        }

        $navItems = $headerBlocks
            ->where('block_type', 'nav_item')
            ->map(fn (LandingBlock $block): array => [
                'href' => $block->button_url ?: '#',
                'label' => $block->label ?: ($block->title ?: 'Ссылка'),
            ])
            ->values()
            ->all();

        $heroStats = $heroBlocks
            ->where('block_type', 'stat')
            ->map(fn (LandingBlock $block): array => [
                'value' => $block->title ?: '',
                'label' => $block->subtitle ?: '',
            ])
            ->values()
            ->all();

        $aboutParagraphs = $aboutBlocks
            ->where('block_type', 'paragraph')
            ->pluck('body')
            ->filter()
            ->values()
            ->all();

        $aboutValues = $aboutBlocks
            ->where('block_type', 'card')
            ->map(fn (LandingBlock $block): array => [
                'icon' => $block->label ?: 'sparkles',
                'title' => $block->title ?: '',
                'description' => $block->body ?: '',
            ])
            ->values()
            ->all();

        $aboutSlides = $aboutBlocks
            ->where('block_type', 'about_slide')
            ->map(function (LandingBlock $block) use ($images): array {
                $raw   = $block->button_url ?: null;
                $photo = $raw
                    ? (str_starts_with($raw, 'http') ? $raw : asset('storage/' . $raw))
                    : $images['about'];

                $rawMobile       = $block->meta['photo_mobile'] ?? null;
                $photoMobile     = $rawMobile
                    ? (str_starts_with($rawMobile, 'http') ? $rawMobile : asset('storage/' . $rawMobile))
                    : $photo;

                return [
                    'icon'                  => $block->label ?: 'user',
                    'title'                 => $block->title ?: '',
                    'body'                  => $block->body ?: '',
                    'photo'                 => $photo,
                    'photo_mobile'          => $photoMobile,
                    'photo_mobile_position' => $block->meta['photo_mobile_position'] ?? 'center top',
                ];
            })
            ->values()
            ->all();

        $serviceIssues = $serviceBlocks
            ->filter(fn (LandingBlock $block): bool => $block->block_type === 'card' && str_starts_with($block->block_key, 'issue_'))
            ->map(fn (LandingBlock $block): array => [
                'icon'        => $block->label ?: 'sparkles',
                'accent'      => $block->badge ?: 'amber',
                'title'       => $block->title ?: '',
                'description' => $block->body ?: '',
            ])
            ->values()
            ->all();

        $servicePricing = $serviceBlocks
            ->where('block_type', 'price')
            ->keyBy('block_key');

        $serviceFormats = $serviceBlocks
            ->where('block_type', 'format')
            ->map(fn (LandingBlock $block): array => [
                'icon' => $block->label ?: 'sparkles',
                'title' => $block->title ?: '',
                'description' => $block->body ?: '',
            ])
            ->values()
            ->all();
        if ($serviceFormats === []) {
            $serviceFormats = [
                ['icon' => 'video', 'title' => 'Онлайн', 'description' => 'Удобно из любой точки мира'],
                ['icon' => 'map-pin', 'title' => 'Очно', 'description' => $content->location_text ?: 'Владивосток, Артём'],
                ['icon' => 'clock', 'title' => '55 минут', 'description' => 'Продолжительность встречи'],
            ];
        }

        $educationItems = $educationBlocks
            ->filter(fn (LandingBlock $block): bool => $block->block_type === 'card' && str_starts_with($block->block_key, 'edu_') && !str_contains($block->block_key, '_cert_'))
            ->map(function (LandingBlock $block) use ($educationBlocks): array {
                $certPrefix = $block->block_key . '_cert_';
                $certs = $educationBlocks
                    ->filter(fn (LandingBlock $b): bool => str_starts_with($b->block_key, $certPrefix) && !empty($b->button_url))
                    ->map(function (LandingBlock $b): string {
                        $p = $b->button_url;
                        return str_starts_with($p, 'http') ? $p : asset('storage/' . $p);
                    })
                    ->values()
                    ->all();

                return [
                    'icon'        => $block->label ?: 'graduation-cap',
                    'accent'      => $block->button_text ?: 'amber',
                    'title'       => $block->title ?: '',
                    'institution' => $block->subtitle ?: '',
                    'status'      => $block->badge ?: '',
                    'certs'       => $certs,
                ];
            })
            ->values()
            ->all();

        $experienceItems = $educationBlocks
            ->where('block_type', 'stat')
            ->map(fn (LandingBlock $block): array => [
                'icon' => $block->label ?: 'clock',
                'value' => $block->title ?: '',
                'label' => $block->subtitle ?: '',
                'description' => $block->body ?: '',
            ])
            ->values()
            ->all();

        $approaches = $educationBlocks
            ->where('block_type', 'chip')
            ->pluck('title')
            ->filter()
            ->values()
            ->all();

        $reviews = $reviewBlocks
            ->where('block_type', 'review')
            ->map(fn (LandingBlock $block): array => [
                'text' => $block->body ?: '',
                'author' => $block->title ?: '',
                'detail' => $block->subtitle ?: '',
            ])
            ->values()
            ->all();

        $articles = Schema::hasTable('articles')
            ? Article::published()
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->orderByDesc('published_at')
                ->limit(3)
                ->get()
            : collect();

        $faqs = $faqBlocks
            ->where('block_type', 'faq')
            ->map(fn (LandingBlock $block): array => [
                'question' => $block->title ?: '',
                'answer' => $block->body ?: '',
            ])
            ->values()
            ->all();

        $sectionVisibility = [
            'header' => $content->show_header,
            'hero' => $content->show_hero,
            'about' => $content->show_about,
            'services' => $content->show_services,
            'pricing' => $content->show_pricing ?? true,
            'education' => $content->show_education,
            'reviews' => $content->show_reviews,
            'blog' => $content->show_blog,
            'faq' => $content->show_faq,
            'contacts' => $content->show_contacts,
            'footer' => $content->show_footer,
        ];

        $navVisibilityMap = [
            '#about' => $sectionVisibility['about'],
            '#services' => $sectionVisibility['services'],
            '#pricing' => $sectionVisibility['pricing'],
            '#education' => $sectionVisibility['education'],
            '#reviews' => $sectionVisibility['reviews'],
            '#blog' => $sectionVisibility['blog'],
            '#faq' => $sectionVisibility['faq'],
            '#contacts' => $sectionVisibility['contacts'],
        ];
        $navItems = array_values(array_filter(
            $navItems,
            fn (array $item): bool => $navVisibilityMap[$item['href']] ?? true
        ));

        return view('welcome', [
            'content' => $content,
            'images' => $images,
            'siteUrl' => rtrim($content->canonical_url ?: config('app.url') ?: url('/'), '/'),
            'canonicalUrl' => rtrim($content->canonical_url ?: url('/'), '/'),
            'ogImage' => $content->ogImageResolvedUrl($images['hero']),
            'favicon' => $content->faviconResolvedUrl(),
            'appleTouchIcon' => $content->appleTouchIconResolvedUrl(),
            'h1' => $content->h1_text ?: 'Здравствуйте, я Александр',

            'sectionVisibility' => $sectionVisibility,
            'headerBrand' => [
                'title' => $headerBrand?->title ?: 'Александр',
                'subtitle' => $headerBrand?->subtitle ?: 'психолог',
            ],
            'headerCta' => [
                'text' => $headerCta?->button_text ?: 'Записаться',
                'url' => $headerCta?->button_url ?: '#contacts',
            ],
            'navItems' => $navItems,

            'heroHeading' => [
                'badge' => $heroHeading?->badge ?: $content->hero_badge,
                'title' => $heroHeading?->title ?: 'Здравствуйте,',
                'subtitle' => $heroHeading?->subtitle ?: 'я Александр',
                'description' => $heroHeading?->body ?: $content->hero_description,
            ],
            'heroPrimaryCta' => [
                'text' => $heroPrimaryCta?->button_text ?: 'Бесплатный созвон 15 мин',
                'url' => $heroPrimaryCta?->button_url ?: '#contacts',
            ],
            'heroSecondaryCta' => [
                'text' => $heroSecondaryCta?->button_text ?: 'Узнать больше',
                'url' => $heroSecondaryCta?->button_url ?: '#about',
            ],
            'heroFormat' => [
                'label' => $heroFormat?->label ?: 'Формат',
                'text' => $heroFormat?->title ?: 'Онлайн по всему миру',
            ],
            'heroStats' => $heroStats,

            'aboutHeading' => [
                'badge' => $aboutHeading?->badge ?: 'Обо мне',
                'title' => $aboutHeading?->title ?: 'Немного',
                'subtitle' => $aboutHeading?->subtitle ?: 'обо мне',
            ],
            'aboutParagraphs' => $aboutParagraphs,
            'aboutValues' => $aboutValues,
            'aboutSlides' => $aboutSlides,

            'serviceHeading' => [
                'badge' => $serviceHeading?->badge ?: 'Услуги',
                'title' => $serviceHeading?->title ?: 'С чем я',
                'subtitle' => $serviceHeading?->subtitle ?: 'работаю',
                'description' => $serviceHeading?->body ?: 'Подходы: Гештальт, КПТ, трансактный анализ, процессуальная психология',
            ],
            'serviceIssues' => $serviceIssues,
            'serviceFormats' => $serviceFormats,
            'serviceCardCols' => $serviceHeading?->meta['card_cols'] ?? '3',
            'serviceCardVariant' => $serviceHeading?->meta['card_variant'] ?? 'default',

            'pricingHeading' => [
                'badge'    => $pricingBlocks->where('block_key', 'heading')->first()?->badge ?: 'Консультации',
                'title'    => $pricingBlocks->where('block_key', 'heading')->first()?->title ?: 'Форматы',
                'subtitle' => $pricingBlocks->where('block_key', 'heading')->first()?->subtitle ?: 'и стоимость',
            ],
            'pricingCardCols'    => $pricingBlocks->where('block_key', 'heading')->first()?->meta['card_cols'] ?? '2',
            'pricingCardVariant' => $pricingBlocks->where('block_key', 'heading')->first()?->meta['card_variant'] ?? 'default',
            'pricingPromoCols'   => $pricingBlocks->where('block_key', 'heading')->first()?->meta['promo_cols'] ?? '3',
            'pricingConsults' => $pricingBlocks
                ->where('block_type', 'consult')
                ->sortBy('sort_order')
                ->values()
                ->map(function (LandingBlock $b): array {
                    $meta = $b->meta ?? [];

                    return [
                        'key'            => $b->block_key,
                        'icon'           => $b->label ?: 'video',
                        'title'          => $b->title ?: '',
                        'subtitle'       => $b->subtitle ?: '',
                        'price'          => $b->badge ?: '',
                        'body'           => $b->body ?: '',
                        'cta_text'       => $b->button_text ?: 'Записаться',
                        'cta_url'        => $b->button_url ?: '#contacts',
                        'desktop_span'   => ($meta['desktop_span'] ?? 'half') === 'full' ? 'full' : 'half',
                        'subtitle_icon'  => $meta['subtitle_icon'] ?? ($b->block_key === 'offline' ? 'map-pin' : 'globe'),
                    ];
                })
                ->all(),
            'pricingPromos' => $pricingBlocks
                ->where('block_type', 'promo')
                ->map(fn (LandingBlock $b): array => [
                    'badge'        => $b->badge ?: 'Акция',
                    'title'        => $b->title ?: '',
                    'price'        => $b->subtitle ?: '',
                    'body'         => $b->body ?: '',
                    'terms'        => $b->button_text ?: '',
                    'desktop_span' => $b->meta['desktop_span'] ?? 'half',
                ])
                ->values()
                ->all(),

            'educationHeading' => [
                'badge' => $educationHeading?->badge ?: 'Образование',
                'title' => $educationHeading?->title ?: 'Опыт и',
                'subtitle' => $educationHeading?->subtitle ?: 'образование',
            ],
            'educationItems' => $educationItems,
            'experienceItems' => $experienceItems,
            'approaches' => $approaches,

            'reviewsHeading' => [
                'badge' => $reviewsHeading?->badge ?: 'Отзывы',
                'title' => $reviewsHeading?->title ?: 'Что говорят',
                'subtitle' => $reviewsHeading?->subtitle ?: 'клиенты',
                'description' => $reviewsHeading?->body ?: 'Отзывы опубликованы с разрешения клиентов, имена изменены для сохранения конфиденциальности',
            ],
            'reviews' => $reviews,

            'blogHeading' => [
                'badge' => $blogHeading?->badge ?: 'Блог',
                'title' => $blogHeading?->title ?: 'Статьи и',
                'subtitle' => $blogHeading?->subtitle ?: 'заметки',
            ],
            'blogAllCta' => [
                'text' => $blogAllCta?->button_text ?: 'Все статьи',
                'url' => route('blog.index'),
            ],
            'articles' => $articles,

            'faqHeading' => [
                'badge' => $faqHeading?->badge ?: 'FAQ',
                'title' => $faqHeading?->title ?: 'Частые',
                'subtitle' => $faqHeading?->subtitle ?: 'вопросы',
                'description' => $faqHeading?->body ?: 'Ответы на вопросы, которые чаще всего задают перед началом терапии',
            ],
            'faqs' => $faqs,

            'contactsHeading' => [
                'badge' => $contactsHeading?->badge ?: 'Контакты',
                'title' => $contactsHeading?->title ?: 'Запишитесь на',
                'subtitle' => $contactsHeading?->subtitle ?: 'консультацию',
                'description' => $contactsHeading?->body ?: 'Для записи или вопросов пишите в любой удобный мессенджер. Отвечаю в течение дня.',
            ],
            'contactsFreeCall' => [
                'title' => $contactsFreeCall?->title ?: 'Бесплатный созвон',
                'subtitle' => $contactsFreeCall?->subtitle ?: '15 минут для знакомства',
                'description' => $contactsFreeCall?->body ?: 'Можно предварительно созвониться — просто познакомиться и понять, подходим ли мы друг другу. Это бесплатно и ни к чему не обязывает.',
            ],
            'contactsTelegram' => [
                'text' => $this->telegramCtaButtonLabel($contactsTelegram?->button_text),
                'url'  => $contactsTelegram?->button_url ?: $content->telegram_url,
                'icon' => $contactsTelegram?->label ?: 'send',
            ],
            'contactsTelegramChannel' => [
                'title'       => $contactsTelegramChannel?->title ?: 'Читайте обо мне в Telegram',
                'subtitle'    => $contactsTelegramChannel?->subtitle ?: 'Статьи, заметки и мысли о терапии и отношениях',
                'button_text' => $contactsTelegramChannel?->button_text ?: 'Открыть канал',
                'url'         => $contactsTelegramChannel?->button_url ?: 'https://t.me/plotnikov_aleksander',
                'icon'        => $contactsTelegramChannel?->label ?: 'newspaper',
                'visible'     => $contactsTelegramChannel?->is_visible ?? true,
            ],
            'contactsWhatsapp' => [
                'text' => $contactsWhatsapp?->button_text ?: 'WhatsApp',
                'url' => $contactsWhatsapp?->button_url ?: $content->whatsapp_url,
                'icon' => $contactsWhatsapp?->label ?: 'message-circle',
            ],
            'contactsMax' => [
                'text' => $contactsMax?->button_text ?: 'Max',
                'url'  => $contactsMax?->button_url ?: 'https://max.ru/u/f9LHodD0cOIZh45J-Dg2owlXzPWe-IUg2R7DDGo-yx1QdDAdLYK1SUWEHxM',
                'icon' => $contactsMax?->label ?: 'message-square',
            ],
            'contactsNickname' => [
                'label' => $contactsNickname?->label ?: 'Ник в Telegram',
                'value' => $contactsNickname?->title ?: '@AlexanderP_V',
            ],
            'contactsPhone' => [
                'number' => $contactsPhone?->title ?: '+7 924 252-17-56',
                'url'    => $contactsPhone?->button_url ?: 'tel:+79242521756',
            ],
            'footerSocial' => [
                'telegram_personal' => $contactsTelegram?->button_url ?: $content->telegram_url,
                'telegram_channel'  => $contactsTelegramChannel?->button_url ?: 'https://t.me/plotnikov_aleksander',
                'whatsapp'          => $contactsWhatsapp?->button_url ?: $content->whatsapp_url,
                'max'               => $contactsMax?->button_url ?: 'https://max.ru/u/f9LHodD0cOIZh45J-Dg2owlXzPWe-IUg2R7DDGo-yx1QdDAdLYK1SUWEHxM',
            ],
            'schemaSocialUrls' => array_values(array_unique(array_filter([
                $contactsTelegram?->button_url ?: $content->telegram_url,
                $contactsTelegramChannel?->button_url ?: 'https://t.me/plotnikov_aleksander',
                $contactsWhatsapp?->button_url ?: $content->whatsapp_url,
                $contactsMax?->button_url ?: 'https://max.ru/u/f9LHodD0cOIZh45J-Dg2owlXzPWe-IUg2R7DDGo-yx1QdDAdLYK1SUWEHxM',
                $content->vk_url,
                $content->youtube_url,
                $content->instagram_url,
            ]))),
            'contactsLocation' => [
                'title' => $contactsLocation?->title ?: 'Очный приём',
                'subtitle' => $contactsLocation?->subtitle ?: $content->location_text,
                'icon' => $contactsLocation?->label ?: 'map-pin',
            ],

            'footerBrand' => [
                'title' => $footerBrand?->title ?: 'Александр',
                'subtitle' => $footerBrand?->subtitle ?: 'психолог',
                'description' => $footerBrand?->body ?: 'Гештальт-терапевт. Помогаю находить опору и контакт с собой через доверие и живое человеческое присутствие.',
            ],
            'footerCopyright' => [
                'text' => $footerCopyright?->body ?: 'Сделано с любовью во Владивостоке',
            ],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function defaults(): array
    {
        return [
            'hero_badge' => 'Гештальт-терапевт',
            'hero_title' => 'Здравствуйте, я Александр',
            'hero_description' => 'Уже 15 лет моя жизнь связана с психологией. Помогаю людям находить опору и контакт с собой через доверие и живое человеческое присутствие.',
            'contact_handle' => '@AlexanderP_V',
            'telegram_url' => 'https://t.me/AlexanderP_V',
            'whatsapp_url' => 'https://wa.me/79242521756',
            'location_text' => 'Владивосток, Артём',
            'seo_title' => 'Александр Плотников — психолог, гештальт-терапевт | Владивосток и онлайн',
            'seo_description' => 'Гештальт-терапевт Александр Плотников — онлайн-консультации по всему миру, очно во Владивостоке и Артёме. 15 лет практики. Первый созвон бесплатно.',
            'seo_keywords' => 'психолог Владивосток, гештальт-терапевт, психолог онлайн, психолог Артём, консультация психолога, Александр Плотников психолог, гештальт-терапия Владивосток, психотерапия онлайн',
            'canonical_url' => 'https://plotnikov-al-psy.online',
            'robots' => 'index,follow',
            'h1_text' => null,
            'person_name' => 'Александр',
            'person_full_name' => 'Александр Плотников',
            'person_job_title' => 'Психолог, гештальт-терапевт',
            'person_bio' => 'Гештальт-терапевт Александр Плотников. Помогаю находить опору и контакт с собой через доверие и живое человеческое присутствие. 15+ лет в психологии, 12+ лет личной терапии, 10+ лет групповой работы. Работаю онлайн по всему миру и очно во Владивостоке и Артёме.',
            'person_image_url' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7896_resized-nd2q5Sfs8MaKUDmtG8jYjZkb33cvj6.jpeg',
            'person_phone' => '+79242521756',
            'address_locality' => 'Владивосток',
            'address_region' => 'Приморский край',
            'address_country' => 'RU',
            'address_postal' => '690091',
            'geo_lat' => 43.1155,
            'geo_lng' => 131.8855,
            'opening_hours' => 'Mo-Su 09:00-21:00',
            'price_range' => '₽₽',
            'price_regular' => 3500,
            'price_promo' => 2000,
            'price_currency' => 'RUB',
            'aggregate_rating_value' => 5.0,
            'aggregate_rating_count' => 47,
            'show_header' => true,
            'show_hero' => true,
            'show_about' => true,
            'show_services' => true,
            'show_education' => true,
            'show_reviews' => true,
            'show_blog' => true,
            'show_faq' => true,
            'show_contacts' => true,
            'show_footer' => true,
            'default_theme' => 'warm',
        ];
    }

    /**
     * Возвращает URL фотографий секций.
     * Если изображения уже скачаны командой app:download-vercel-images — использует локальные.
     *
    /**
     * Убирает устаревший префикс «Написать в …» из текста кнопки (значение могло остаться в БД).
     */
    private function telegramCtaButtonLabel(?string $buttonText): string
    {
        $raw = trim((string) $buttonText);
        if ($raw === '') {
            return 'Telegram';
        }

        $stripped = preg_replace('/^написать\s+в\s+/iu', '', $raw);

        return trim((string) $stripped) !== '' ? trim((string) $stripped) : 'Telegram';
    }

    private function findByKey(Collection $blocks, string $key): ?LandingBlock
    {
        /** @var LandingBlock|null $block */
        $block = $blocks->firstWhere('block_key', $key);

        return $block;
    }

}

