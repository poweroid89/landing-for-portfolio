/**
 * JS for block: testimonials
 * Swiper slider — full-width, 100px offset on edges, 2 full + 2 partial slides
 */
document.addEventListener('DOMContentLoaded', () => {
    const testimonialsSwiper = document.querySelector('.testimonials__swiper');

    if (testimonialsSwiper && typeof Swiper !== 'undefined') {
        new Swiper('.testimonials__swiper', {
            slidesPerView: 1,
            spaceBetween: 16,
            grabCursor: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.testimonials__pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.testimonials__swiper-next',
                prevEl: '.testimonials__swiper-prev',
            },
            breakpoints: {
                480: {
                    slidesPerView: 1,
                    spaceBetween: 16,
                },
                768: {
                    slidesPerView: 2.5,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                    slidesOffsetBefore: 100,
                    slidesOffsetAfter: 100,
                },
            },
        });
    }
});
