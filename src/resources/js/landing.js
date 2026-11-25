document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Navigation Menu
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (toggleBtn && mobileMenu) {
        const setOpen = (open) => {
            mobileMenu.classList.toggle('hidden', !open);
            toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggleBtn.setAttribute('aria-label', open ? 'Tutup menu navigasi' : 'Buka menu navigasi');
        };

        toggleBtn.addEventListener('click', () => setOpen(mobileMenu.classList.contains('hidden')));
        mobileMenu.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => setOpen(false)));
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                setOpen(false);
                toggleBtn.focus();
            }
        });
    }

    // 2. Active Section Highlight in Navbar (Deep Teal #0F766E)
    const navLinks = Array.from(document.querySelectorAll('header nav a.fh-nav-link[href^="#"]'));
    const sections = navLinks
        .map((link) => {
            const id = link.getAttribute('href')?.slice(1);
            return id && id !== 'top' ? { link, el: document.getElementById(id) } : null;
        })
        .filter((x) => x && x.el);

    const setActive = (activeLink) => {
        navLinks.forEach((link) => {
            if (link === activeLink) {
                link.setAttribute('aria-current', 'page');
                link.classList.add('text-[#0F766E]');
                link.classList.remove('text-[#64748B]');
            } else {
                link.removeAttribute('aria-current');
                link.classList.remove('text-[#0F766E]');
                link.classList.add('text-[#64748B]');
            }
        });
    };

    if (sections.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    const match = sections.find((s) => s.el === entry.target);
                    if (match) setActive(match.link);
                });
            },
            { rootMargin: '-25% 0px -60% 0px' },
        );
        sections.forEach(({ el }) => observer.observe(el));

        const homeLink = navLinks.find((l) => l.getAttribute('href') === '#top');
        if (homeLink) {
            window.addEventListener(
                'scroll',
                () => {
                    if (window.scrollY < 160) setActive(homeLink);
                },
                { passive: true },
            );
        }
    }
});
