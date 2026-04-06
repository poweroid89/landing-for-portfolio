/**
 * JS for block: why-it-works
 */
document.addEventListener('DOMContentLoaded', () => {
    const swiperContainer = document.querySelector('.why-it-works__swiper');

    if (swiperContainer && typeof Swiper !== 'undefined') {
        let swiperInstance = null;
        const mediaQuery = window.matchMedia('(max-width: 1023px)');

        const initOrDestroySwiper = (e) => {
            if (e.matches) {
                // Мобільна версія (<1024px) - ініціалізуємо Swiper
                if (!swiperInstance) {
                    swiperInstance = new Swiper('.why-it-works__swiper', {
                        slidesPerView: 1,
                        spaceBetween: 16,
                        grabCursor: true,
                        pagination: {
                            el: '.why-it-works__pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            480: {
                                slidesPerView: 1,
                                spaceBetween: 16
                            },
                            768: {
                                slidesPerView: 2,
                                spaceBetween: 20
                            }
                        }
                    });
                }
            } else {
                // Десктоп (>=1024px) - повністю знищуємо Swiper
                if (swiperInstance) {
                    // true, true: видаляє всі inline-стилі (ширину, трансформи і тд)
                    swiperInstance.destroy(true, true);
                    swiperInstance = null;
                }
            }
        };

        // Запуск при завантаженні сторінки
        initOrDestroySwiper(mediaQuery);

        // Слухач події на проходження брейкпоінту (набагато економніше для продуктивності ніж звичайний resize)
        mediaQuery.addEventListener('change', initOrDestroySwiper);
    }
});
