<section id="about" class="about-section relative overflow-x-hidden">
    <div class="about-bg"></div>
    @include('landing._floating', ['variant' => 'about'])

    <div class="about-inner relative mx-auto max-w-7xl px-4 md:px-6">

        {{-- Заголовок секции --}}
        <div class="about-header text-center space-y-3" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-widest"
               style="color: var(--theme-gradient-from)">{{ $aboutHeading['badge'] }}</p>
            <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                {{ $aboutHeading['title'] }} <span class="theme-gradient-text-amber">{{ $aboutHeading['subtitle'] }}</span>
            </h2>
        </div>

        @if (!empty($aboutSlides))
        {{-- Полноширинный слайдер: фото слева, текст справа --}}
        <div class="about-slider" id="about-slider" data-reveal>

            <div class="about-slides-track" id="about-track">
                @foreach ($aboutSlides as $i => $slide)
                <div class="about-slide {{ $i === 0 ? 'active' : '' }}">
                    <div class="about-slide-inner">

                        {{-- Фото --}}
                        <div class="about-slide-photo-col">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{ $slide['photo_mobile'] }}">
                                <img src="{{ $slide['photo'] }}"
                                     alt="{{ $slide['title'] }}"
                                     class="about-slide-img"
                                     loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                            </picture>
                        </div>

                        {{-- Текст --}}
                        <div class="about-slide-text-col">
                            <div class="about-slide-icon">
                                <i data-lucide="{{ $slide['icon'] }}" style="width:22px;height:22px"></i>
                            </div>
                            <h3 class="about-slide-title">{{ $slide['title'] }}</h3>
                            <div class="about-slide-body">
                                @foreach (array_filter(array_map('trim', explode("\n\n", $slide['body']))) as $para)
                                    <p>{{ $para }}</p>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <div class="about-slide-counter about-slide-counter--overlay">
                        <span class="about-slide-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="about-slide-total">/ {{ str_pad(count($aboutSlides), 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Навигация --}}
            <div class="about-slider-nav">
                <button class="about-nav-btn" id="about-prev" aria-label="Предыдущий слайд">
                    <i data-lucide="chevron-left" style="width:20px;height:20px"></i>
                </button>
                <div class="about-dots" id="about-dots">
                    @foreach ($aboutSlides as $i => $slide)
                        <button class="about-dot {{ $i === 0 ? 'active' : '' }}"
                                data-idx="{{ $i }}"
                                aria-label="Слайд {{ $i + 1 }}"></button>
                    @endforeach
                </div>
                <button class="about-nav-btn" id="about-next" aria-label="Следующий слайд">
                    <i data-lucide="chevron-right" style="width:20px;height:20px"></i>
                </button>
            </div>

            {{-- Прогресс-бар --}}
            <div class="about-progress-track">
                <div class="about-progress-bar" id="about-progress"></div>
            </div>

        </div>
        @endif

    </div>
</section>

<script>
(function () {
    var slider = document.getElementById('about-slider');
    if (!slider) return;

    var slides   = slider.querySelectorAll('.about-slide');
    var dots     = slider.querySelectorAll('.about-dot');
    var prevBtn  = document.getElementById('about-prev');
    var nextBtn  = document.getElementById('about-next');
    var progress = document.getElementById('about-progress');

    var current  = 0;
    var total    = slides.length;
    var DURATION = 7000;
    var interval = null;
    var hovering = false;

    if (total < 2) return; // один слайд — ничего не делаем

    /* Переключить на слайд idx */
    function goTo(idx) {
        var next = ((idx % total) + total) % total;
        if (next === current) return;

        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = next;
        slides[current].classList.add('active');
        dots[current].classList.add('active');

        restartProgress();
    }

    /* Перезапустить прогресс-бар через CSS-переход */
    function restartProgress() {
        progress.style.transition = 'none';
        progress.style.width = '0%';
        /* Минимальная пауза чтобы браузер применил width:0 до начала transition */
        setTimeout(function () {
            progress.style.transition = 'width ' + DURATION + 'ms linear';
            progress.style.width = '100%';
        }, 30);
    }

    /* Запустить/перезапустить авто-прокрутку */
    function startAuto() {
        clearInterval(interval);
        interval = setInterval(function () {
            if (!hovering) goTo(current + 1);
        }, DURATION);
    }

    /* Навигация с перезапуском таймера */
    function nav(idx) {
        goTo(idx);
        startAuto();
    }

    prevBtn.addEventListener('click', function () { nav(current - 1); });
    nextBtn.addEventListener('click', function () { nav(current + 1); });

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            nav(parseInt(this.getAttribute('data-idx'), 10));
        });
    });

    /* Пауза при наведении: просто флаг, интервал продолжает тикать */
    slider.addEventListener('mouseenter', function () { hovering = true; });
    slider.addEventListener('mouseleave', function () { hovering = false; });

    /* Свайп на тач-устройствах */
    var touchStartX = 0;
    slider.addEventListener('touchstart', function (e) {
        touchStartX = e.touches[0].clientX;
    }, { passive: true });
    slider.addEventListener('touchend', function (e) {
        var diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) nav(current + (diff > 0 ? 1 : -1));
    }, { passive: true });

    /* Инициализация */
    restartProgress();
    startAuto();
})();
</script>
