<section id="services" class="relative overflow-hidden py-20 md:py-28">
    <div class="services-bg"></div>
    @include('landing._floating', ['variant' => 'services'])

    <div class="relative mx-auto max-w-7xl px-4 md:px-6">
        @php
            $regularPrice = $servicePricing['regular'];
            $promoPrice = $servicePricing['promo'];
            $regularMeta = is_array($regularPrice?->meta) ? $regularPrice->meta : [];
            $promoMeta = is_array($promoPrice?->meta) ? $promoPrice->meta : [];
        @endphp
        <div class="mx-auto mb-16 max-w-2xl space-y-4 text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-widest" style="color: var(--theme-gradient-from)">{{ $serviceHeading['badge'] }}</p>
            <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                {{ $serviceHeading['title'] }} <span class="theme-gradient-text-amber">{{ $serviceHeading['subtitle'] }}</span>
            </h2>
            <p class="text-lg text-muted-foreground">{{ $serviceHeading['description'] }}</p>
        </div>

        <div class="mb-20 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($serviceIssues as $issue)
                <article class="card card-hover h-full p-6"
                         data-reveal data-reveal-group="services-issues">
                    <div class="icon-box mb-4">
                        <i data-lucide="{{ $issue['icon'] }}" style="width:28px;height:28px"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-foreground">{{ $issue['title'] }}</h3>
                    <p class="mt-2 text-base text-muted-foreground">{{ $issue['description'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="mx-auto max-w-4xl" data-reveal>
            <div class="grid gap-8 md:grid-cols-2">
                {{-- Стандартный прайс --}}
                <article class="card card-strong p-6 md:p-7">
                    <h3 class="text-xl font-bold text-foreground">{{ $regularPrice?->title ?: 'Стандартная консультация' }}</h3>
                    <p class="mt-1 text-sm text-muted-foreground">{{ $regularPrice?->subtitle ?: '1 встреча — 55 минут' }}</p>

                    <div class="mt-5 text-4xl font-bold">
                        <span class="theme-gradient-text-amber">{{ number_format((int) ($regularMeta['price'] ?? 3500), 0, '.', ' ') }}</span>
                        <span class="ml-2 text-lg font-normal text-muted-foreground">{{ ($regularMeta['currency'] ?? 'RUB') === 'RUB' ? 'руб.' : ($regularMeta['currency'] ?? 'RUB') }}</span>
                    </div>

                    <p class="mt-3 text-sm text-muted-foreground">
                        {{ $regularPrice?->body ?: 'Для новых клиентов первая встреча оплачивается заранее' }}
                    </p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($serviceFormats as $format)
                            <span class="badge badge-amber">
                                <i data-lucide="{{ $format['icon'] }}" style="width:14px;height:14px"></i>
                                {{ $format['title'] }}
                            </span>
                        @endforeach
                    </div>
                </article>

                {{-- Промо --}}
                <article class="promo-card p-6 md:p-7">
                    <div class="ribbon">
                        <i data-lucide="sparkles" style="width:14px;height:14px"></i>
                        <span>{{ $promoPrice?->badge ?: 'Акция' }}</span>
                    </div>

                    <div class="relative">
                        <h3 class="pt-3 text-xl font-bold text-white">{{ $promoPrice?->title ?: 'Регулярная онлайн-терапия' }}</h3>
                        <p class="mt-1 text-sm" style="color: rgba(255,255,255,.85)">{{ $promoPrice?->subtitle ?: '1 раз в неделю, 2 места' }}</p>

                        <div class="mt-5 text-4xl font-bold text-white">
                            {{ number_format((int) ($promoMeta['price'] ?? 2000), 0, '.', ' ') }} <span class="text-lg font-normal" style="color: rgba(255,255,255,.85)">{{ ($promoMeta['currency'] ?? 'RUB') === 'RUB' ? 'руб.' : ($promoMeta['currency'] ?? 'RUB') }}</span>
                        </div>

                        <p class="mt-3 text-sm" style="color: rgba(255,255,255,.85)">
                            {{ $promoPrice?->body ?: 'Цена фиксируется на год. Подойдёт тем, кто настроен на длительную работу.' }}
                        </p>

                        <span class="mt-4 inline-flex items-center rounded-full border px-3 py-1 text-xs font-medium text-white"
                              style="border-color: rgba(255,255,255,.5); background: rgba(255,255,255,.1); backdrop-filter: blur(8px);">
                            Осталось {{ (int) ($promoMeta['left_places'] ?? 2) }} места
                        </span>
                    </div>

                    <span class="deco-1"></span>
                    <span class="deco-2"></span>
                </article>
            </div>
        </div>
    </div>
</section>
