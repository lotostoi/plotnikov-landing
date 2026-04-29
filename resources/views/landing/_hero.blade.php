<section id="top" class="hero-section relative overflow-hidden">
    <div class="hero-bg"></div>
    @include('landing._floating', ['variant' => 'hero'])
    <div class="noise-overlay"></div>

    <div class="hero-container relative mx-auto max-w-7xl px-4 md:px-6 w-full">
        <div class="hero-grid grid items-center lg:grid-cols-2">

            {{-- Текст --}}
            <div class="hero-text flex flex-col text-center lg:text-left"
                 data-reveal data-reveal-delay="0">

                <div class="hero-text__head">
                    <p class="inline-block text-sm font-semibold uppercase tracking-widest"
                       style="color: var(--theme-gradient-from)" data-reveal data-reveal-delay="200">
                        {{ $heroHeading['badge'] }}
                    </p>

                    <h1 class="text-balance font-bold tracking-tight hero-h1"
                        data-reveal data-reveal-delay="300">
                        <span class="text-foreground">{{ $heroHeading['title'] }}</span><br>
                        <span class="theme-gradient-text-amber">{{ $heroHeading['subtitle'] }}</span>
                    </h1>

                    <p class="mx-auto max-w-[600px] text-pretty leading-relaxed text-muted-foreground hero-desc lg:mx-0"
                       data-reveal data-reveal-delay="450">
                        {{ $heroHeading['description'] }}
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-center lg:justify-start hero-cta-row"
                     data-reveal data-reveal-delay="600">
                    <a href="{{ $heroPrimaryCta['url'] }}" class="btn btn-lg btn-gradient">
                        <i data-lucide="message-circle" style="width:20px;height:20px"></i>
                        <span>{{ $heroPrimaryCta['text'] }}</span>
                    </a>
                    <a href="{{ $heroSecondaryCta['url'] }}" class="btn btn-lg btn-outline-amber group">
                        <span>{{ $heroSecondaryCta['text'] }}</span>
                        <i data-lucide="arrow-right" style="width:18px;height:18px"></i>
                    </a>
                </div>

                <div class="flex items-center justify-center gap-6 sm:gap-8 lg:justify-start hero-stats"
                     data-reveal data-reveal-delay="800">
                    @foreach ($heroStats as $i => $stat)
                        <div class="flex items-center gap-6 sm:gap-8">
                            <div class="text-center">
                                <p class="hero-stat-value font-bold theme-gradient-text-amber">{{ $stat['value'] }}</p>
                                <p class="text-xs text-muted-foreground sm:text-sm">{{ $stat['label'] }}</p>
                            </div>
                            @if ($i < count($heroStats) - 1)
                                <div class="h-10 w-px" style="background: color-mix(in srgb, var(--theme-gradient-from) 35%, transparent)"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Изображение --}}
            <div class="hero-image-wrap relative mx-auto w-full max-w-md lg:max-w-none"
                 data-reveal="right" data-reveal-delay="400">
                {{-- Градиентный оверлей для мобайла --}}
                <div class="hero-mobile-overlay" aria-hidden="true"></div>
                <div class="photo-frame with-top-shadow hero-photo-frame">
                    <img src="{{ $images['hero'] }}"
                         alt="Александр - психолог, гештальт-терапевт"
                         style="width:100%; height:100%; object-fit:cover;"
                         loading="eager" fetchpriority="high">
                </div>

                <div class="glow glow-amber glow-pulse-amber" style="bottom:-2rem; left:-2rem; width:12rem; height:12rem; z-index:-1;"></div>
                <div class="glow glow-teal glow-pulse-teal" style="top:-2rem; right:-2rem; width:14rem; height:14rem; z-index:-1;"></div>

                <div class="hero-badge" data-reveal data-reveal-delay="1100">
                    <p class="text-xs uppercase tracking-wider text-muted-foreground">{{ $heroFormat['label'] }}</p>
                    <p class="text-sm font-semibold theme-gradient-text-amber">{{ $heroFormat['text'] }}</p>
                </div>
            </div>

        </div>
    </div>
</section>
