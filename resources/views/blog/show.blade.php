<!DOCTYPE html>
<html lang="ru" data-theme="warm" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    @php
        $articleUrl   = url()->current();
        $siteBase     = rtrim($contacts?->canonical_url ?: config('app.url') ?: url('/'), '/');
        $personName   = $contacts?->person_full_name ?: ($contacts?->person_name ?: 'Александр Плотников');
        $metaDesc     = $article->excerpt ?: $article->snippet;
    @endphp

    <title>{{ $article->title }} — Александр, психолог</title>
    <meta name="description" content="{{ $metaDesc }}">

    {{-- OpenGraph --}}
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:url" content="{{ $articleUrl }}">
    <meta property="og:site_name" content="{{ $personName }}">
    <meta property="og:locale" content="ru_RU">
    @if ($article->cover_image_url)
        <meta property="og:image" content="{{ $article->cover_image_url }}">
        <meta property="og:image:alt" content="{{ $article->title }}">
    @endif
    @if ($article->published_at)
        <meta property="article:published_time" content="{{ $article->published_at->toIso8601String() }}">
    @endif
    @if ($article->updated_at)
        <meta property="article:modified_time" content="{{ $article->updated_at->toIso8601String() }}">
    @endif
    <meta property="article:author" content="{{ $personName }}">
    @if ($article->category)
        <meta property="article:section" content="{{ $article->category }}">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:description" content="{{ $metaDesc }}">
    @if ($article->cover_image_url)
        <meta name="twitter:image" content="{{ $article->cover_image_url }}">
    @endif

    <link rel="canonical" href="{{ $articleUrl }}">

    {{-- JSON-LD: BlogPosting + BreadcrumbList --}}
    @php
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                array_filter([
                    '@type'            => 'BlogPosting',
                    '@id'              => $articleUrl . '#article',
                    'headline'         => $article->title,
                    'description'      => $metaDesc,
                    'image'            => $article->cover_image_url ?: null,
                    'url'              => $articleUrl,
                    'datePublished'    => $article->published_at?->toIso8601String(),
                    'dateModified'     => ($article->updated_at ?? $article->published_at)?->toIso8601String(),
                    'inLanguage'       => 'ru-RU',
                    'articleSection'   => $article->category ?: null,
                    'author'           => ['@type' => 'Person', 'name' => $personName, 'url' => $siteBase . '/'],
                    'publisher'        => ['@type' => 'Organization', 'name' => $personName, 'url' => $siteBase . '/'],
                    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $articleUrl],
                ]),
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Главная', 'item' => $siteBase . '/'],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Блог',    'item' => $siteBase . '/blog'],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $article->title, 'item' => $articleUrl],
                    ],
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

    @include('partials.site_favicon_links', ['favicon' => $faviconUrl ?? null])
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest" defer></script>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v={{ filemtime(public_path('css/landing.css')) }}">

    <script>
        (function () {
            try {
                var t = localStorage.getItem('theme');
                if (t === 'dark' || t === 'warm') document.documentElement.setAttribute('data-theme', t);
            } catch (e) {}
        })();
    </script>

    <style>
        .article-content {
            line-height: 1.8;
            color: var(--foreground);
        }
        .article-content h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 2rem 0 0.75rem;
            color: var(--foreground);
        }
        .article-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 1.5rem 0 0.5rem;
            color: var(--foreground);
        }
        .article-content p {
            margin: 0 0 1rem;
        }
        .article-content ul, .article-content ol {
            padding-left: 1.5rem;
            margin: 0 0 1rem;
        }
        .article-content ul { list-style: disc; }
        .article-content ol { list-style: decimal; }
        .article-content li { margin-bottom: 0.4rem; }
        .article-content blockquote {
            border-left: 4px solid var(--theme-gradient-from);
            padding: 0.75rem 1.25rem;
            margin: 1.5rem 0;
            background: var(--accent);
            border-radius: 0 0.5rem 0.5rem 0;
            font-style: italic;
            color: var(--muted-foreground);
        }
        .article-content pre, .article-content code {
            background: var(--muted);
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }
        .article-content pre {
            padding: 1rem;
            overflow-x: auto;
            margin: 1rem 0;
        }
        .article-content code {
            padding: 0.1em 0.3em;
        }
        .article-content a {
            color: var(--theme-gradient-from);
            text-decoration: underline;
            text-decoration-color: transparent;
            transition: text-decoration-color 0.2s;
        }
        .article-content a:hover {
            text-decoration-color: var(--theme-gradient-from);
        }
        .article-content img {
            max-width: 100%;
            border-radius: 0.75rem;
            margin: 1.5rem 0;
        }
        .article-content hr {
            border: none;
            border-top: 1px solid var(--border);
            margin: 2rem 0;
        }
        .article-content strong { color: var(--foreground); }
    </style>
</head>
<body class="bg-background text-foreground" style="font-family:'Manrope',sans-serif;">

    {{-- Шапка --}}
    <header class="sticky top-0 z-50 border-b border-border bg-background/80 backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 md:px-6">
            <a href="{{ route('blog.index') }}" class="flex items-center gap-2 text-foreground hover:opacity-80 transition-opacity">
                <i data-lucide="arrow-left" style="width:18px;height:18px;"></i>
                <span class="text-sm text-muted-foreground">Все статьи</span>
            </a>
            <button id="theme-toggle" class="rounded-full p-2 text-muted-foreground hover:text-foreground transition-colors" aria-label="Переключить тему">
                <i data-lucide="sun" id="icon-sun" style="width:18px;height:18px;display:none"></i>
                <i data-lucide="moon" id="icon-moon" style="width:18px;height:18px;"></i>
            </button>
        </div>
    </header>

    {{-- Обложка --}}
    @if ($article->cover_image_url)
        <div class="mx-auto max-w-4xl px-4 pt-10 md:px-6">
            <div class="aspect-video overflow-hidden rounded-2xl">
                <img src="{{ $article->cover_image_url }}"
                     alt="{{ $article->title }}"
                     class="h-full w-full object-cover">
            </div>
        </div>
    @endif

    {{-- Статья --}}
    <article class="mx-auto max-w-3xl px-4 py-10 md:px-6">

        {{-- Мета --}}
        <div class="mb-6 flex flex-wrap items-center gap-3">
            @if ($article->category)
                <span class="badge theme-accent-light">{{ $article->category }}</span>
            @endif
            @if ($article->read_time)
                <span class="inline-flex items-center gap-1 text-sm text-muted-foreground">
                    <i data-lucide="clock" style="width:14px;height:14px"></i>
                    {{ $article->read_time }}
                </span>
            @endif
            @if ($article->published_at)
                <span class="inline-flex items-center gap-1 text-sm text-muted-foreground">
                    <i data-lucide="calendar" style="width:14px;height:14px"></i>
                    {{ $article->published_at->translatedFormat('d F Y') }}
                </span>
            @endif
        </div>

        {{-- Заголовок --}}
        <h1 class="mb-8 text-3xl font-bold leading-tight tracking-tight text-foreground sm:text-4xl">
            {{ $article->title }}
        </h1>

        {{-- Краткое описание --}}
        @if ($article->excerpt)
            <p class="mb-8 text-lg text-muted-foreground border-l-4 pl-4" style="border-color: var(--theme-gradient-from)">
                {{ $article->excerpt }}
            </p>
        @endif

        {{-- Тело статьи --}}
        <div class="article-content">
            {!! $article->content !!}
        </div>
    </article>

    {{-- Лайк --}}
    <div class="mx-auto max-w-3xl px-4 pb-8 md:px-6">
        <div class="flex items-center gap-3">
            <button
                id="like-btn"
                data-url="{{ route('blog.like', $article->slug) }}"
                data-liked="{{ $userLiked ? 'true' : 'false' }}"
                class="inline-flex items-center gap-2 rounded-full border px-5 py-2 text-sm font-semibold transition-all duration-200 hover:scale-105 active:scale-95 focus:outline-none"
                style="{{ $userLiked
                    ? 'background: var(--theme-gradient-from); color: #fff; border-color: transparent;'
                    : 'background: transparent; color: var(--muted-foreground); border-color: var(--border);' }}"
            >
                <span id="like-heart">{{ $userLiked ? '❤️' : '🤍' }}</span>
                <span id="like-count">{{ $likesCount }}</span>
            </button>
            <span class="text-sm text-muted-foreground">{{ $userLiked ? 'Вам понравилась эта статья' : 'Понравилась статья?' }}</span>
        </div>
    </div>

    {{-- CTA-баннер --}}
    @php
        $tgUrl = $contacts?->telegram_url ?: 'https://t.me/AlexanderP_V';
        $waUrl = $contacts?->whatsapp_url ?: 'https://wa.me/79242521756';
    @endphp
    <div class="mx-auto max-w-3xl px-4 pb-10 md:px-6">
        <div class="relative overflow-hidden rounded-2xl px-7 py-9 md:px-10 md:py-11"
             style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%); box-shadow: 0 8px 40px rgba(79,70,229,.45);">

            {{-- Декор --}}
            <span class="pointer-events-none absolute -right-12 -top-12 h-52 w-52 rounded-full"
                  style="background: radial-gradient(circle, rgba(167,139,250,.25) 0%, transparent 70%);"></span>
            <span class="pointer-events-none absolute -bottom-10 -left-10 h-44 w-44 rounded-full"
                  style="background: radial-gradient(circle, rgba(196,181,253,.18) 0%, transparent 70%);"></span>

            <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                {{-- Текст --}}
                <div class="space-y-3 lg:max-w-md">
                    <span class="inline-block rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-widest"
                          style="background: rgba(167,139,250,.25); color: #c4b5fd; border: 1px solid rgba(167,139,250,.35);">
                        Психолог · Александр Плотников
                    </span>
                    <h3 class="text-2xl font-extrabold text-white sm:text-3xl leading-tight">
                        Тема отзывается?<br>
                        <span style="color: #a78bfa;">Запишитесь на консультацию</span>
                    </h3>
                    <p class="text-sm leading-relaxed" style="color: rgba(255,255,255,.80);">
                        Разберём вашу ситуацию лично — онлайн или очно.
                    </p>
                    <p class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-bold"
                       style="background: rgba(52,211,153,.18); color: #6ee7b7; border: 1px solid rgba(52,211,153,.35);">
                        ✓ Бесплатный созвон для знакомства — 15 минут
                    </p>
                </div>

                {{-- Кнопки --}}
                <div class="flex flex-col gap-3 lg:flex-shrink-0 lg:min-w-[190px]">
                    <a href="{{ $tgUrl }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-bold transition-all duration-200 hover:scale-[1.03] hover:brightness-110"
                       style="background: #5865f2; color: #fff; box-shadow: 0 3px 14px rgba(88,101,242,.5);">
                        <i data-lucide="send" style="width:15px;height:15px;flex-shrink:0;"></i>
                        Написать в Telegram
                    </a>
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-bold transition-all duration-200 hover:scale-[1.03] hover:brightness-110"
                       style="background: #25d366; color: #fff; box-shadow: 0 3px 14px rgba(37,211,102,.4);">
                        <i data-lucide="message-circle" style="width:15px;height:15px;flex-shrink:0;"></i>
                        Написать в WhatsApp
                    </a>
                    <a href="{{ $maxUrl }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-bold transition-all duration-200 hover:scale-[1.03] hover:brightness-110"
                       style="background: #0077ff; color: #fff; box-shadow: 0 3px 14px rgba(0,119,255,.4);">
                        <i data-lucide="message-square" style="width:15px;height:15px;flex-shrink:0;"></i>
                        {{ $maxText }}
                    </a>
                    <a href="{{ $channelUrl }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-semibold transition-all duration-200 hover:scale-[1.03]"
                       style="background: rgba(255,255,255,.10); color: rgba(255,255,255,.85); border: 1.5px solid rgba(255,255,255,.22);">
                        <i data-lucide="book-open" style="width:15px;height:15px;flex-shrink:0;"></i>
                        Читать обо мне в канале
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Похожие статьи --}}
    @if ($related->isNotEmpty())
        <section class="border-t border-border bg-secondary py-16">
            <div class="mx-auto max-w-7xl px-4 md:px-6">
                <h2 class="mb-8 text-xl font-bold text-foreground">Читайте также</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $rel)
                        <a href="{{ route('blog.show', $rel->slug) }}" class="card card-hover group block overflow-hidden">
                            @if ($rel->cover_image_url)
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ $rel->cover_image_url }}" alt="{{ $rel->title }}"
                                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                </div>
                            @else
                                <div class="gradient-strip"></div>
                            @endif
                            <div class="p-5">
                                @if ($rel->category)
                                    <span class="badge theme-accent-light mb-2 inline-block">{{ $rel->category }}</span>
                                @endif
                                <h3 class="font-semibold text-foreground leading-snug">{{ $rel->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Футер --}}
    <footer class="border-t border-border py-8">
        <div class="mx-auto max-w-7xl px-4 text-center md:px-6">
            <p class="text-sm text-muted-foreground">
                <a href="{{ route('landing') }}" class="hover:text-foreground transition-colors">← Вернуться на главную</a>
                <span class="mx-3 text-border">·</span>
                <a href="{{ route('blog.index') }}" class="hover:text-foreground transition-colors">Все статьи</a>
            </p>
        </div>
    </footer>

    <script src="{{ asset('js/landing.js') }}?v={{ filemtime(public_path('js/landing.js')) }}"></script>
    <script>
    (function () {
        var btn = document.getElementById('like-btn');
        if (!btn) return;

        var liked = btn.dataset.liked === 'true';

        btn.addEventListener('click', function () {
            if (liked) return;

            btn.disabled = true;

            fetch(btn.dataset.url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.liked) {
                    liked = true;
                    document.getElementById('like-heart').textContent = '❤️';
                    document.getElementById('like-count').textContent = data.count;
                    btn.style.cssText = 'background: var(--theme-gradient-from); color: #fff; border-color: transparent;';
                    var label = btn.nextElementSibling;
                    if (label) label.textContent = 'Вам понравилась эта статья';
                }
            })
            .catch(function () { btn.disabled = false; });
        });
    })();
    </script>
</body>
</html>
