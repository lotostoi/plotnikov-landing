@php
    $defaultTheme = in_array($content?->default_theme ?? 'warm', ['warm', 'dark'], true)
        ? ($content?->default_theme ?? 'warm')
        : 'warm';
    $faviconUrl = $content?->faviconResolvedUrl();
    $personPhone = $content?->person_phone;
    $personEmail = $content?->person_email;
    $locationText = $content?->location_text ?: 'Владивосток, Артём';
@endphp
<!DOCTYPE html>
<html lang="ru" data-theme="{{ $defaultTheme }}" data-default-theme="{{ $defaultTheme }}" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <title>{{ $cluster['seo_title'] }}</title>
    <meta name="description" content="{{ $cluster['seo_description'] }}">
    <meta name="keywords" content="{{ $cluster['seo_keywords'] }}">
    <meta name="robots" content="index,follow">
    <meta name="author" content="{{ $personFullName }}">

    <link rel="canonical" href="{{ $canonical }}">
    <link rel="alternate" hreflang="ru" href="{{ $canonical }}">
    <link rel="alternate" hreflang="x-default" href="{{ $canonical }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:title" content="{{ $cluster['seo_title'] }}">
    <meta property="og:description" content="{{ $cluster['seo_description'] }}">
    <meta property="og:site_name" content="{{ $personFullName }}">
    <meta property="og:image" content="{{ $heroImage }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $cluster['seo_title'] }}">
    <meta name="twitter:description" content="{{ $cluster['seo_description'] }}">
    <meta name="twitter:image" content="{{ $heroImage }}">

    @include('partials.site_favicon_links', ['favicon' => $faviconUrl])
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}?v={{ filemtime(public_path('css/tailwind.css')) }}">
    <script src="https://unpkg.com/lucide@latest" defer></script>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v={{ filemtime(public_path('css/landing.css')) }}">

    {{-- JSON-LD --}}
    <script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    {{-- Anti-flash для темы --}}
    <script>
        (function () {
            try {
                var root = document.documentElement;
                var def = root.getAttribute('data-default-theme') || 'warm';
                var t = localStorage.getItem('theme');
                if (t === 'dark' || t === 'warm') root.setAttribute('data-theme', t);
                else if (def) root.setAttribute('data-theme', def);
            } catch (_) {}
        })();
    </script>
</head>
<body class="bg-background text-foreground" style="font-family:'Manrope',sans-serif;">

    {{-- Шапка --}}
    <header class="site-header sticky top-0 z-50 w-full">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 md:px-6">
            <a href="{{ $canonicalBase }}/" class="group flex items-center gap-2 text-foreground hover:opacity-80 transition-opacity">
                <i data-lucide="arrow-left" style="width:16px;height:16px;" class="text-muted-foreground"></i>
                <span class="text-xl font-bold tracking-tight theme-gradient-text">{{ $personFullName }}</span>
                <span class="hidden text-sm sm:inline-block text-muted-foreground">/ психолог</span>
            </a>
            <div class="flex items-center gap-3">
                <button id="theme-toggle" type="button" class="theme-toggle" aria-label="Переключить тему">
                    <i data-lucide="moon" class="icon-moon" style="width:20px;height:20px"></i>
                    <i data-lucide="sun"  class="icon-sun"  style="width:20px;height:20px"></i>
                </button>
                <a href="#contacts" class="btn btn-sm btn-theme">Записаться</a>
            </div>
        </div>
    </header>

    <main>

        {{-- Hero --}}
        <section id="top" class="hero-section relative overflow-x-hidden">
            <div class="hero-bg"></div>
            <div class="noise-overlay"></div>

            <div class="hero-container relative mx-auto max-w-7xl px-4 md:px-6 w-full">
                <div class="hero-grid grid items-center lg:grid-cols-2">

                    {{-- Текст --}}
                    <div class="hero-text flex flex-col text-center lg:text-left" data-reveal data-reveal-delay="0">
                        <div class="hero-text__head">
                            <p class="inline-block text-sm font-semibold uppercase tracking-widest mb-4"
                               style="color: var(--theme-gradient-from)" data-reveal data-reveal-delay="200">
                                {{ $cluster['badge'] }}
                            </p>

                            <h1 class="text-balance font-bold tracking-tight hero-h1" data-reveal data-reveal-delay="300">
                                <span class="text-foreground">{{ $cluster['h1'] }}</span><br>
                                <span class="theme-gradient-text-amber">{{ $cluster['h1_sub'] }}</span>
                            </h1>

                            <p class="mx-auto max-w-[600px] text-pretty leading-relaxed text-muted-foreground hero-desc lg:mx-0"
                               data-reveal data-reveal-delay="450">
                                {{ $cluster['description'] }}
                            </p>
                        </div>

                        {{-- Преимущества --}}
                        <div class="mt-6 grid grid-cols-2 gap-3" data-reveal data-reveal-delay="500">
                            @foreach ($cluster['benefits'] as $benefit)
                                <div class="flex items-center gap-2 text-sm text-muted-foreground">
                                    <i data-lucide="{{ $benefit['icon'] }}" style="width:16px;height:16px;flex-shrink:0;color:var(--theme-gradient-from)"></i>
                                    {{ $benefit['text'] }}
                                </div>
                            @endforeach
                        </div>

                        {{-- CTA-кнопки --}}
                        <div class="hero-cta mt-8 flex flex-wrap justify-center gap-3 lg:justify-start" data-reveal data-reveal-delay="600">
                            <a href="{{ $tgUrl }}" target="_blank" rel="noopener"
                               class="btn btn-lg btn-theme">
                                <i data-lucide="send" style="width:18px;height:18px"></i>
                                Написать в Telegram
                            </a>
                            <a href="#contacts" class="btn btn-lg btn-outline">
                                Бесплатный созвон
                            </a>
                        </div>
                    </div>

                    {{-- Фото --}}
                    <div class="hero-image-wrapper relative flex items-center justify-center" data-reveal="right" data-reveal-delay="200">
                        <div class="hero-image-frame relative z-10">
                            <img src="{{ $heroImage }}"
                                 alt="{{ $personFullName }} — {{ $cluster['h1'] }}"
                                 class="hero-image block"
                                 loading="eager"
                                 fetchpriority="high"
                                 width="520" height="640">
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- Отзывы --}}
        @if ($reviews->isNotEmpty())
            <section class="relative py-20 md:py-24 bg-secondary">
                <div class="mx-auto max-w-7xl px-4 md:px-6">
                    <div class="mb-12 text-center" data-reveal>
                        <p class="text-sm font-semibold uppercase tracking-widest mb-3 theme-gradient-text">Отзывы</p>
                        <h2 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl">
                            Что говорят <span class="theme-gradient-text">клиенты</span>
                        </h2>
                    </div>
                    <div class="grid gap-6 md:grid-cols-3">
                        @foreach ($reviews as $review)
                            <div class="card p-6 flex flex-col gap-4" data-reveal data-reveal-group="cluster-reviews">
                                <div class="flex gap-0.5">
                                    @for ($s = 0; $s < 5; $s++)
                                        <i data-lucide="star" style="width:16px;height:16px;color:var(--theme-gradient-from);fill:var(--theme-gradient-from)"></i>
                                    @endfor
                                </div>
                                <p class="text-sm leading-relaxed text-muted-foreground flex-1">&laquo;{{ $review['text'] }}&raquo;</p>
                                <div>
                                    <p class="font-semibold text-sm text-foreground">{{ $review['author'] }}</p>
                                    @if ($review['detail'])
                                        <p class="text-xs text-muted-foreground">{{ $review['detail'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- FAQ --}}
        @if ($faqs->isNotEmpty())
            <section id="faq" class="relative overflow-hidden py-20 md:py-28 theme-surface">
                <div class="relative mx-auto max-w-7xl px-4 md:px-6">
                    <div class="mx-auto mb-16 max-w-2xl space-y-4 text-center" data-reveal>
                        <p class="text-sm font-semibold uppercase tracking-widest theme-gradient-text">FAQ</p>
                        <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl">
                            Частые <span class="theme-gradient-text">вопросы</span>
                        </h2>
                        <p class="text-lg text-muted-foreground">Ответы на вопросы, которые чаще всего задают перед началом терапии</p>
                    </div>
                    <div class="mx-auto max-w-3xl space-y-4" data-reveal>
                        @foreach ($faqs as $i => $faq)
                            <div class="faq-item" data-reveal data-reveal-group="cluster-faq">
                                <button type="button" class="faq-trigger" aria-expanded="false" aria-controls="cluster-faq-content-{{ $i }}">
                                    <span class="pr-4">{{ $faq['question'] }}</span>
                                    <span class="faq-chevron ml-auto flex-shrink-0">
                                        <i data-lucide="chevron-down" style="width:20px;height:20px"></i>
                                    </span>
                                </button>
                                <div id="cluster-faq-content-{{ $i }}" class="faq-content" role="region">
                                    <p class="pb-5 pt-1 text-sm leading-relaxed text-muted-foreground">{{ $faq['answer'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Контакты --}}
        <section id="contacts" class="relative overflow-hidden py-20 md:py-28 bg-secondary">
            <div class="contacts-bg"></div>

            <div class="relative mx-auto max-w-5xl px-4 md:px-6">
                <div class="text-center mb-12" data-reveal>
                    <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--theme-gradient-from)">Контакты</p>
                    <h2 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl">
                        Запишитесь на <span class="theme-gradient-text-amber">консультацию</span>
                    </h2>
                    <p class="mt-4 text-lg text-muted-foreground">Пишите в любой удобный мессенджер — отвечаю в течение дня.</p>
                </div>

                {{-- Бесплатный созвон --}}
                <div class="free-call-card max-w-xl mx-auto mb-10" data-reveal>
                    <span class="deco"></span>
                    <div class="relative flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl"
                             style="background: rgba(255,255,255,.2); backdrop-filter: blur(8px);">
                            <i data-lucide="phone" style="width:26px;height:26px;color:#fff"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Бесплатный созвон</h3>
                            <p class="text-sm" style="color: rgba(255,255,255,.85)">15 минут для знакомства</p>
                        </div>
                    </div>
                    <p class="relative mt-4" style="color: rgba(255,255,255,.95)">
                        Можно предварительно созвониться — просто познакомиться и понять, подходим ли мы друг другу. Это бесплатно и ни к чему не обязывает.
                    </p>
                </div>

                {{-- Кнопки --}}
                <div class="flex flex-wrap justify-center gap-4" data-reveal data-reveal-delay="200">
                    <a href="{{ $tgUrl }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-2xl px-6 py-4 font-bold transition-all hover:scale-[1.03]"
                       style="background:#5865f2;color:#fff;box-shadow:0 4px 20px rgba(88,101,242,.45)">
                        <i data-lucide="send" style="width:18px;height:18px;flex-shrink:0"></i>
                        Telegram
                    </a>
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-2xl px-6 py-4 font-bold transition-all hover:scale-[1.03]"
                       style="background:#25d366;color:#fff;box-shadow:0 4px 20px rgba(37,211,102,.4)">
                        <i data-lucide="message-circle" style="width:18px;height:18px;flex-shrink:0"></i>
                        WhatsApp
                    </a>
                    <a href="{{ $maxUrl }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-2xl px-6 py-4 font-bold transition-all hover:scale-[1.03]"
                       style="background:#0077ff;color:#fff;box-shadow:0 4px 20px rgba(0,119,255,.4)">
                        <i data-lucide="message-square" style="width:18px;height:18px;flex-shrink:0"></i>
                        Max
                    </a>
                </div>

                {{-- Адрес и телефон --}}
                <div class="mt-10 flex flex-wrap justify-center gap-8 text-sm text-muted-foreground" data-reveal data-reveal-delay="300">
                    <div class="flex items-center gap-2">
                        <i data-lucide="map-pin" style="width:16px;height:16px;color:var(--theme-gradient-from)"></i>
                        {{ $locationText }}
                    </div>
                    @if ($personPhone)
                        <a href="tel:{{ $personPhone }}" class="flex items-center gap-2 hover:text-foreground transition-colors">
                            <i data-lucide="phone" style="width:16px;height:16px;color:var(--theme-gradient-from)"></i>
                            {{ $personPhone }}
                        </a>
                    @endif
                </div>
            </div>
        </section>

    </main>

    {{-- Футер --}}
    <footer class="border-t border-border py-10 bg-background">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="flex flex-col items-center gap-4 text-center">
                <a href="{{ $canonicalBase }}/" class="text-xl font-bold theme-gradient-text">{{ $personFullName }}</a>
                <p class="text-sm text-muted-foreground">Гештальт-терапевт. Помогаю находить опору и контакт с собой.</p>
                <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm text-muted-foreground">
                    <a href="{{ $canonicalBase }}/" class="hover:text-foreground transition-colors">Главная</a>
                    <a href="{{ $canonicalBase }}/psiholog-online" class="hover:text-foreground transition-colors">Психолог онлайн</a>
                    <a href="{{ $canonicalBase }}/geshtalt-terapevt" class="hover:text-foreground transition-colors">Гештальт-терапевт</a>
                    <a href="{{ $canonicalBase }}/psiholog-vladivostok" class="hover:text-foreground transition-colors">Психолог Владивосток</a>
                    <a href="{{ $canonicalBase }}/psiholog-artem" class="hover:text-foreground transition-colors">Психолог Артём</a>
                    <a href="{{ $canonicalBase }}/blog" class="hover:text-foreground transition-colors">Блог</a>
                </div>
                <p class="text-xs text-muted-foreground">© {{ date('Y') }} {{ $personFullName }}</p>
            </div>
        </div>
    </footer>

    <noscript>
        <style>[data-reveal]{opacity:1!important;transform:none!important}</style>
    </noscript>

    <script src="{{ asset('js/landing.js') }}?v={{ filemtime(public_path('js/landing.js')) }}" defer></script>
</body>
</html>
