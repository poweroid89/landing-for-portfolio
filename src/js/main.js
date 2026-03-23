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
});

