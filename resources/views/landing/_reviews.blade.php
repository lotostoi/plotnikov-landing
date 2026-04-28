<section id="reviews" class="relative overflow-hidden py-20 md:py-28 theme-surface">
    <div class="glow glow-theme glow-pulse-theme"
         style="bottom:0; left:25%; width:24rem; height:24rem; z-index:0;"></div>

    <div class="relative mx-auto max-w-7xl px-4 md:px-6">
        <div class="mx-auto mb-16 max-w-2xl space-y-4 text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-widest theme-gradient-text">{{ $reviewsHeading['badge'] }}</p>
            <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                {{ $reviewsHeading['title'] }} <span class="theme-gradient-text">{{ $reviewsHeading['subtitle'] }}</span>
            </h2>
            <p class="text-lg text-muted-foreground">
                {{ $reviewsHeading['description'] }}
            </p>
        </div>

        <div class="grid gap-8 md:grid-cols-3">
            @foreach ($reviews as $review)
                <article class="card card-hover h-full p-6 flex flex-col"
                         data-reveal="scale" data-reveal-group="reviews">
                    <div class="flex items-center justify-between">
                        <div class="icon-box icon-box-sm">
                            <i data-lucide="quote" style="width:22px;height:22px"></i>
                        </div>
                        <div class="flex gap-0.5">
                            @for ($i = 0; $i < 5; $i++)
                                <i data-lucide="star" class="star" style="width:16px;height:16px"></i>
                            @endfor
                        </div>
                    </div>

                    <p class="mt-5 flex-grow leading-relaxed text-muted-foreground">
                        “{{ $review['text'] }}”
                    </p>

                    <div class="mt-5 border-t pt-4" style="border-color: var(--border)">
                        <p class="font-semibold text-foreground">{{ $review['author'] }}</p>
                        <p class="text-sm font-medium theme-gradient-text">{{ $review['detail'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
