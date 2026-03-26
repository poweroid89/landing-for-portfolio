document.addEventListener('DOMContentLoaded', () => {
    /* ── MOBILE MENU ────────────────────────── */
    const burger = document.getElementById('mobile-menu-toggle');
    const closeBtn = document.getElementById('mobile-menu-close');
    const drawer = document.getElementById('mobile-drawer');
    const overlay = document.getElementById('mobile-overlay');
    const body = document.body;

    if (burger && drawer && overlay) {
        const toggleMenu = (show) => {
            drawer.classList.toggle('is-open', show);
            overlay.classList.toggle('is-open', show);
            body.classList.toggle('menu-open', show);
        };

        burger.addEventListener('click', () => toggleMenu(true));
        closeBtn.addEventListener('click', () => toggleMenu(false));
        overlay.addEventListener('click', () => toggleMenu(false));

        // Close on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
                toggleMenu(false);
            }
        });
    }

    /* ── SCROLL REVEAL ───────────────────────── */
    const revealObserver = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                revealObserver.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    /* ── DYNAMIC BACKGROUND GLOWS ─────────────
     * 💡 Чому динамічно, а не хардкодом у HTML:
     *
     * Раніше в header.php було 10 div-ів з фіксованими позиціями
     * і .site-bg мав min-height: 8000px. Це хардкод — якщо
     * сторінка менша за 8000px, є зайвий фон; якщо більша —
     * glow-кола не покривають весь контент.
     *
     * ResizeObserver слідкує за висотою body і автоматично:
     * 1. Встановлює height .site-bg = висоті контенту
     * 2. Генерує glow-кола з кроком ~1600px
     * 3. Чергує ліву та праву сторону
     *
     * Результат: фон завжди покриває рівно стільки, скільки
     * є контенту. Додали нову секцію → фон адаптувався.
     *
     * 💡 Чому ResizeObserver, а не window.resize:
     * ResizeObserver спрацьовує при зміні розміру ЕЛЕМЕНТА,
     * а не тільки вікна. Якщо контент змінився (AJAX, accordion) —
     * glow оновиться. window.resize цього не помітить.
     * ──────────────────────────────────────── */
    const siteBg = document.querySelector('.site-bg');

    if (siteBg) {
        // Конфігурація — синхронізована з _global.scss
        const GLOW_STEP = 1600;     // крок між glow-колами (px)
        const LEFT_START = -200;    // перший лівий glow — top (px)
        const RIGHT_START = 650;    // перший правий glow — top (px)

        /**
         * Генерує glow-кола для однієї сторони (left/right)
         * @param {string} side - 'left' або 'right'
         * @param {number} startTop - початкова позиція top (px)
         * @param {number} pageHeight - висота сторінки (px)
         * @returns {DocumentFragment} — фрагмент з div-ами
         */
        function createGlows(side, startTop, pageHeight) {
            const fragment = document.createDocumentFragment();
            let top = startTop;

            while (top < pageHeight) {
                const glow = document.createElement('div');
                glow.className = `site-bg__glow site-bg__glow--${side}`;
                glow.style.top = `${top}px`;
                fragment.appendChild(glow);
                top += GLOW_STEP;
            }

            return fragment;
        }

        /**
         * Оновлює .site-bg: висоту + кількість glow-кіл
         */
        function updateBackground() {
            const pageHeight = document.documentElement.scrollHeight;

            // 1. Оновлюємо висоту фону
            siteBg.style.height = `${pageHeight}px`;

            // 2. Видаляємо старі glow-кола
            // (querySelectorAll повертає NodeList, forEach працює)
            siteBg.querySelectorAll('.site-bg__glow').forEach(el => el.remove());

            // 3. Генеруємо нові для обох сторін
            siteBg.appendChild(createGlows('left', LEFT_START, pageHeight));
            siteBg.appendChild(createGlows('right', RIGHT_START, pageHeight));
        }

        // Перший запуск
        updateBackground();

        // ResizeObserver на body — слідкуємо за змінами висоти контенту
        const resizeObserver = new ResizeObserver(() => {
            updateBackground();
        });
        resizeObserver.observe(document.body);
    }
});
