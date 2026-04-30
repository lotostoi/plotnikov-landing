<section id="pricing" class="relative overflow-hidden py-20 md:py-28">
    <div class="glow glow-theme glow-pulse-theme"
         style="top:10%; left:50%; transform:translateX(-50%); width:30rem; height:30rem; z-index:0; opacity:.12;"></div>

    <div class="relative mx-auto max-w-7xl px-4 md:px-6">

        {{-- Заголовок --}}
        <div class="mx-auto mb-14 max-w-2xl space-y-4 text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-widest theme-gradient-text">{{ $pricingHeading['badge'] }}</p>
            <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                {{ $pricingHeading['title'] }} <span class="theme-gradient-text">{{ $pricingHeading['subtitle'] }}</span>
            </h2>
        </div>

        {{-- Карточки консультаций --}}
        @if (!empty($pricingConsults))
        <div class="grid gap-6 sm:grid-cols-2 mb-8" data-reveal>
            @foreach ($pricingConsults as $consult)
            <article @class([
                'pricing-card',
                'md:col-span-2' => ($consult['desktop_span'] ?? 'half') === 'full',
            ])>
                <div class="pricing-card__header">
                    <div class="pricing-card__icon">
                        <i data-lucide="{{ $consult['icon'] }}" style="width:24px;height:24px"></i>
                    </div>
                    <div>
                        <h3 class="pricing-card__title">{{ $consult['title'] }}</h3>
                        @if ($consult['subtitle'])
                            <p class="pricing-card__subtitle">
                                <i data-lucide="{{ $consult['subtitle_icon'] ?? 'globe' }}" style="width:13px;height:13px"></i>
                                {{ $consult['subtitle'] }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="pricing-card__price">{{ $consult['price'] }}</div>

                @if ($consult['body'])
                <ul class="pricing-card__features">
                    @foreach (array_filter(array_map('trim', explode("\n", $consult['body']))) as $line)
                    <li>
                        <i data-lucide="check" style="width:15px;height:15px;flex-shrink:0"></i>
                        {{ $line }}
                    </li>
                    @endforeach
                </ul>
                @endif

                <a href="{{ $consult['cta_url'] }}" class="pricing-card__cta">
                    {{ $consult['cta_text'] }}
                    <i data-lucide="arrow-right" style="width:16px;height:16px"></i>
                </a>
            </article>
            @endforeach
        </div>
        @endif

        {{-- Акции --}}
        @if (!empty($pricingPromos))
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3" data-reveal>
            @foreach ($pricingPromos as $promo)
            <article class="promo-card p-6 md:p-7">
                <div class="ribbon">
                    <i data-lucide="sparkles" style="width:13px;height:13px"></i>
                    <span>{{ $promo['badge'] }}</span>
                </div>
                <div class="relative pt-3">
                    <h3 class="text-lg font-bold text-white">{{ $promo['title'] }}</h3>
                    @if ($promo['price'])
                        <p class="mt-3 text-2xl font-extrabold text-white">{{ $promo['price'] }}</p>
                    @endif
                    @if ($promo['body'])
                        <p class="mt-2 text-sm leading-relaxed" style="color: rgba(255,255,255,.82)">{{ $promo['body'] }}</p>
                    @endif
                    @if ($promo['terms'])
                        <span class="mt-4 inline-flex items-center rounded-full border px-3 py-1 text-xs font-medium text-white"
                              style="border-color: rgba(255,255,255,.4); background: rgba(255,255,255,.1); backdrop-filter: blur(8px);">
                            {{ $promo['terms'] }}
                        </span>
                    @endif
                </div>
                <span class="deco-1"></span>
                <span class="deco-2"></span>
            </article>
            @endforeach
        </div>
        @endif

    </div>
</section>
