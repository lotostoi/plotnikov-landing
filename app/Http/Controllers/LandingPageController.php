<?php

namespace App\Http\Controllers;

use App\Models\LandingBlock;
use App\Models\LandingPageContent;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class LandingPageController extends Controller
{
    public function __invoke(): View
    {
        $content = LandingPageContent::query()->first();

        if (! $content) {
            $content = LandingPageContent::query()->create($this->defaults());
        }

        $images = [
            'hero' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7896_resized-nd2q5Sfs8MaKUDmtG8jYjZkb33cvj6.jpeg',
            'about' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7891_resized-VcwCPl7QQgWdCieGIyVbOxHgaXxQc6.jpeg',
            'education' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7906_resized-HaErVaZcvFJVFnHdfUL8pDRBTSodQq.jpeg',
            'contacts' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7900_resized-4RkFl3kS879RMqqDHNSTMuqrYSE6C9.jpeg',
        ];

        $visibleBlocks = LandingBlock::query()->visible()->ordered()->get()->groupBy('section_code');

        $headerBlocks = $visibleBlocks->get('header', collect());
        $heroBlocks = $visibleBlocks->get('hero', collect());
        $aboutBlocks = $visibleBlocks->get('about', collect());
        $serviceBlocks = $visibleBlocks->get('services', collect());
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
        $contactsNickname = $this->findByKey($contactBlocks, 'nickname');
        $contactsLocation = $this->findByKey($contactBlocks, 'location');
        $footerBrand = $this->findByKey($footerBlocks, 'brand');
        $footerCopyright = $this->findByKey($footerBlocks, 'copyright');

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

        $serviceIssues = $serviceBlocks
            ->filter(fn (LandingBlock $block): bool => $block->block_type === 'card' && str_starts_with($block->block_key, 'issue_'))
            ->map(fn (LandingBlock $block): array => [
                'icon' => $block->label ?: 'sparkles',
                'title' => $block->title ?: '',
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
            ->filter(fn (LandingBlock $block): bool => $block->block_type === 'card' && str_starts_with($block->block_key, 'edu_'))
            ->map(fn (LandingBlock $block): array => [
                'icon' => $block->label ?: 'graduation-cap',
                'title' => $block->title ?: '',
                'institution' => $block->subtitle ?: '',
                'status' => $block->badge ?: '',
            ])
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

        $articles = $blogBlocks
            ->where('block_type', 'article')
            ->map(function (LandingBlock $block): array {
                $meta = is_array($block->meta) ? $block->meta : [];

                return [
                    'title' => $block->title ?: '',
                    'description' => $block->body ?: '',
                    'category' => $block->badge ?: '',
                    'date' => (string) ($meta['date'] ?? ''),
                    'readTime' => (string) ($meta['readTime'] ?? ''),
                ];
            })
            ->values()
            ->all();

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

            'serviceHeading' => [
                'badge' => $serviceHeading?->badge ?: 'Услуги',
                'title' => $serviceHeading?->title ?: 'С чем я',
                'subtitle' => $serviceHeading?->subtitle ?: 'работаю',
                'description' => $serviceHeading?->body ?: 'Подходы: Гештальт, КПТ, трансактный анализ, процессуальная психология',
            ],
            'serviceIssues' => $serviceIssues,
            'serviceFormats' => $serviceFormats,
            'servicePricing' => [
                'regular' => $servicePricing->get('price_regular'),
                'promo' => $servicePricing->get('price_promo'),
            ],

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
                'url' => $blogAllCta?->button_url ?: '#',
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
                'text' => $contactsTelegram?->button_text ?: 'Telegram',
                'url' => $contactsTelegram?->button_url ?: $content->telegram_url,
                'icon' => $contactsTelegram?->label ?: 'send',
            ],
            'contactsWhatsapp' => [
                'text' => $contactsWhatsapp?->button_text ?: 'WhatsApp',
                'url' => $contactsWhatsapp?->button_url ?: $content->whatsapp_url,
                'icon' => $contactsWhatsapp?->label ?: 'message-circle',
            ],
            'contactsNickname' => [
                'label' => $contactsNickname?->label ?: 'Никнейм',
                'value' => $contactsNickname?->title ?: $content->contact_handle,
            ],
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
            'whatsapp_url' => 'https://wa.me/message/AlexanderP_V',
            'location_text' => 'Владивосток, Артём',
            'seo_title' => 'Александр Психолог | Гештальт-терапия онлайн и очно',
            'seo_description' => 'Психолог, гештальт-терапевт. Помогаю найти опору и контакт с собой. Работаю с тревожностью, отношениями, кризисами и самоценностью. Онлайн и очно во Владивостоке.',
            'seo_keywords' => 'психолог, гештальт-терапия, психотерапия, консультация психолога, Владивосток, онлайн психолог, психолог Владивосток, психолог Артём',
            'canonical_url' => 'https://plotnikov-al-psy.online',
            'robots' => 'index,follow',
            'h1_text' => null,
            'person_name' => 'Александр',
            'person_full_name' => 'Александр П Психолог',
            'person_job_title' => 'Психолог, гештальт-терапевт',
            'person_bio' => 'Гештальт-терапевт. Помогаю находить опору и контакт с собой через доверие и живое человеческое присутствие. 15+ лет в психологии, 12+ лет личной терапии, 10+ лет групповой работы.',
            'person_image_url' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7896_resized-nd2q5Sfs8MaKUDmtG8jYjZkb33cvj6.jpeg',
            'address_locality' => 'Владивосток',
            'address_region' => 'Приморский край',
            'address_country' => 'RU',
            'opening_hours' => 'Mo-Fr 09:00-21:00',
            'price_range' => '₽₽',
            'price_regular' => 3500,
            'price_promo' => 2000,
            'price_currency' => 'RUB',
            'aggregate_rating_value' => 5.0,
            'aggregate_rating_count' => 23,
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
        ];
    }

    private function findByKey(Collection $blocks, string $key): ?LandingBlock
    {
        /** @var LandingBlock|null $block */
        $block = $blocks->firstWhere('block_key', $key);

        return $block;
    }
}

