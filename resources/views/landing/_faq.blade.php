<section id="faq" class="relative overflow-hidden py-20 md:py-28 theme-surface">
    <div class="glow glow-theme glow-pulse-theme"
         style="top:33%; left:0; width:18rem; height:18rem; z-index:0;"></div>

    <div class="relative mx-auto max-w-7xl px-4 md:px-6">
        <div class="mx-auto mb-16 max-w-2xl space-y-4 text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-widest theme-gradient-text">{{ $faqHeading['badge'] }}</p>
            <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                {{ $faqHeading['title'] }} <span class="theme-gradient-text">{{ $faqHeading['subtitle'] }}</span>
            </h2>
            <p class="text-lg text-muted-foreground">
                {{ $faqHeading['description'] }}
            </p>
        </div>

        <div class="mx-auto max-w-3xl space-y-4" data-reveal>
            @foreach ($faqs as $i => $faq)
                <div class="faq-item" data-reveal data-reveal-group="faq-list">
                    <button type="button" class="faq-trigger" aria-expanded="false" aria-controls="faq-content-{{ $i }}">
                        <span class="pr-4">{{ $faq['question'] }}</span>
                        <i data-lucide="chevron-down" class="faq-chevron" style="width:20px;height:20px"></i>
                    </button>
                    <div id="faq-content-{{ $i }}" class="faq-content">
                        <p>{{ $faq['answer'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
