@php
    $personId = $canonicalUrl . '#person';
    $businessId = $canonicalUrl . '#business';
    $websiteId = $canonicalUrl . '#website';
    $orgId = $canonicalUrl . '#organization';
    $schemaDescription = $content->seo_description ?: 'Гештальт-терапевт Александр Плотников — онлайн-консультации по всему миру, очно во Владивостоке и Артёме. 15 лет практики. Первый созвон бесплатно.';

    $person = [
        '@type' => 'Person',
        '@id' => $personId,
        'name' => $content->person_full_name ?: ($content->person_name ?: 'Александр'),
        'givenName' => $content->person_name ?: 'Александр',
        'jobTitle' => $content->person_job_title ?: 'Психолог, гештальт-терапевт',
        'description' => $content->person_bio ?: $schemaDescription,
        'image' => $content->person_image_url ?: ($images['hero'] ?? null),
        'url' => $canonicalUrl,
        'knowsAbout' => [
            'Гештальт-терапия',
            'Психотерапия',
            'Когнитивно-поведенческая терапия',
            'Трансактный анализ',
            'Процессуальная психология',
        ],
        'sameAs' => $schemaSocialUrls ?? array_values(array_filter([
            $content->telegram_url,
            $content->whatsapp_url,
            $content->vk_url,
            $content->youtube_url,
            $content->instagram_url,
        ])),
    ];

    if (! empty($content->person_phone)) {
        $person['telephone'] = $content->person_phone;
    }
    if (! empty($content->person_email)) {
        $person['email'] = $content->person_email;
    }

    $address = array_filter([
        '@type' => 'PostalAddress',
        'streetAddress' => $content->address_street,
        'addressLocality' => $content->address_locality ?: 'Владивосток',
        'addressRegion' => $content->address_region,
        'postalCode' => $content->address_postal,
        'addressCountry' => $content->address_country ?: 'RU',
    ]);

    $business = [
        '@type' => ['LocalBusiness', 'MedicalBusiness'],
        '@id' => $businessId,
        'name' => $content->person_full_name ?: 'Александр Психолог',
        'description' => $schemaDescription,
        'url' => $canonicalUrl,
        'image' => $ogImage ?: ($images['hero'] ?? null),
        'logo' => $ogImage ?: ($images['hero'] ?? null),
        'priceRange' => $content->price_range ?: '₽₽',
        'address' => $address,
        'founder' => ['@id' => $personId],
        'employee' => ['@id' => $personId],
        'areaServed' => [
            ['@type' => 'Country', 'name' => 'Россия'],
            ['@type' => 'Place', 'name' => 'Онлайн (по всему миру)'],
        ],
    ];

    if (! empty($content->person_phone)) {
        $business['telephone'] = $content->person_phone;
    }
    if (! empty($content->person_email)) {
        $business['email'] = $content->person_email;
    }
    if ($content->geo_lat && $content->geo_lng) {
        $business['geo'] = [
            '@type' => 'GeoCoordinates',
            'latitude' => $content->geo_lat,
            'longitude' => $content->geo_lng,
        ];
    }
    if (! empty($content->opening_hours)) {
        $business['openingHours'] = $content->opening_hours;
    }
    $sameAs = $schemaSocialUrls ?? array_values(array_filter([
        $content->telegram_url, $content->whatsapp_url, $content->vk_url,
        $content->youtube_url, $content->instagram_url,
    ]));
    if (! empty($sameAs)) {
        $business['sameAs'] = $sameAs;
    }

    // Каталог услуг с ценами
    $offerCatalog = [
        '@type' => 'OfferCatalog',
        'name' => 'Услуги психолога',
        'itemListElement' => array_values(array_filter([
            $content->price_regular ? [
                '@type' => 'Offer',
                'name' => 'Стандартная консультация',
                'description' => '1 встреча — 55 минут. Гештальт-терапия, КПТ, трансактный анализ.',
                'price' => (string) $content->price_regular,
                'priceCurrency' => $content->price_currency ?: 'RUB',
                'availability' => 'https://schema.org/InStock',
                'url' => $canonicalUrl . '#services',
                'itemOffered' => [
                    '@type' => 'Service',
                    'name' => 'Психологическая консультация',
                    'serviceType' => 'Психотерапия',
                    'provider' => ['@id' => $personId],
                ],
            ] : null,
            $content->price_promo ? [
                '@type' => 'Offer',
                'name' => 'Регулярная онлайн-терапия',
                'description' => '1 раз в неделю, цена фиксируется на год. 2 места.',
                'price' => (string) $content->price_promo,
                'priceCurrency' => $content->price_currency ?: 'RUB',
                'availability' => 'https://schema.org/LimitedAvailability',
                'url' => $canonicalUrl . '#services',
                'itemOffered' => [
                    '@type' => 'Service',
                    'name' => 'Регулярная психологическая работа онлайн',
                    'serviceType' => 'Психотерапия',
                    'provider' => ['@id' => $personId],
                ],
            ] : null,
        ])),
    ];
    if (! empty($offerCatalog['itemListElement'])) {
        $business['hasOfferCatalog'] = $offerCatalog;
    }

    $website = [
        '@type' => 'WebSite',
        '@id' => $websiteId,
        'url' => $canonicalUrl,
        'name' => $content->seo_title,
        'description' => $schemaDescription,
        'inLanguage' => 'ru-RU',
        'publisher' => ['@id' => $personId],
    ];

    $faqPage = [
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($faq) => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ],
        ], $faqs),
    ];

    $graph = [
        '@context' => 'https://schema.org',
        '@graph' => [$person, $business, $website, $faqPage],
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($graph, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
