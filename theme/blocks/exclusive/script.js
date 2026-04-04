/**
 * JS for block: exclusive
 */
document.addEventListener('DOMContentLoaded', () => {
    const swiperContainer = document.querySelector('.exclusive__swiper');

    if (swiperContainer && typeof Swiper !== 'undefined') {
        new Swiper('.exclusive__swiper', {
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
                },
                1024: {
                    // Turn off Swiper for desktop format
                    enabled: false,
                    slidesPerView: 2, // Desktop columns from grid
                    spaceBetween: 20
                }
            }
        });
    }
});
