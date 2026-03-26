/**
 * JS for block: hero
 */
const initHeroCounter = () => {
    const cards = document.querySelectorAll('.hero-block .hero__stat-card');
    if (!cards.length) return;

    // Форматування числа з пробілами: 10000 -> 10 000
    const formatNumber = (num) => {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    };

    const animateCounter = (el) => {
        if (el.dataset.animated) return;
        
        const rawValue = el.getAttribute('data-value').trim(); 
        
        const justNumbers = rawValue.replace(/[^\d]/g, '');
        if (!justNumbers) return;
        const targetValue = parseInt(justNumbers, 10);
        
        const suffixMatch = rawValue.match(/[^\d\s]+$/);
        const suffix = suffixMatch ? suffixMatch[0] : '';

        // Згідно з твоїм варіантом, фіксуємо 1.4 секунди
        const duration = 1400; 
        const startTime = performance.now();

        const updateCounter = (currentTime) => {
            const elapsedTime = currentTime - startTime;
            const progress = Math.min(elapsedTime / duration, 1);
            
            // Формула плавності: 1 - (1 - p)^3
            const easeProgress = 1 - Math.pow(1 - progress, 3);
            
            // Натуральне поступове зростання без примусового заокруглення
            let currentNum = Math.round(targetValue * easeProgress);

            el.textContent = formatNumber(currentNum) + suffix;

            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                el.textContent = formatNumber(targetValue) + suffix; 
                el.dataset.animated = 'true'; 
            }
        };

        requestAnimationFrame(updateCounter);
    };

    // Відслідковуємо появу КАРТОК (включаємо їм класи із затримкою)
    const countObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const card = entry.target;
                if (!card.dataset.animated) {
                    card.dataset.animated = 'true';
                    
                    // Визначаємо затримку згідно з твоїм макетом 
                    // (0.1s, 0.28s, 0.46s -> 100, 280, 460 ms)
                    let delay = 100;
                    if (card.classList.contains('hero__stat-card--2')) delay = 280;
                    if (card.classList.contains('hero__stat-card--3')) delay = 460;

                    setTimeout(() => {
                        card.classList.add('is-visible'); // Додаємо клас для FadeUp
                        
                        // Зразу ж після початку появи картки — запускаємо цифри
                        const trigger = card.querySelector('.js-counter-trigger');
                        if (trigger) animateCounter(trigger);
                    }, delay);
                    
                    observer.unobserve(card);
                }
            }
        });
    }, { threshold: 0.1 }); 

    cards.forEach(card => {
        if (!card.dataset.animated) {
            countObserver.observe(card);
        }
    });
};

// Запуск на фронтенді (перевіряємо, чи DOM вже завантажено)
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeroCounter);
} else {
    initHeroCounter();
}

// Запуск в адмінці Gutenberg (ACF Block Preview)
if (window.acf) {
    window.acf.addAction('render_block_preview/type=hero', initHeroCounter);
}
