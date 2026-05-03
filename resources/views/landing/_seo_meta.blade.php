@php
    $title = $content->seo_title;
    $description = $content->seo_description;
    $keywords = $content->seo_keywords;
    $robots = $content->robots ?: 'index,follow';
    $canonical = $canonicalUrl ?: url('/');
    $ogImage = $ogImage ?: ($images['hero'] ?? null);
    $appleTouchIconUrl = $appleTouchIcon;
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
@if (! empty($keywords))
    <meta name="keywords" content="{{ $keywords }}">
@endif
<meta name="robots" content="{{ $robots }}">
<meta name="googlebot" content="{{ $robots }}">
<meta name="yandex" content="{{ $robots }}">
<meta name="author" content="{{ $content->person_full_name ?: $content->person_name ?: 'Александр' }}">
<meta name="generator" content="Laravel">
<meta name="format-detection" content="telephone=no">
<meta name="theme-color" content="#f5f0e8" media="(prefers-color-scheme: light)">
<meta name="theme-color" content="#14171c" media="(prefers-color-scheme: dark)">

{{-- Verification meta для Search Console / Webmaster --}}
@if (! empty($content->google_site_verification))
    <meta name="google-site-verification" content="{{ $content->google_site_verification }}">
@endif
@if (! empty($content->yandex_verification))
    <meta name="yandex-verification" content="{{ $content->yandex_verification }}">
@endif
@if (! empty($content->bing_site_verification))
    <meta name="msvalidate.01" content="{{ $content->bing_site_verification }}">
@endif

{{-- Канонический URL и альтернативные --}}
<link rel="canonical" href="{{ $canonical }}">
<link rel="alternate" hreflang="ru" href="{{ $canonical }}">
<link rel="alternate" hreflang="x-default" href="{{ $canonical }}">

{{-- Иконки (по умолчанию public/favicon.svg; из админки — загруженный файл) --}}
@include('partials.site_favicon_links', ['favicon' => $favicon ?? null])
@if ($appleTouchIconUrl)
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $appleTouchIconUrl }}">
@endif
<link rel="manifest" href="{{ asset('site.webmanifest') }}">

{{-- Open Graph --}}
<meta property="og:type" content="website">
<meta property="og:locale" content="ru_RU">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:site_name" content="{{ $content->person_full_name ?: 'Александр Психолог' }}">
@if ($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:secure_url" content="{{ $ogImage }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $title }}">
@endif

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if ($ogImage)
    <meta name="twitter:image" content="{{ $ogImage }}">
@endif

{{-- Контактные мета (помогает поиску определять сущность) --}}
@if (! empty($content->person_phone))
    <meta name="contact:phone_number" content="{{ $content->person_phone }}">
@endif
@if (! empty($content->person_email))
    <meta name="contact:email" content="{{ $content->person_email }}">
@endif

{{-- Гео-мета (для локального поиска) --}}
@if ($content->geo_lat && $content->geo_lng)
    <meta name="geo.position" content="{{ $content->geo_lat }};{{ $content->geo_lng }}">
    <meta name="ICBM" content="{{ $content->geo_lat }}, {{ $content->geo_lng }}">
@endif
@if (! empty($content->address_locality))
    <meta name="geo.placename" content="{{ $content->address_locality }}{{ $content->address_region ? ', ' . $content->address_region : '' }}">
@endif
@if (! empty($content->address_country))
    <meta name="geo.region" content="{{ $content->address_country }}">
@endif
