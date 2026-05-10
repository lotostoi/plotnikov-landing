<section id="blog" class="relative overflow-hidden py-20 md:py-28 bg-secondary">
    <div class="glow glow-theme glow-pulse-theme"
         style="top:25%; right:0; width:20rem; height:20rem; z-index:0;"></div>

    <div class="relative mx-auto max-w-7xl px-4 md:px-6">
        <div class="mb-16 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between" data-reveal>
            <div class="space-y-4">
                <p class="text-sm font-semibold uppercase tracking-widest theme-gradient-text">{{ $blogHeading['badge'] }}</p>
                <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                    {{ $blogHeading['title'] }} <span class="theme-gradient-text">{{ $blogHeading['subtitle'] }}</span>
                </h2>
            </div>
            <a href="{{ $blogAllCta['url'] }}" class="group inline-flex items-center text-sm font-semibold theme-gradient-text">
                <span>{{ $blogAllCta['text'] }}</span>
                <i data-lucide="arrow-right"
                   style="width:16px;height:16px;margin-left:.4rem;color:var(--theme-gradient-from);transition:transform .25s ease"></i>
            </a>
        </div>

        @if ($articles->isNotEmpty())
            <div class="grid gap-8 md:grid-cols-3">
                @foreach ($articles as $article)
                    <a href="{{ route('blog.show', $article->slug) }}"
                       class="card card-hover overflow-hidden group block"
                       data-reveal data-reveal-group="blog-cards">
                        @if ($article->cover_image_url)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ $article->cover_image_url }}" alt="{{ $article->title }}"
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
                            <h3 class="text-lg font-bold text-foreground leading-snug">
                                {{ $article->title }}
                            </h3>
                        </div>
                        <div class="space-y-3 px-6 pb-6">
                            @if ($article->snippet)
                                <p class="text-sm text-muted-foreground line-clamp-3">{{ $article->snippet }}</p>
                            @endif
                            <div class="flex items-center justify-between text-xs text-muted-foreground">
                                <span class="inline-flex items-center gap-1">
                                    <i data-lucide="calendar" style="width:13px;height:13px"></i>
                                    {{ $article->published_at?->translatedFormat('d F Y') ?? '' }}
                                </span>
                                @if (($article->likes_count ?? 0) > 0)
                                    <span class="inline-flex items-center gap-0.5">❤️ {{ $article->likes_count }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 text-center opacity-60">
                <i data-lucide="file-text" style="width:40px;height:40px;color:var(--muted-foreground);margin-bottom:.75rem;"></i>
                <p class="text-muted-foreground">Статьи скоро появятся</p>
            </div>
        @endif
    </div>
</section>
