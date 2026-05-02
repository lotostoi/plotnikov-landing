@php
    $colsClass    = 'services-grid--' . (in_array($serviceCardCols ?? '3', ['1', '2', '3']) ? ($serviceCardCols ?? '3') : '3');
    $variantClass = ($serviceCardVariant ?? 'default') !== 'default' ? ' issue-card--' . e($serviceCardVariant) : '';
@endphp

<section id="services" class="relative overflow-hidden py-20 md:py-28">
    <div class="services-bg"></div>
    @include('landing._floating', ['variant' => 'services'])

    <div class="relative mx-auto max-w-7xl px-4 md:px-6">
        <div class="mx-auto mb-16 max-w-2xl space-y-4 text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-widest" style="color: var(--theme-gradient-from)">{{ $serviceHeading['badge'] }}</p>
            <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                {{ $serviceHeading['title'] }} <span class="theme-gradient-text-amber">{{ $serviceHeading['subtitle'] }}</span>
            </h2>
            <p class="text-lg text-muted-foreground">{{ $serviceHeading['description'] }}</p>
        </div>

        <div class="mb-20 grid gap-5 services-grid {{ $colsClass }}">
            @foreach ($serviceIssues as $i => $issue)
                <article class="issue-card{{ $variantClass }}"
                         data-accent="{{ $issue['accent'] }}"
                         data-reveal data-reveal-group="services-issues">

                    {{-- Фоновое число --}}
                    <span class="issue-card__num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>

                    {{-- Иконка --}}
                    <div class="issue-card__icon">
                        <i data-lucide="{{ $issue['icon'] }}" style="width:26px;height:26px"></i>
                    </div>

                    {{-- Контент --}}
                    <h3 class="issue-card__title">{{ $issue['title'] }}</h3>
                    <p class="issue-card__body">{{ $issue['description'] }}</p>

                    {{-- Декоративная полоска снизу --}}
                    <span class="issue-card__line"></span>
                </article>
            @endforeach
        </div>

    </div>
</section>
