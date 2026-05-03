@php
    /** @var string|null $favicon URL из админки или null — тогда public/favicon.svg */
    $iconUrl = $favicon ?: asset('favicon.svg');
    $path = parse_url((string) $iconUrl, PHP_URL_PATH) ?: '';
    $ext = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));
    $mime = match ($ext) {
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'webp' => 'image/webp',
        'jpg', 'jpeg' => 'image/jpeg',
        'png', 'apng' => 'image/png',
        default => 'image/svg+xml',
    };
@endphp
<link rel="icon" type="{{ $mime }}" href="{{ $iconUrl }}">
<link rel="shortcut icon" href="{{ $iconUrl }}">
