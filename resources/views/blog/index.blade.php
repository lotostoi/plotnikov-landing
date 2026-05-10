<!DOCTYPE html>
<html lang="ru" data-theme="warm" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Блог — Александр, психолог</title>
    <meta name="description" content="Статьи о психологии, гештальт-терапии, отношениях и личностном росте">

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
</head>
<body class="bg-background text-foreground" style="font-family:'Manrope',sans-serif;">

    {{-- Шапка --}}
    <header class="sticky top-0 z-50 border-b border-border bg-background/80 backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 md:px-6">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 text-foreground hover:opacity-80 transition-opacity">
                <i data-lucide="arrow-left" style="width:18px;height:18px;"></i>
                <span class="font-semibold">Александр</span>
                <span class="text-muted-foreground text-sm">/ психолог</span>
            </a>
            <button id="theme-toggle" class="rounded-full p-2 text-muted-foreground hover:text-foreground transition-colors" aria-label="Переключить тему">
                <i data-lucide="sun" id="icon-sun" style="width:18px;height:18px;display:none"></i>
                <i data-lucide="moon" id="icon-moon" style="width:18px;height:18px;"></i>
            </button>
        </div>
    </header>

    {{-- Hero блога --}}
    <section class="py-16 md:py-20">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="space-y-4" data-reveal>
                <p class="text-sm font-semibold uppercase tracking-widest theme-gradient-text">Блог</p>
                <h1 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                    Статьи и <span class="theme-gradient-text">заметки</span>
                </h1>
                <p class="max-w-2xl text-lg text-muted-foreground">
                    О психологии, гештальт-терапии, отношениях и личностном росте
                </p>
            </div>
        </div>
    </section>

    {{-- Список статей --}}
    <section class="pb-20">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            @if ($articles->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <i data-lucide="file-text" style="width:48px;height:48px;color:var(--muted-foreground);margin-bottom:1rem;"></i>
                    <p class="text-xl font-semibold text-foreground">Статьи скоро появятся</p>
                    <p class="mt-2 text-muted-foreground">Следите за обновлениями</p>
                </div>
            @else
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($articles as $article)
                        <article class="card card-hover overflow-hidden group cursor-pointer" data-reveal data-reveal-group="blog-cards">
                            @if ($article->cover_image_url)
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ $article->cover_image_url }}"
                                         alt="{{ $article->title }}"
                                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                </div>
                            @else
                                <div class="gradient-strip"></div>
                            @endif

                            <div class="space-y-3 p-6 pb-2">
                                <div class="flex items-center gap-3">
                                    @if ($article->category)
                                        <span class="badge theme-accent-light">{{ $article->category }}</span>
                                    @endif
                                    @if ($article->read_time)
                                        <span class="inline-flex items-center gap-1 text-xs text-muted-foreground">
                                            <i data-lucide="clock" style="width:12px;height:12px"></i>
                                            {{ $article->read_time }}
                                        </span>
                                    @endif
                                </div>
                                <h2 class="text-lg font-bold text-foreground leading-snug">
                                    {{ $article->title }}
                                </h2>
                            </div>

                            <div class="space-y-4 px-6 pb-6">
                                @if ($article->snippet)
                                    <p class="text-sm text-muted-foreground line-clamp-3">{{ $article->snippet }}</p>
                                @endif
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center gap-2 text-xs text-muted-foreground">
                                        <span class="inline-flex items-center gap-1">
                                            <i data-lucide="calendar" style="width:13px;height:13px"></i>
                                            {{ $article->published_at?->translatedFormat('d F Y') ?? '' }}
                                        </span>
                                        @if (($article->likes_count ?? 0) > 0)
                                            <span class="inline-flex items-center gap-0.5">❤️ {{ $article->likes_count }}</span>
                                        @endif
                                    </span>
                                    <a href="{{ route('blog.show', $article->slug) }}"
                                       class="inline-flex items-center gap-1 text-sm font-semibold theme-gradient-text">
                                        Читать
                                        <i data-lucide="arrow-right" style="width:14px;height:14px;color:var(--theme-gradient-from)"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Пагинация --}}
                @if ($articles->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $articles->links() }}
                    </div>
                @endif
            @endif
        </div>
    </section>

    {{-- Футер --}}
    <footer class="border-t border-border py-8">
        <div class="mx-auto max-w-7xl px-4 text-center md:px-6">
            <p class="text-sm text-muted-foreground">
                <a href="{{ route('landing') }}" class="hover:text-foreground transition-colors">← Вернуться на главную</a>
            </p>
        </div>
    </footer>

    <script src="{{ asset('js/landing.js') }}?v={{ filemtime(public_path('js/landing.js')) }}"></script>
</body>
</html>
