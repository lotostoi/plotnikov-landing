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

        <div class="grid gap-8 md:grid-cols-3">
            @foreach ($articles as $article)
                <article class="card card-hover overflow-hidden cursor-pointer"
                         data-reveal data-reveal-group="blog-cards">
                    <div class="gradient-strip"></div>
                    <div class="space-y-4 p-6 pb-2">
                        <div class="flex items-center gap-3">
                            <span class="badge theme-accent-light">{{ $article['category'] }}</span>
                            <span class="inline-flex items-center gap-1 text-xs text-muted-foreground">
                                <i data-lucide="clock" style="width:12px;height:12px"></i>
                                {{ $article['readTime'] }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-foreground transition-colors duration-300 group-hover:theme-gradient-text">
                            {{ $article['title'] }}
                        </h3>
                    </div>
                    <div class="space-y-4 px-6 pb-6">
                        <p class="text-base text-muted-foreground">{{ $article['description'] }}</p>
                        <div class="flex items-center gap-1 text-sm text-muted-foreground">
                            <i data-lucide="calendar" style="width:14px;height:14px"></i>
                            {{ $article['date'] }}
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
