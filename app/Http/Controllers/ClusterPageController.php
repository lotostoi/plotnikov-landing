<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\LandingBlock;
use App\Models\LandingPageContent;
use App\Models\LandingPageViewLog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ClusterPageController extends Controller
{
    /**
     * Конфигурация кластерных посадочных страниц.
     * slug → SEO-данные и контент.
     *
     * @return array<string, array<string, string>>
     */
    private function clusters(): array
    {
        return [
            'psiholog-online' => [
                'seo_title'       => 'Психолог онлайн — Александр Плотников | Консультации по всему миру',
                'seo_description' => 'Психологические консультации онлайн с Александром Плотниковым. Гештальт-терапевт с 15-летним опытом. Работаю по всему миру через Zoom и мессенджеры. Первый созвон бесплатно.',
                'seo_keywords'    => 'психолог онлайн, консультация психолога онлайн, онлайн психотерапия, гештальт-терапевт онлайн, психолог по Zoom',
                'canonical_path'  => '/psiholog-online',
                'h1'              => 'Психолог онлайн',
                'h1_sub'          => 'из любой точки мира',
                'badge'           => 'Онлайн-консультации',
                'description'     => 'Работаю с людьми по всему миру через Zoom, Telegram и мессенджеры. Расписание строится удобно для вашего часового пояса — без привязки к географии.',
                'benefits'        => [
                    ['icon' => 'globe',  'text' => 'Любая страна и часовой пояс'],
                    ['icon' => 'video',  'text' => 'Zoom или мессенджеры — на ваш выбор'],
                    ['icon' => 'shield', 'text' => 'Полная конфиденциальность'],
                    ['icon' => 'clock',  'text' => '55 минут — стандартная сессия'],
                ],
                'stats' => [
                    ['value' => '15+', 'label' => 'лет практики'],
                    ['value' => '15',  'label' => 'мин — бесплатный созвон'],
                    ['value' => '55',  'label' => 'мин / сессия'],
                ],
                'schema_type' => 'online',
            ],
            'geshtalt-terapevt' => [
                'seo_title'       => 'Гештальт-терапевт Александр Плотников | Владивосток и онлайн',
                'seo_description' => 'Гештальт-терапия с Александром Плотниковым — 15 лет практики, 10+ лет групповой работы. Работаю с тревогой, отношениями, кризисами идентичности. Онлайн и очно во Владивостоке.',
                'seo_keywords'    => 'гештальт-терапевт, гештальт-терапия, гештальт-психолог, гештальт Владивосток, гештальт онлайн',
                'canonical_path'  => '/geshtalt-terapevt',
                'h1'              => 'Гештальт-терапевт',
                'h1_sub'          => 'Александр Плотников',
                'badge'           => 'Гештальт-терапия',
                'description'     => 'Гештальт-терапия помогает вернуть контакт с собой, разобраться в отношениях и найти опору в настоящем моменте. Работаю в гештальт-подходе 15+ лет — индивидуально и в группах.',
                'benefits'        => [
                    ['icon' => 'heart',   'text' => '15+ лет практики в гештальт-подходе'],
                    ['icon' => 'users',   'text' => '10+ лет ведения групповой терапии'],
                    ['icon' => 'award',   'text' => 'Супервизия и личная терапия'],
                    ['icon' => 'compass', 'text' => 'КПТ, трансактный анализ, процессуальная психология'],
                ],
                'stats' => [
                    ['value' => '15+', 'label' => 'лет практики'],
                    ['value' => '15',  'label' => 'мин — бесплатный созвон'],
                    ['value' => '55',  'label' => 'мин / сессия'],
                ],
                'schema_type' => 'gestalt',
            ],
            'psiholog-vladivostok' => [
                'seo_title'       => 'Психолог Владивосток — Александр Плотников | Очный и онлайн приём',
                'seo_description' => 'Психолог во Владивостоке Александр Плотников. 15 лет практики. Гештальт-терапия, КПТ, трансактный анализ. Очный приём во Владивостоке и онлайн. Первый созвон бесплатно.',
                'seo_keywords'    => 'психолог Владивосток, психолог во Владивостоке, консультация психолога Владивосток, психотерапия Владивосток, гештальт-терапевт Владивосток',
                'canonical_path'  => '/psiholog-vladivostok',
                'h1'              => 'Психолог во Владивостоке',
                'h1_sub'          => 'очный приём и онлайн',
                'badge'           => 'Владивосток',
                'description'     => 'Принимаю очно во Владивостоке и онлайн. Помогаю взрослым разобраться в отношениях, справиться с тревогой, найти направление и опору в жизни.',
                'benefits'        => [
                    ['icon' => 'map-pin', 'text' => 'Очный приём во Владивостоке'],
                    ['icon' => 'video',   'text' => 'Онлайн — из любого места'],
                    ['icon' => 'clock',   'text' => 'Пн–Вс 09:00–21:00'],
                    ['icon' => 'phone',   'text' => 'Первый созвон — бесплатно'],
                ],
                'stats' => [
                    ['value' => '15+', 'label' => 'лет практики'],
                    ['value' => '15',  'label' => 'мин — бесплатный созвон'],
                    ['value' => '55',  'label' => 'мин / сессия'],
                ],
                'schema_type' => 'local_vladivostok',
            ],
            'psiholog-artem' => [
                'seo_title'       => 'Психолог Артём — Александр Плотников | Очный приём и онлайн',
                'seo_description' => 'Психолог в Артёме Александр Плотников. Очный приём и онлайн. Гештальт-терапия, 15 лет практики. Работаю с тревогой, отношениями, самооценкой. Первый созвон бесплатно.',
                'seo_keywords'    => 'психолог Артём, психолог в Артёме, консультация психолога Артём, психотерапия Артём, психолог Приморский край',
                'canonical_path'  => '/psiholog-artem',
                'h1'              => 'Психолог в Артёме',
                'h1_sub'          => 'очный приём и онлайн',
                'badge'           => 'Артём',
                'description'     => 'Принимаю очно в Артёме и онлайн. Помогаю справиться с тревогой, кризисами и трудностями в отношениях. 15 лет практики, мягкий и бережный подход.',
                'benefits'        => [
                    ['icon' => 'map-pin', 'text' => 'Очный приём в Артёме'],
                    ['icon' => 'video',   'text' => 'Онлайн из любого места'],
                    ['icon' => 'clock',   'text' => 'Гибкое расписание 09:00–21:00'],
                    ['icon' => 'phone',   'text' => 'Первый созвон — бесплатно'],
                ],
                'stats' => [
                    ['value' => '15+', 'label' => 'лет практики'],
                    ['value' => '15',  'label' => 'мин — бесплатный созвон'],
                    ['value' => '55',  'label' => 'мин / сессия'],
                ],
                'schema_type' => 'local_artem',
            ],
        ];
    }

    public function show(string $slug): View
    {
        $clusters = $this->clusters();

        if (! isset($clusters[$slug])) {
            throw new NotFoundHttpException();
        }

        $cluster = $clusters[$slug];

        $content = Schema::hasTable('landing_page_contents')
            ? LandingPageContent::query()->first()
            : null;

        $canonicalBase = rtrim($content?->canonical_url ?: config('app.url') ?: url('/'), '/');
        $canonical     = $canonicalBase . $cluster['canonical_path'];

        $faqs = collect();
        $reviews = collect();
        $tgUrl  = 'https://t.me/AlexanderP_V';
        $waUrl  = 'https://wa.me/79242521756';
        $maxUrl = 'https://max.ru/u/f9LHodD0cOIZh45J-Dg2owlXzPWe-IUg2R7DDGo-yx1QdDAdLYK1SUWEHxM';
        $onlinePrice = null;

        if (Schema::hasTable('landing_blocks')) {
            $blocks = LandingBlock::query()->visible()->ordered()->get()->groupBy('section_code');

            $faqs = $blocks->get('faq', collect())
                ->where('block_type', 'faq')
                ->map(fn (LandingBlock $b): array => [
                    'question' => $b->title ?: '',
                    'answer'   => $b->body ?: '',
                ])
                ->values();

            $reviews = $blocks->get('reviews', collect())
                ->where('block_type', 'review')
                ->take(3)
                ->map(fn (LandingBlock $b): array => [
                    'text'   => $b->body ?: '',
                    'author' => $b->title ?: '',
                    'detail' => $b->subtitle ?: '',
                ])
                ->values();

            $contactBlocks = $blocks->get('contacts', collect());
            $tgBlock  = $contactBlocks->firstWhere('block_key', 'cta_telegram');
            $waBlock  = $contactBlocks->firstWhere('block_key', 'cta_whatsapp');
            $maxBlock = $contactBlocks->firstWhere('block_key', 'cta_max');

            $tgUrl  = $tgBlock?->button_url  ?: $content?->telegram_url  ?: $tgUrl;
            $waUrl  = $waBlock?->button_url  ?: $content?->whatsapp_url  ?: $waUrl;
            $maxUrl = $maxBlock?->button_url ?: $maxUrl;

            // Цена онлайн-консультации из блока pricing → online (хранится в поле badge)
            $onlineBlock = $blocks->get('pricing', collect())->firstWhere('block_key', 'online');
            $onlinePrice = $onlineBlock?->badge ?: null;
        }

        if ($content) {
            $this->recordView($content->id, $cluster['canonical_path']);
        }

        $heroImage = 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7896_resized-nd2q5Sfs8MaKUDmtG8jYjZkb33cvj6.jpeg';

        // Третий стат — цена онлайн-консультации из поля price_regular в админке
        $priceRegular = $content?->price_regular;
        $cluster['stats'][2] = $priceRegular
            ? ['value' => 'от ' . number_format((int) $priceRegular, 0, '.', ' ') . ' ₽', 'label' => 'онлайн-сессия']
            : ['value' => '55', 'label' => 'мин / сессия'];

        $personFullName = $content?->person_full_name ?: 'Александр Плотников';
        $personPhone    = $content?->person_phone;
        $addressLocality = $content?->address_locality ?: 'Владивосток';
        $geoLat = $content?->geo_lat ?: 43.1155;
        $geoLng = $content?->geo_lng ?: 131.8855;

        $schemaDescription = $cluster['seo_description'];
        $personId   = $canonicalBase . '#person';
        $businessId = $canonical . '#business';

        $schema = [
            '@context' => 'https://schema.org',
            '@graph'   => [
                [
                    '@type'       => 'Person',
                    '@id'         => $personId,
                    'name'        => $personFullName,
                    'jobTitle'    => 'Психолог, гештальт-терапевт',
                    'description' => $schemaDescription,
                    'url'         => $canonicalBase . '/',
                    'image'       => $heroImage,
                    'telephone'   => $personPhone,
                    'sameAs'      => array_values(array_filter([$tgUrl, $waUrl])),
                ],
                [
                    '@type'       => ['LocalBusiness', 'MedicalBusiness'],
                    '@id'         => $businessId,
                    'name'        => $personFullName . ' — ' . $cluster['h1'],
                    'description' => $schemaDescription,
                    'url'         => $canonical,
                    'image'       => $heroImage,
                    'telephone'   => $personPhone,
                    'priceRange'  => '₽₽',
                    'address'     => [
                        '@type'           => 'PostalAddress',
                        'addressLocality' => $addressLocality,
                        'addressRegion'   => 'Приморский край',
                        'addressCountry'  => 'RU',
                    ],
                    'geo' => [
                        '@type'     => 'GeoCoordinates',
                        'latitude'  => $geoLat,
                        'longitude' => $geoLng,
                    ],
                    'openingHours' => 'Mo-Su 09:00-21:00',
                    'founder'      => ['@id' => $personId],
                    'areaServed'   => [
                        ['@type' => 'City', 'name' => 'Владивосток'],
                        ['@type' => 'Place', 'name' => 'Онлайн (по всему миру)'],
                    ],
                ],
                [
                    '@type'       => 'WebPage',
                    'url'         => $canonical,
                    'name'        => $cluster['seo_title'],
                    'description' => $schemaDescription,
                    'inLanguage'  => 'ru-RU',
                    'isPartOf'    => ['@id' => $canonicalBase . '#website'],
                ],
            ],
        ];

        if ($faqs->isNotEmpty()) {
            $schema['@graph'][] = [
                '@type'      => 'FAQPage',
                'mainEntity' => $faqs->map(fn (array $faq): array => [
                    '@type'          => 'Question',
                    'name'           => $faq['question'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
                ])->all(),
            ];
        }

        return view('cluster.show', [
            'cluster'      => $cluster,
            'content'      => $content,
            'canonical'    => $canonical,
            'canonicalBase' => $canonicalBase,
            'heroImage'    => $heroImage,
            'faqs'         => $faqs,
            'reviews'      => $reviews,
            'tgUrl'        => $tgUrl,
            'waUrl'        => $waUrl,
            'maxUrl'       => $maxUrl,
            'schema'       => $schema,
            'personFullName' => $personFullName,
        ]);
    }

    /**
     * Отдаёт все зарегистрированные слаги (для sitemap).
     *
     * @return array<int, string>
     */
    public function slugs(): array
    {
        return array_keys($this->clusters());
    }

    private function recordView(int $contentId, string $page): void
    {
        try {
            DB::table('landing_page_contents')
                ->where('id', $contentId)
                ->update([
                    'landing_page_views_count' => DB::raw('landing_page_views_count + 1'),
                    'landing_page_last_view_at' => now(),
                ]);

            if (! Schema::hasTable('landing_page_view_logs')) {
                return;
            }

            $ua = (string) (request()->userAgent() ?? '');

            $data = [
                'landing_page_content_id' => $contentId,
                'viewed_at'               => now(),
                'ip'                      => request()->ip(),
                'user_agent'              => $ua ?: null,
                'device'                  => LandingPageViewLog::detectDevice($ua),
                'referrer'                => request()->header('referer') ?: null,
                'utm_source'              => request()->query('utm_source') ?: null,
                'utm_medium'              => request()->query('utm_medium') ?: null,
                'utm_campaign'            => request()->query('utm_campaign') ?: null,
                'utm_term'                => request()->query('utm_term') ?: null,
                'utm_content'             => request()->query('utm_content') ?: null,
            ];

            if (Schema::hasColumn('landing_page_view_logs', 'page')) {
                $data['page'] = $page;
            }

            LandingPageViewLog::query()->create($data);
        } catch (Throwable) {
            // Не роняем страницу при ошибках БД.
        }
    }
}
