/**
 * JS for block: values
 */

document.addEventListener('DOMContentLoaded', () => {
    // Анімація каскадного випадіння карток (Intersection Observer)
    const valueItems = document.querySelectorAll('.values__card');
    
    if (valueItems.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.style.transition = `all 0.6s cubic-bezier(0.16, 1, 0.3, 1) ${entry.target.dataset.delay || 0}s`;
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        valueItems.forEach((item, index) => {
            // Каскадна затримка: кожна наступна картка з'являється на 0.1с пізніше
            item.dataset.delay = index * 0.1;
            observer.observe(item);
        });
    }
});
