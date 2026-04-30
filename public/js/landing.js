/* ======================================================================
   Landing — единая интерактивность: тема, мобильное меню, FAQ,
   reveal-on-scroll, шапка при прокрутке, lucide-иконки.
   ====================================================================== */

(() => {
    'use strict';

    const root = document.documentElement;

    // ---------- Тема ----------
    const THEME_KEY = 'theme';
    const validThemes = new Set(['warm', 'dark']);

    const applyTheme = (theme) => {
        if (!validThemes.has(theme)) return;
        root.setAttribute('data-theme', theme);
        try { localStorage.setItem(THEME_KEY, theme); } catch (_) { /* ignore */ }
    };

    const initTheme = () => {
        let saved = null;
        try { saved = localStorage.getItem(THEME_KEY); } catch (_) { /* ignore */ }
        const defaultThemeAttr = root.getAttribute('data-default-theme');
        const fallback = validThemes.has(defaultThemeAttr) ? defaultThemeAttr : 'warm';

        if (validThemes.has(saved)) {
            applyTheme(saved);
        } else if (root.getAttribute('data-theme') == null) {
            applyTheme(fallback);
        }
    };

    const initThemeToggle = () => {
        const btn = document.getElementById('theme-toggle');
        if (!btn) return;
        btn.addEventListener('click', () => {
            const current = root.getAttribute('data-theme') === 'dark' ? 'dark' : 'warm';
            applyTheme(current === 'dark' ? 'warm' : 'dark');
        });
    };

    // ---------- Шапка при прокрутке ----------
    const initHeaderScroll = () => {
        const header = document.querySelector('.site-header');
        if (!header) return;
        let ticking = false;
        const update = () => {
            if (window.scrollY > 20) header.classList.add('scrolled');
            else header.classList.remove('scrolled');
            ticking = false;
        };
        update();
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(update);
                ticking = true;
            }
        }, { passive: true });
    };

    // ---------- Мобильное меню ----------
    const initMobileSheet = () => {
        const overlay = document.getElementById('mobile-overlay');
        const sheet = document.getElementById('mobile-sheet');
        const open = document.getElementById('mobile-open');
        const close = document.getElementById('mobile-close');
        if (!overlay || !sheet) return;

        const setOpen = (state) => {
            overlay.classList.toggle('open', state);
            sheet.classList.toggle('open', state);
            document.body.style.overflow = state ? 'hidden' : '';
            if (state) {
                const links = sheet.querySelectorAll('.mobile-link');
                links.forEach((el, i) => {
                    el.style.animation = 'none';
                    void el.offsetWidth;
                    el.style.animation = '';
                    el.style.animationDelay = (i * 60) + 'ms';
                });
            }
        };

        open?.addEventListener('click', () => setOpen(true));
        close?.addEventListener('click', () => setOpen(false));
        overlay.addEventListener('click', () => setOpen(false));
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') setOpen(false);
        });
        sheet.querySelectorAll('.mobile-link, .mobile-cta').forEach((el) => {
            el.addEventListener('click', () => setOpen(false));
        });
    };

    // ---------- FAQ accordion ----------
    const initFaq = () => {
        const items = document.querySelectorAll('.faq-item');
        items.forEach((item) => {
            const trigger = item.querySelector('.faq-trigger');
            const content = item.querySelector('.faq-content');
            if (!trigger || !content) return;

            trigger.addEventListener('click', () => {
                const opening = !item.classList.contains('open');
                items.forEach((other) => {
                    if (other !== item) {
                        other.classList.remove('open');
                        const otherContent = other.querySelector('.faq-content');
                        if (otherContent) otherContent.style.maxHeight = '0px';
                    }
                });

                if (opening) {
                    item.classList.add('open');
                    content.style.maxHeight = content.scrollHeight + 'px';
                } else {
                    item.classList.remove('open');
                    content.style.maxHeight = '0px';
                }
            });
        });

        window.addEventListener('resize', () => {
            document.querySelectorAll('.faq-item.open').forEach((item) => {
                const content = item.querySelector('.faq-content');
                if (content) content.style.maxHeight = content.scrollHeight + 'px';
            });
        });
    };

    // ---------- Reveal-on-scroll со stagger ----------
    const initReveal = () => {
        const targets = document.querySelectorAll('[data-reveal]');
        if (!targets.length) return;

        const reveal = (el) => {
            el.classList.add('is-revealed');
        };

        /* Hero (#top): сразу видимый — блок у низа экрана с отрицательным rootMargin часто не пересекает root, остаётся opacity:0 */
        document.querySelectorAll('#top [data-reveal]').forEach(reveal);

        if (!('IntersectionObserver' in window)) {
            targets.forEach(reveal);
            return;
        }

        const groupCounters = new Map();

        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const groupKey = el.getAttribute('data-reveal-group');
                let delay = parseInt(el.getAttribute('data-reveal-delay') || '0', 10);
                if (groupKey) {
                    const idx = groupCounters.get(groupKey) || 0;
                    delay += idx * 90;
                    groupCounters.set(groupKey, idx + 1);
                }
                el.style.transitionDelay = delay + 'ms';
                reveal(el);
                io.unobserve(el);
            });
        }, { threshold: 0.06, rootMargin: '0px 0px 0px 0px' });

        targets.forEach((el) => {
            if (el.closest('#top')) return;
            io.observe(el);
        });
    };

    // ---------- Smooth scroll к якорям с учётом sticky-шапки ----------
    const initSmoothAnchors = () => {
        document.querySelectorAll('a[href^="#"]').forEach((a) => {
            a.addEventListener('click', (e) => {
                const href = a.getAttribute('href');
                if (!href || href === '#' || href.length < 2) return;
                const target = document.querySelector(href);
                if (!target) return;
                e.preventDefault();
                const headerH = document.querySelector('.site-header')?.offsetHeight || 0;
                const top = target.getBoundingClientRect().top + window.scrollY - headerH - 8;
                window.scrollTo({ top, behavior: 'smooth' });
            });
        });
    };

    // ---------- Иконки lucide ----------
    const initIcons = () => {
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons();
        }
    };

    // Инициализируем тему как можно раньше, чтобы избежать вспышки
    initTheme();

    document.addEventListener('DOMContentLoaded', () => {
        initThemeToggle();
        initHeaderScroll();
        initMobileSheet();
        initFaq();
        initReveal();
        initSmoothAnchors();
        initIcons();
    });
})();
