<!DOCTYPE html>
<html lang="ru" data-theme="warm" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $article->title }} — Александр, психолог</title>
    <meta name="description" content="{{ $article->excerpt ?? $article->title }}">

    {{-- OpenGraph --}}
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $article->excerpt ?? $article->title }}">
    @if ($article->cover_image_url)
        <meta property="og:image" content="{{ $article->cover_image_url }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($article->published_at)
        <meta property="article:published_time" content="{{ $article->published_at->toIso8601String() }}">
    @endif

    <link rel="canonical" href="{{ url()->current() }}">

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
</body>
</html>
