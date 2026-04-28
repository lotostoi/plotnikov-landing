<section id="education" class="relative overflow-hidden py-20 md:py-28 bg-secondary">
    <div class="glow glow-theme glow-pulse-theme"
         style="top:25%; right:0; width:20rem; height:20rem; z-index:0;"></div>

    <div class="relative mx-auto max-w-7xl px-4 md:px-6">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            {{-- Контент --}}
            <div class="flex flex-col justify-center space-y-8">
                <div class="space-y-4" data-reveal>
                    <p class="text-sm font-semibold uppercase tracking-widest theme-gradient-text">{{ $educationHeading['badge'] }}</p>
                    <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                        {{ $educationHeading['title'] }} <span class="theme-gradient-text">{{ $educationHeading['subtitle'] }}</span>
                    </h2>
                </div>

                <div class="space-y-4">
                @foreach ($educationItems as $item)
                    <div class="card card-hover-light flex gap-4 p-5"
                         style="border: 1px solid var(--border)"
                         data-reveal data-reveal-group="education-list">
                        <div class="icon-box icon-box-sm shrink-0">
                            <i data-lucide="{{ $item['icon'] }}" style="width:24px;height:24px"></i>
                        </div>
                            <div class="space-y-1">
                                <h3 class="font-semibold text-foreground">{{ $item['title'] }}</h3>
                                <p class="text-sm text-muted-foreground">{{ $item['institution'] }}</p>
                                @if ($item['status'] === 'Завершено')
                                    <span class="inline-block rounded-full px-3 py-1 text-xs font-medium text-white theme-gradient">{{ $item['status'] }}</span>
                                @else
                                    <span class="inline-block rounded-full px-3 py-1 text-xs font-medium theme-accent-light text-foreground">{{ $item['status'] }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-2 gap-4">
                    @foreach ($experienceItems as $item)
                        <div class="card card-hover-light p-5 text-center"
                             style="border: 1px solid var(--border)"
                             data-reveal data-reveal-group="education-stats">
                        <div class="mb-3 flex justify-center">
                            <div class="icon-box icon-box-sm">
                                <i data-lucide="{{ $item['icon'] }}" style="width:22px;height:22px"></i>
                            </div>
                        </div>
                            <p class="text-3xl font-bold theme-gradient-text">{{ $item['value'] }}</p>
                            <p class="mt-1 text-sm font-semibold text-foreground">{{ $item['label'] }}</p>
                            <p class="text-xs text-muted-foreground">{{ $item['description'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-4" data-reveal>
                    <h3 class="font-semibold text-foreground">Подходы в работе:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($approaches as $i => $approach)
                            <span class="approach-pill" style="transition-delay: {{ $i * 80 }}ms"
                                  data-reveal="scale" data-reveal-group="education-approaches">{{ $approach }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Изображение --}}
            <div class="relative mx-auto w-full max-w-md lg:max-w-none" data-reveal="right">
                <div class="photo-frame aspect-[3/4]">
                    <img src="{{ $images['education'] }}" alt="Александр с книгой 'Путешествие в гештальт'" loading="lazy">
                </div>
                <div class="glow glow-theme"
                     style="bottom:-1.5rem; left:-1.5rem; width:66%; height:66%; z-index:-1; opacity:.2;"></div>
            </div>
        </div>
    </div>
</section>
