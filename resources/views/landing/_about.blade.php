<section id="about" class="relative overflow-hidden py-20 md:py-28">
    <div class="about-bg"></div>
    @include('landing._floating', ['variant' => 'about'])

    <div class="relative mx-auto max-w-7xl px-4 md:px-6">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            {{-- Изображение --}}
            <div class="relative mx-auto w-full max-w-md lg:max-w-none order-2 lg:order-1"
                 data-reveal="left">
                <div class="photo-frame aspect-[4/5]">
                    <img src="{{ $images['about'] }}" alt="Александр с книгой по гештальт-терапии" loading="lazy">
                </div>
                <div class="glow glow-amber"
                     style="bottom:-1rem; right:-1rem; width:66%; height:66%; z-index:-1; opacity:.3;"></div>
            </div>

            {{-- Контент --}}
            <div class="flex flex-col justify-center space-y-8 order-1 lg:order-2">
                <div class="space-y-4" data-reveal data-reveal-group="about-head">
                    <p class="text-sm font-semibold uppercase tracking-widest" style="color: var(--theme-gradient-from)">{{ $aboutHeading['badge'] }}</p>
                    <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                        {{ $aboutHeading['title'] }} <span class="theme-gradient-text-amber">{{ $aboutHeading['subtitle'] }}</span>
                    </h2>
                    <div class="space-y-4 text-lg leading-relaxed text-muted-foreground">
                        @foreach ($aboutParagraphs as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach ($aboutValues as $value)
                        <div class="card flex gap-4 p-4 card-hover-light"
                             data-reveal data-reveal-group="about-values">
                            <div class="icon-box-sm icon-box shrink-0">
                                <i data-lucide="{{ $value['icon'] }}" style="width:24px;height:24px"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-foreground">{{ $value['title'] }}</h3>
                                <p class="mt-1 text-sm text-muted-foreground">{{ $value['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
