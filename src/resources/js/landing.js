document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('#service-filter-bar .filter-tab-btn');
    const cards = Array.from(document.querySelectorAll('#service-cards-container .service-card-item'));

    const activeClasses = [
        'bg-primary-container',
        'text-on-primary',
        'shadow-[inset_2px_2px_5px_rgba(0,0,0,0.32),0_4px_12px_rgba(119,85,55,0.22)]',
        'font-bold',
    ];
    const inactiveClasses = [
        'bg-surface',
        'text-on-surface-variant',
        'hover:text-on-surface',
        'shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D0D0D0]',
        'font-semibold',
    ];

    const activeBadgeClasses = ['bg-white/20', 'text-on-primary'];
    const inactiveBadgeClasses = [
        'bg-surface',
        'shadow-[inset_1px_1px_3px_#D2D2D2,inset_-1px_-1px_3px_#FFFFFF]',
        'text-secondary',
    ];

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const filterValue = button.getAttribute('data-filter');

            filterButtons.forEach((btn) => {
                btn.setAttribute('aria-selected', 'false');
                btn.classList.remove(...activeClasses);
                btn.classList.add(...inactiveClasses);

                const badge = btn.querySelector('.filter-badge');
                if (badge) {
                    badge.classList.remove(...activeBadgeClasses);
                    badge.classList.add(...inactiveBadgeClasses);
                }
            });

            button.setAttribute('aria-selected', 'true');
            button.classList.remove(...inactiveClasses);
            button.classList.add(...activeClasses);

            const currentBadge = button.querySelector('.filter-badge');
            if (currentBadge) {
                currentBadge.classList.remove(...inactiveBadgeClasses);
                currentBadge.classList.add(...activeBadgeClasses);
            }

            cards.forEach((card) => {
                const cardCategories = (card.getAttribute('data-categories') || '').split(' ');
                const isMatch = filterValue === 'all' || cardCategories.includes(filterValue);

                if (isMatch) {
                    card.classList.remove('filter-hidden');
                    card.style.display = 'flex';
                    requestAnimationFrame(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                    });
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.94)';
                    setTimeout(() => {
                        if (card.style.opacity === '0') {
                            card.classList.add('filter-hidden');
                            card.style.display = 'none';
                        }
                    }, 240);
                }
            });
        });
    });

    // Prev/Next card highlight controls
    const prevBtn = document.getElementById('service-prev-btn');
    const nextBtn = document.getElementById('service-next-btn');
    let activeCardIndex = -1;

    function highlightCard(index) {
        cards.forEach((c) => {
            c.classList.remove('ring-2', 'ring-primary-container/40', '-translate-y-1');
        });
        if (cards[index]) {
            cards[index].classList.add('ring-2', 'ring-primary-container/40', '-translate-y-1');
            cards[index].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }

    if (prevBtn && nextBtn && cards.length > 0) {
        prevBtn.addEventListener('click', () => {
            activeCardIndex = activeCardIndex <= 0 ? cards.length - 1 : activeCardIndex - 1;
            highlightCard(activeCardIndex);
        });
        nextBtn.addEventListener('click', () => {
            activeCardIndex = (activeCardIndex + 1) % cards.length;
            highlightCard(activeCardIndex);
        });
    }

    // Active section highlight in top navigation
    const navLinks = Array.from(document.querySelectorAll('header nav a[href^="#"]'));
    const sections = navLinks
        .map((link) => {
            const targetId = link.getAttribute('href')?.slice(1);
            return targetId ? { link, el: document.getElementById(targetId) } : null;
        })
        .filter((item) => item && item.el);

    if (sections.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    sections.forEach(({ link, el }) => {
                        const isActive = el === entry.target;
                        link.classList.toggle('text-primary-container', isActive);
                        link.classList.toggle('font-semibold', isActive);
                        link.classList.toggle('text-on-surface-variant', !isActive);
                    });
                });
            },
            { rootMargin: '-35% 0px -55% 0px' },
        );

        sections.forEach(({ el }) => observer.observe(el));
    }
});
