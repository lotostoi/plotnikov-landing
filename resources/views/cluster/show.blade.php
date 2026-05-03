@php
    $defaultTheme = in_array($content?->default_theme ?? 'warm', ['warm', 'dark'], true)
        ? ($content?->default_theme ?? 'warm')
        : 'warm';
    $faviconUrl = $content?->faviconResolvedUrl();
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
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $cluster['seo_title'] }}">
    <meta name="twitter:description" content="{{ $cluster['seo_description'] }}">
    <meta name="twitter:image" content="{{ $heroImage }}">

    @include('partials.site_favicon_links', ['favicon' => $faviconUrl])
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="{{ $heroImage }}" fetchpriority="high">
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}?v={{ filemtime(public_path('css/tailwind.css')) }}">
    <script src="https://unpkg.com/lucide@latest" defer></script>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v={{ filemtime(public_path('css/landing.css')) }}">

    <script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

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
                <i data-lucide="arrow-left" style="width:17px;height:17px;" class="text-muted-foreground"></i>
                <span class="text-xl font-bold tracking-tight theme-gradient-text">{{ $personFullName }}</span>
            </a>
            <div class="flex items-center gap-3">
                <button id="theme-toggle" type="button" class="theme-toggle" aria-label="Переключить тему">
                    <i data-lucide="moon" class="icon-moon" style="width:20px;height:20px"></i>
                    <i data-lucide="sun"  class="icon-sun"  style="width:20px;height:20px"></i>
                </button>
                <a href="{{ $tgUrl }}" target="_blank" rel="noopener" class="btn btn-sm btn-theme">Записаться</a>
            </div>
        </div>
    </header>

    <main>
        <section id="top" class="hero-section relative overflow-x-hidden">
            <div class="hero-bg"></div>
            @include('landing._floating', ['variant' => 'hero'])
            <div class="noise-overlay"></div>

            <div class="hero-container relative mx-auto max-w-7xl px-4 md:px-6 w-full">
                <div class="hero-grid grid items-center lg:grid-cols-2">

                    <div class="hero-text flex flex-col text-center lg:text-left" data-reveal>
                        <div class="hero-text__head">
                            <p class="inline-block text-sm font-semibold uppercase tracking-widest"
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

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-center lg:justify-start hero-cta-row"
                             data-reveal data-reveal-delay="600">
                            <a href="{{ $canonicalBase }}/"
                               class="btn btn-gradient hero-cta-primary-desktop"
                               style="padding:1rem 2rem;font-size:1.1rem;font-weight:800;gap:.75rem;border-radius:1rem;box-shadow:0 6px 28px color-mix(in srgb, var(--theme-gradient-from) 45%, transparent);">
                                <span>Подробнее обо мне</span>
                                <i data-lucide="arrow-right" style="width:22px;height:22px"></i>
                            </a>
                            <a href="#contacts"
                               class="btn btn-lg btn-outline-amber group hero-cta-secondary">
                                <span>Написать</span>
                                <i data-lucide="arrow-down" style="width:18px;height:18px"></i>
                            </a>
                        </div>

                        <div class="flex items-center justify-center gap-6 sm:gap-8 lg:justify-start hero-stats"
                             data-reveal data-reveal-delay="800">
                            @foreach ($cluster['stats'] as $i => $stat)
                                <div class="flex items-center gap-6 sm:gap-8">
                                    <div class="text-center">
                                        <p class="hero-stat-value font-bold theme-gradient-text-amber">{{ $stat['value'] }}</p>
                                        <p class="text-xs text-muted-foreground sm:text-sm">{{ $stat['label'] }}</p>
                                    </div>
                                    @if ($i < count($cluster['stats']) - 1)
                                        <div class="h-10 w-px" style="background: color-mix(in srgb, var(--theme-gradient-from) 35%, transparent)"></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="hero-image-wrap relative mx-auto w-full max-w-md lg:max-w-none"
                         data-reveal="right" data-reveal-delay="400">
                        <div class="hero-mobile-overlay" aria-hidden="true"></div>
                        <div class="photo-frame with-top-shadow hero-photo-frame">
                            <img src="{{ $heroImage }}"
                                 alt="{{ $personFullName }} — {{ $cluster['h1'] }}"
                                 style="width:100%;height:100%;object-fit:cover;"
                                 loading="eager" fetchpriority="high">
                        </div>
                        <div class="glow glow-amber glow-pulse-amber" style="bottom:-2rem;left:-2rem;width:12rem;height:12rem;z-index:-1;"></div>
                        <div class="glow glow-teal glow-pulse-teal" style="top:-2rem;right:-2rem;width:14rem;height:14rem;z-index:-1;"></div>
                        <div class="hero-badge" data-reveal data-reveal-delay="1100">
                            <p class="text-xs uppercase tracking-wider text-muted-foreground">Формат</p>
                            <p class="text-sm font-semibold theme-gradient-text-amber">Онлайн по всему миру</p>
                        </div>
                    </div>

                    <a href="#contacts" class="btn btn-gradient hero-cta-primary-float"
                       style="font-weight:800;gap:.6rem;">
                        <span>Написать</span>
                        <i data-lucide="arrow-down" style="width:16px;height:16px"></i>
                    </a>

                </div>
            </div>
        </section>

        {{-- Контакты --}}
        <section id="contacts" class="relative overflow-hidden py-20 md:py-28 bg-secondary">
            <div class="contacts-bg"></div>
            @include('landing._floating', ['variant' => 'contacts'])

            <div class="relative mx-auto max-w-7xl px-4 md:px-6">
                <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">

                    <div class="flex flex-col justify-center space-y-8" data-reveal="left">
                        <div class="space-y-4 self-start text-left">
                            <p class="text-sm font-semibold uppercase tracking-widest"
                               style="color: var(--theme-gradient-from)">Контакты</p>
                            <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                                Запишитесь на <span class="theme-gradient-text-amber">консультацию</span>
                            </h2>
                            <p class="text-lg leading-relaxed text-muted-foreground">
                                Пишите в любой удобный мессенджер — отвечаю в течение дня.
                            </p>
                        </div>

                        <div class="free-call-card" data-reveal data-reveal-delay="200">
                            <span class="deco"></span>
                            <div class="relative flex items-center gap-4">
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl"
                                     style="background:rgba(255,255,255,.2);backdrop-filter:blur(8px);">
                                    <i data-lucide="phone" style="width:26px;height:26px;color:#fff"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">Бесплатный созвон</h3>
                                    <p class="text-sm" style="color:rgba(255,255,255,.85)">15 минут для знакомства</p>
                                </div>
                            </div>
                            <p class="relative mt-4" style="color:rgba(255,255,255,.95)">
                                Можно предварительно созвониться — просто познакомиться и понять, подходим ли мы друг другу. Это бесплатно и ни к чему не обязывает.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4" data-reveal="right">
                        <p class="font-semibold text-foreground">Напишите мне:</p>
                        <div class="flex flex-col flex-wrap gap-4 sm:flex-row">
                            <a href="{{ $tgUrl }}" target="_blank" rel="noopener"
                               class="btn btn-lg btn-telegram flex-1 min-w-[10rem]">
                                <i data-lucide="send" style="width:20px;height:20px"></i>
                                <span>Telegram</span>
                            </a>
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                               class="btn btn-lg btn-whatsapp flex-1 min-w-[10rem]">
                                <i data-lucide="message-circle" style="width:20px;height:20px"></i>
                                <span>WhatsApp</span>
                            </a>
                            <a href="{{ $maxUrl }}" target="_blank" rel="noopener"
                               class="btn btn-lg btn-max flex-1 min-w-[10rem]">
                                <i data-lucide="message-square" style="width:20px;height:20px"></i>
                                <span>Max</span>
                            </a>
                        </div>

                        <div class="card flex items-center gap-3 p-4 mt-2">
                            <div class="icon-box-sm icon-box" style="width:42px;height:42px;border-radius:.85rem">
                                <i data-lucide="map-pin" style="width:20px;height:20px"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-foreground">Очный приём</p>
                                <p class="text-sm text-muted-foreground">{{ $content?->location_text ?: 'Владивосток, Артём' }}</p>
                            </div>
                        </div>

                        @if ($content?->person_phone)
                            <a href="tel:{{ $content->person_phone }}"
                               class="inline-flex items-center gap-2 text-sm font-semibold text-foreground hover:opacity-75 transition-opacity">
                                <i data-lucide="phone" style="width:15px;height:15px;color:var(--theme-gradient-from)"></i>
                                {{ $content->person_phone }}
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </section>

    </main>

    <footer class="border-t border-border py-8">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="flex flex-col items-center gap-3 text-center">
                <a href="{{ $canonicalBase }}/" class="text-lg font-bold theme-gradient-text">{{ $personFullName }}</a>
                <nav class="flex flex-wrap justify-center gap-x-5 gap-y-1 text-sm text-muted-foreground">
                    <a href="{{ $canonicalBase }}/" class="hover:text-foreground transition-colors">Главная</a>
                    <a href="{{ $canonicalBase }}/psiholog-online" class="hover:text-foreground transition-colors">Психолог онлайн</a>
                    <a href="{{ $canonicalBase }}/geshtalt-terapevt" class="hover:text-foreground transition-colors">Гештальт-терапевт</a>
                    <a href="{{ $canonicalBase }}/psiholog-vladivostok" class="hover:text-foreground transition-colors">Психолог Владивосток</a>
                    <a href="{{ $canonicalBase }}/psiholog-artem" class="hover:text-foreground transition-colors">Психолог Артём</a>
                    <a href="{{ $canonicalBase }}/blog" class="hover:text-foreground transition-colors">Блог</a>
                </nav>
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
