<section id="top" class="relative overflow-hidden py-20 md:py-28 lg:py-36">
    <div class="hero-bg"></div>
    @include('landing._floating', ['variant' => 'hero'])
    <div class="noise-overlay"></div>

    <div class="relative mx-auto max-w-7xl px-4 md:px-6">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            {{-- Текст --}}
            <div class="flex flex-col justify-center space-y-8 text-center lg:text-left" data-reveal data-reveal-delay="0">
                <div class="space-y-6">
                    <p class="inline-block text-sm font-semibold uppercase tracking-widest"
                       style="color: var(--theme-gradient-from)" data-reveal data-reveal-delay="200">
                        {{ $heroHeading['badge'] }}
                    </p>

                    <h1 class="text-balance text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl lg:text-7xl"
                        data-reveal data-reveal-delay="300">
                        <span class="text-foreground">{{ $heroHeading['title'] }}</span><br>
                        <span class="theme-gradient-text-amber">{{ $heroHeading['subtitle'] }}</span>
                    </h1>

                    <p class="mx-auto max-w-[600px] text-pretty text-lg leading-relaxed text-muted-foreground md:text-xl lg:mx-0"
                       data-reveal data-reveal-delay="450">
                        {{ $heroHeading['description'] }}
                    </p>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:justify-center lg:justify-start"
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

                <div class="flex items-center justify-center gap-6 pt-6 sm:gap-8 lg:justify-start"
                     data-reveal data-reveal-delay="800">
                    @foreach ($heroStats as $i => $stat)
                        <div class="flex items-center gap-6 sm:gap-8">
                            <div class="text-center">
                                <p class="text-2xl font-bold theme-gradient-text-amber sm:text-3xl">{{ $stat['value'] }}</p>
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
            <div class="relative mx-auto w-full max-w-md lg:max-w-none" data-reveal="right" data-reveal-delay="400">
                <div class="photo-frame with-top-shadow aspect-[3/4]">
                    <img src="{{ $images['hero'] }}" alt="Александр - психолог, гештальт-терапевт" loading="eager" fetchpriority="high">
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
