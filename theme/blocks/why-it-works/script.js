/**
 * JS for block: why-it-works
 */
document.addEventListener('DOMContentLoaded', () => {
    const swiperContainer = document.querySelector('.why-it-works__swiper');

    if (swiperContainer && typeof Swiper !== 'undefined') {
        new Swiper('.why-it-works__swiper', {
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
                },
                1024: {
                    // Вимикаємо Swiper на Desktop
                    enabled: false,
                    slidesPerView: 5,
                    spaceBetween: 20
                }
            }
        });
    }
});
