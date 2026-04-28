<header class="site-header sticky top-0 z-50 w-full">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 md:px-6">
        <a href="#top" class="group flex items-center gap-2">
            <span class="text-xl font-bold tracking-tight theme-gradient-text">{{ $headerBrand['title'] }}</span>
            <span class="hidden text-sm sm:inline-block transition-colors text-muted-foreground">{{ $headerBrand['subtitle'] }}</span>
        </a>

        {{-- Desktop nav --}}
        <nav class="hidden items-center gap-1 lg:flex" aria-label="Главная навигация">
            @foreach ($navItems as $item)
                <a href="{{ $item['href'] }}"
                   class="nav-link px-4 py-2 text-sm font-medium text-muted-foreground">{{ $item['label'] }}</a>
            @endforeach
        </nav>

        {{-- Right side desktop --}}
        <div class="hidden lg:flex items-center gap-3">
            <button id="theme-toggle" type="button" class="theme-toggle"
                    aria-label="Переключить тему">
                <i data-lucide="moon" class="icon-moon" style="width:20px;height:20px"></i>
                <i data-lucide="sun"  class="icon-sun"  style="width:20px;height:20px"></i>
            </button>
            <a href="{{ $headerCta['url'] }}" class="btn btn-sm btn-theme">{{ $headerCta['text'] }}</a>
        </div>

        {{-- Mobile right side --}}
        <div class="flex items-center gap-2 lg:hidden">
            <button id="theme-toggle-mobile" type="button" class="theme-toggle"
                    aria-label="Переключить тему"
                    onclick="document.getElementById('theme-toggle').click()">
                <i data-lucide="moon" class="icon-moon" style="width:20px;height:20px"></i>
                <i data-lucide="sun"  class="icon-sun"  style="width:20px;height:20px"></i>
            </button>
            <button id="mobile-open" type="button"
                    class="theme-toggle"
                    aria-label="Открыть меню">
                <i data-lucide="menu" style="width:20px;height:20px"></i>
            </button>
        </div>
    </div>
</header>

{{-- Mobile sheet --}}
<div id="mobile-overlay" class="mobile-overlay" aria-hidden="true"></div>
<aside id="mobile-sheet" class="mobile-sheet" role="dialog" aria-modal="true" aria-label="Мобильное меню">
    <button id="mobile-close" class="close-btn" aria-label="Закрыть меню">
        <i data-lucide="x" style="width:22px;height:22px"></i>
    </button>
    <nav class="mt-6 flex flex-col gap-2" aria-label="Мобильная навигация">
        @foreach ($navItems as $i => $item)
            <a href="{{ $item['href'] }}" class="mobile-link" style="animation-delay: {{ $i * 60 }}ms">{{ $item['label'] }}</a>
        @endforeach
        <a href="{{ $headerCta['url'] }}" class="mobile-cta btn btn-lg btn-theme mt-4 w-full justify-center">{{ $headerCta['text'] }}</a>
    </nav>
</aside>
