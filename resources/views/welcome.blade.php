@php
    $defaultTheme = in_array($content->default_theme ?? 'warm', ['warm', 'dark'], true)
        ? ($content->default_theme ?? 'warm')
        : 'warm';
@endphp
<!DOCTYPE html>
<html lang="ru" data-theme="{{ $defaultTheme }}" data-default-theme="{{ $defaultTheme }}" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    {{-- Все мета-теги SEO/OG/Twitter/иконки --}}
    @include('landing._seo_meta')

    {{-- Аналитика (Метрика / GA4 / GTM) --}}
    @include('landing._analytics_head')

    {{-- DNS prefetch & preconnect --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link rel="dns-prefetch" href="https://hebbkx1anhila5yf.public.blob.vercel-storage.com">
    @if (! empty($content->yandex_metrika_id))
        <link rel="preconnect" href="https://mc.yandex.ru">
    @endif
    @if (! empty($content->google_analytics_id) || ! empty($content->google_tag_manager_id))
        <link rel="preconnect" href="https://www.googletagmanager.com">
        <link rel="preconnect" href="https://www.google-analytics.com">
    @endif

    {{-- Preload critical --}}
    <link rel="preload" as="image" href="{{ $images['hero'] }}" fetchpriority="high">
    <link rel="preload" as="style" href="{{ asset('css/landing.css') }}?v={{ filemtime(public_path('css/landing.css')) }}">

    {{-- Шрифт Manrope --}}
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind v4 (через CDN) --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Иконки Lucide --}}
    <script src="https://unpkg.com/lucide@latest" defer></script>

    {{-- Свой CSS (cache-bust по filemtime + хэш в dev) --}}
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v={{ filemtime(public_path('css/landing.css')) }}{{ app()->environment('local') ? '-' . substr(md5_file(public_path('css/landing.css')), 0, 8) : '' }}">

    {{-- JSON-LD: Person, ProfessionalService, WebSite, FAQPage --}}
    @include('landing._json_ld')

    {{-- Anti-flash для темы --}}
    <script>
        (function () {
            try {
                var root = document.documentElement;
                var def = root.getAttribute('data-default-theme') || 'warm';
                var t = localStorage.getItem('theme');
                if (t === 'dark' || t === 'warm') {
                    root.setAttribute('data-theme', t);
                } else if (def === 'dark' || def === 'warm') {
                    root.setAttribute('data-theme', def);
                }
            } catch (_) {}
        })();
    </script>
</head>
<body>
    @include('landing._analytics_body')

    {{-- A11y skip-link --}}
    <a href="#top" class="sr-skip">Перейти к содержимому</a>

    @if ($sectionVisibility['header'] ?? true)
        @include('landing._header')
    @endif

    <main itemscope itemtype="https://schema.org/WebPage">
        @if ($sectionVisibility['hero'] ?? true)
            @include('landing._hero')
        @endif
        @if ($sectionVisibility['about'] ?? true)
            @include('landing._about')
        @endif
        @if ($sectionVisibility['services'] ?? true)
            @include('landing._services')
        @endif
        @if ($sectionVisibility['pricing'] ?? true)
            @include('landing._pricing')
        @endif
        @if ($sectionVisibility['education'] ?? true)
            @include('landing._education')
        @endif
        @if ($sectionVisibility['reviews'] ?? true)
            @include('landing._reviews')
        @endif
        @if ($sectionVisibility['blog'] ?? true)
            @include('landing._blog')
        @endif
        @if ($sectionVisibility['faq'] ?? true)
            @include('landing._faq')
        @endif
        @if ($sectionVisibility['contacts'] ?? true)
            @include('landing._contacts')
        @endif
    </main>

    @if ($sectionVisibility['footer'] ?? true)
        @include('landing._footer')
    @endif

    {{-- noscript fallback --}}
    <noscript>
        <style>[data-reveal]{opacity:1!important;transform:none!important}</style>
    </noscript>

    <script src="{{ asset('js/landing.js') }}?v={{ filemtime(public_path('js/landing.js')) }}{{ app()->environment('local') ? '-' . substr(md5_file(public_path('js/landing.js')), 0, 8) : '' }}" defer></script>
</body>
</html>
