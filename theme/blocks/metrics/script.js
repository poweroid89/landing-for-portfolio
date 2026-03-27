/**
 * JS for block: metrics
 */
document.addEventListener('DOMContentLoaded', () => {
    // 1. Ініціалізація Слайдера
    const metricsSwiper = document.querySelector('.metrics__swiper');

    if (metricsSwiper && typeof Swiper !== 'undefined') {
        const sliderGlassBox = document.querySelector('.metrics__col-right');

        new Swiper('.metrics__swiper', {
            slidesPerView: 1.5,   // Показуємо 1 повний + половину наступного
            spaceBetween: 20,     // Відстань між слайдами
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.metrics__swiper-next',
                prevEl: '.metrics__swiper-prev',
            },
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 16 },
                768: { slidesPerView: 1.5, spaceBetween: 20 }
            },
            on: {
                init: function () {
                    // Перевірка стану при старті (про всяк випадок)
                    if (this.isEnd && sliderGlassBox) {
                        sliderGlassBox.classList.add('is-at-end');
                    }
                },
                slideChange: function () {
                    // Динамічний перемикач при скролі
                    if (!sliderGlassBox) return;
                    if (this.isEnd) {
                        sliderGlassBox.classList.add('is-at-end');
                    } else {
                        sliderGlassBox.classList.remove('is-at-end');
                    }
                }
            }
        });
    }

    // 2. Анімація каскадного випадіння карток (Intersection Observer)
    const metricItems = document.querySelectorAll('.metrics__item');

    if (metricItems.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.style.transition = `all 0.6s cubic-bezier(0.16, 1, 0.3, 1) ${entry.target.dataset.delay || 0}s`;
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });

        metricItems.forEach((item, index) => {
            item.dataset.delay = index * 0.15; // Каскадна затримка для карток (150мс кожна)
            observer.observe(item);
        });
    }
});
