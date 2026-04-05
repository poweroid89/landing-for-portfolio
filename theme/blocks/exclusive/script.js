/**
 * JS for block: exclusive
 */
document.addEventListener('DOMContentLoaded', () => {
    const swiperContainer = document.querySelector('.exclusive__swiper');

    if (swiperContainer && typeof Swiper !== 'undefined') {
        let swiperInstance = null;
        const mediaQuery = window.matchMedia('(max-width: 1023px)');

        const initOrDestroySwiper = (e) => {
            if (e.matches) {
                if (!swiperInstance) {
                    swiperInstance = new Swiper('.exclusive__swiper', {
                        slidesPerView: 1, // Full slides on mobile
                        spaceBetween: 16,
                        grabCursor: true,
                        pagination: {
                            el: '.exclusive__pagination',
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
                if (swiperInstance) {
                    swiperInstance.destroy(true, true);
                    swiperInstance = null;
                }
            }
        };

        initOrDestroySwiper(mediaQuery);
        mediaQuery.addEventListener('change', initOrDestroySwiper);
    }
});
