<section id="education" class="relative overflow-hidden py-20 md:py-28 bg-secondary">
    <div class="glow glow-theme glow-pulse-theme"
         style="top:25%; right:0; width:20rem; height:20rem; z-index:0;"></div>

    <div class="relative mx-auto max-w-7xl px-4 md:px-6">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">

            {{-- Левая колонка: весь контент --}}
            <div class="flex flex-col justify-center space-y-10">

                {{-- Заголовок --}}
                <div class="space-y-4" data-reveal>
                    <p class="text-sm font-semibold uppercase tracking-widest theme-gradient-text">{{ $educationHeading['badge'] }}</p>
                    <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                        {{ $educationHeading['title'] }} <span class="theme-gradient-text">{{ $educationHeading['subtitle'] }}</span>
                    </h2>
                </div>

                {{-- Карточки учебных заведений --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @foreach ($educationItems as $i => $item)
                    <div class="edu-card"
                         data-accent="{{ $item['accent'] }}"
                         data-reveal data-reveal-group="education-list">

                        {{-- Иконка --}}
                        <div class="edu-card__icon">
                            <i data-lucide="{{ $item['icon'] }}" style="width:24px;height:24px"></i>
                        </div>

                        {{-- Текст --}}
                        <div class="edu-card__content">
                            <div class="edu-card__meta">
                                <span class="edu-card__status {{ $item['status'] === 'Завершено' ? 'edu-card__status--done' : 'edu-card__status--progress' }}">
                                    <i data-lucide="{{ $item['status'] === 'Завершено' ? 'check-circle' : 'clock' }}" style="width:13px;height:13px"></i>
                                    {{ $item['status'] }}
                                </span>
                            </div>
                            <h3 class="edu-card__title">{{ $item['title'] }}</h3>
                            <p class="edu-card__institution">{{ $item['institution'] }}</p>

                            @if (!empty($item['certs']))
                            <button class="edu-card__cert-btn"
                                    data-certs="{{ json_encode($item['certs']) }}"
                                    data-title="{{ $item['title'] }}"
                                    onclick="openEduLightbox(this)">
                                <i data-lucide="file-text" style="width:15px;height:15px"></i>
                                Смотреть документы
                                <i data-lucide="chevron-right" style="width:14px;height:14px"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Опыт: числовые статы --}}
                @if (!empty($experienceItems))
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($experienceItems as $item)
                    <div class="edu-stat-card" data-reveal data-reveal-group="education-stats">
                        <div class="edu-stat-card__icon">
                            <i data-lucide="{{ $item['icon'] }}" style="width:20px;height:20px"></i>
                        </div>
                        <p class="edu-stat-card__value">{{ $item['value'] }}</p>
                        <p class="edu-stat-card__label">{{ $item['label'] }}</p>
                        <p class="edu-stat-card__desc">{{ $item['description'] }}</p>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Подходы --}}
                @if (!empty($approaches))
                <div class="space-y-3" data-reveal>
                    <p class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Подходы в работе</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($approaches as $i => $approach)
                            <span class="approach-pill"
                                  style="transition-delay: {{ $i * 80 }}ms"
                                  data-reveal="scale" data-reveal-group="education-approaches">{{ $approach }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Фото --}}
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

{{-- Лайтбокс сертификатов --}}
<div id="edu-lightbox" class="edu-lightbox" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="edu-lightbox__backdrop" onclick="closeEduLightbox()"></div>
    <div class="edu-lightbox__box">
        <button class="edu-lightbox__close" onclick="closeEduLightbox()" aria-label="Закрыть">
            <i data-lucide="x" style="width:22px;height:22px"></i>
        </button>
        <p class="edu-lightbox__title" id="edu-lb-title"></p>
        <div class="edu-lightbox__stage">
            <button class="edu-lightbox__arrow edu-lightbox__arrow--prev" id="edu-lb-prev" onclick="eduLbNav(-1)" aria-label="Назад">
                <i data-lucide="chevron-left" style="width:24px;height:24px"></i>
            </button>
            <img class="edu-lightbox__img" id="edu-lb-img" src="" alt="">
            <button class="edu-lightbox__arrow edu-lightbox__arrow--next" id="edu-lb-next" onclick="eduLbNav(1)" aria-label="Вперёд">
                <i data-lucide="chevron-right" style="width:24px;height:24px"></i>
            </button>
        </div>
        <p class="edu-lightbox__counter" id="edu-lb-counter"></p>
    </div>
</div>

<script>
(function () {
    var lb      = document.getElementById('edu-lightbox');
    var lbImg   = document.getElementById('edu-lb-img');
    var lbTitle = document.getElementById('edu-lb-title');
    var lbCount = document.getElementById('edu-lb-counter');
    var lbPrev  = document.getElementById('edu-lb-prev');
    var lbNext  = document.getElementById('edu-lb-next');
    var _certs  = [];
    var _cur    = 0;

    window.openEduLightbox = function (btn) {
        _certs = JSON.parse(btn.getAttribute('data-certs') || '[]');
        if (!_certs.length) return;
        _cur = 0;
        lbTitle.textContent = btn.getAttribute('data-title') || '';
        lb.setAttribute('aria-hidden', 'false');
        lb.classList.add('open');
        document.body.style.overflow = 'hidden';
        renderLb();
    };

    window.closeEduLightbox = function () {
        lb.setAttribute('aria-hidden', 'true');
        lb.classList.remove('open');
        document.body.style.overflow = '';
    };

    window.eduLbNav = function (dir) {
        _cur = (_cur + dir + _certs.length) % _certs.length;
        renderLb();
    };

    function renderLb() {
        lbImg.src = _certs[_cur];
        lbCount.textContent = (_cur + 1) + ' / ' + _certs.length;
        lbPrev.style.display = _certs.length > 1 ? '' : 'none';
        lbNext.style.display = _certs.length > 1 ? '' : 'none';
    }

    document.addEventListener('keydown', function (e) {
        if (!lb.classList.contains('open')) return;
        if (e.key === 'Escape') closeEduLightbox();
        if (e.key === 'ArrowLeft') eduLbNav(-1);
        if (e.key === 'ArrowRight') eduLbNav(1);
    });
})();
</script>
