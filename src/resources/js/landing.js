document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!prefersReducedMotion) {
        document.documentElement.classList.add('fh-anim-ready');
    }

    // 0. Hero Initial Load & Replayable Restart Entrance Animation
    const headerAnimEl = document.querySelector('.fh-header-anim');
    const heroBgEl = document.querySelector('.fh-hero-bg');
    const heroAnimItems = Array.from(document.querySelectorAll('.fh-hero-anim'));

    heroAnimItems.forEach((el, idx) => {
        const step = parseInt(el.getAttribute('data-hero-step') || String(idx + 1), 10);
        el.style.setProperty('--hero-delay', `${step * 85}ms`);
    });

    const playHeroEntrance = () => {
        if (prefersReducedMotion) return;

        // Reset to initial state cleanly without transition flicker
        const targets = [headerAnimEl, heroBgEl, ...heroAnimItems].filter(Boolean);
        targets.forEach((el) => {
            el.style.transition = 'none';
            el.classList.remove('is-entered');
        });

        // Force reflow, then trigger smooth staggered entrance
        void document.body.offsetHeight;
        targets.forEach((el) => {
            el.style.transition = '';
        });

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                targets.forEach((el) => el.classList.add('is-entered'));
            });
        });
    };

    playHeroEntrance();
    window.addEventListener('pageshow', (e) => {
        if (e.persisted) playHeroEntrance();
    });

    // 0B. Smooth Scroll Reveal (sections & cards appear only when scrolled into view)
    const revealSections = Array.from(document.querySelectorAll('[data-reveal]'));
    revealSections.forEach((section) => {
        const cards = Array.from(section.querySelectorAll('.stitch-surface-card'));
        cards.forEach((card, idx) => {
            card.style.setProperty('--card-delay', `${Math.min(idx, 6) * 70}ms`);
        });
    });

    if (revealSections.length > 0 && !prefersReducedMotion && 'IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1, rootMargin: '0px 0px -60px 0px' },
        );
        revealSections.forEach((sec) => revealObserver.observe(sec));
    } else {
        revealSections.forEach((sec) => sec.classList.add('is-visible'));
    }

    // 1. Mobile & Tablet Navigation Menu
    const headerEl = document.getElementById('site-header');
    const headerPillBar = document.getElementById('header-pill-bar');
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('mobile-menu-icon');

    let setMobileMenuOpen = () => {};

    if (toggleBtn && mobileMenu) {
        setMobileMenuOpen = (open) => {
            mobileMenu.classList.toggle('hidden', !open);
            toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggleBtn.setAttribute('aria-label', open ? 'Tutup menu navigasi' : 'Buka menu navigasi');
            if (menuIcon) menuIcon.textContent = open ? 'close' : 'menu';
        };

        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            setMobileMenuOpen(mobileMenu.classList.contains('hidden'));
        });

        mobileMenu.querySelectorAll('a').forEach((a) => {
            a.addEventListener('click', () => setMobileMenuOpen(false));
        });

        document.addEventListener('click', (e) => {
            if (!mobileMenu.classList.contains('hidden') && headerEl && !headerEl.contains(e.target)) {
                setMobileMenuOpen(false);
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                setMobileMenuOpen(false);
                toggleBtn.focus();
            }
        });
    }

    // Dynamic Island: shrink header pill to center on scroll, expand smoothly on hover/focus
    const compactLabelEl = document.getElementById('header-compact-label');
    let isHeaderHovered = false;
    let collapseTimer = null;

    const sectionTitles = {
        beranda: 'Beranda',
        'layanan-populer': 'Layanan',
        'katalog-teknisi': 'Teknisi',
        'cara-kerja': 'Cara Kerja',
        'jadi-mitra': 'Jadi Mitra',
        'tentang-kami': 'Tentang Kami',
    };

    const syncHeaderCompactState = () => {
        if (!headerPillBar) return;
        const isDesktop = window.innerWidth >= 768;
        const isMenuOpen = mobileMenu && !mobileMenu.classList.contains('hidden');
        const shouldCompact = isDesktop && window.scrollY > 90 && !isHeaderHovered && !isMenuOpen;
        const wasCompact = headerPillBar.classList.contains('is-compact');

        headerPillBar.classList.toggle('is-compact', shouldCompact);
        headerPillBar.classList.toggle('shadow-[0_10px_32px_rgba(17,24,39,0.12)]', window.scrollY > 12 && !shouldCompact);

        // Re-align sliding nav pill smoothly once expanded back from compact mode
        if (wasCompact && !shouldCompact) {
            setTimeout(() => alignActiveNavPill(false), 340);
        }
    };

    if (headerPillBar) {
        headerPillBar.addEventListener('mouseenter', () => {
            if (collapseTimer) {
                clearTimeout(collapseTimer);
                collapseTimer = null;
            }
            isHeaderHovered = true;
            syncHeaderCompactState();
        });

        headerPillBar.addEventListener('mouseleave', () => {
            if (collapseTimer) clearTimeout(collapseTimer);
            collapseTimer = setTimeout(() => {
                isHeaderHovered = false;
                syncHeaderCompactState();
            }, 180);
        });

        headerPillBar.addEventListener('focusin', () => {
            isHeaderHovered = true;
            syncHeaderCompactState();
        });

        headerPillBar.addEventListener('focusout', (e) => {
            if (!headerPillBar.contains(e.relatedTarget)) {
                isHeaderHovered = false;
                syncHeaderCompactState();
            }
        });

        window.addEventListener('scroll', syncHeaderCompactState, { passive: true });
        window.addEventListener('resize', syncHeaderCompactState);
    }

    // 2. Interactive Pricing & 95/5 Split Simulator (matches Transaksi::calculateSplit)
    const serviceSelect = document.getElementById('calc-service');
    const distButtons = Array.from(document.querySelectorAll('.calc-dist-btn'));
    const elBase = document.getElementById('calc-base');
    const elDist = document.getElementById('calc-distance');
    const elTotal = document.getElementById('calc-total');
    const elTech = document.getElementById('calc-tech');
    const elFee = document.getElementById('calc-fee');

    if (serviceSelect && distButtons.length > 0 && elTotal) {
        let distanceMode = 'near';

        const formatIdr = (amount) => 'Rp' + Math.round(amount).toLocaleString('id-ID');

        const recalc = () => {
            const base = parseInt(serviceSelect.value, 10) || 75000;
            const distFee = distanceMode === 'far' ? 10000 : 0;
            const total = base + distFee;
            const adminFee = Math.round(total * 0.05);
            const techShare = total - adminFee;

            if (elBase) elBase.textContent = formatIdr(base);
            if (elDist) elDist.textContent = formatIdr(distFee);
            if (elTotal) elTotal.textContent = formatIdr(total);
            if (elTech) elTech.textContent = formatIdr(techShare);
            if (elFee) elFee.textContent = formatIdr(adminFee);
        };

        serviceSelect.addEventListener('change', recalc);
        distButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                distanceMode = btn.getAttribute('data-distance') || 'near';
                distButtons.forEach((b) => b.classList.toggle('is-active', b === btn));
                recalc();
            });
        });

        recalc();
    }

    // 3. Multi-Page Active Pill Indicator & Smooth Page Transitions
    const desktopNav = document.getElementById('desktop-nav');
    const navPill = document.getElementById('nav-active-pill');
    const pageStage = document.querySelector('.fh-page-stage');
    const desktopNavLinks = desktopNav
        ? Array.from(desktopNav.querySelectorAll('.fh-nav-link'))
        : [];
    const activePageKey = document.body.getAttribute('data-active-page') || 'beranda';
    let currentActiveId = activePageKey;

    const moveNavPillTo = (targetLink, { animate = true, pop = false } = {}) => {
        if (!navPill || !desktopNav || !targetLink) return;
        const navRect = desktopNav.getBoundingClientRect();
        const linkRect = targetLink.getBoundingClientRect();
        if (linkRect.width === 0) return;

        if (!animate) {
            navPill.classList.add('is-no-anim');
        }

        const offsetX = linkRect.left - navRect.left;
        navPill.style.width = `${linkRect.width}px`;
        navPill.style.transform = `translate3d(${offsetX}px, 0, 0)`;
        navPill.style.opacity = '1';

        if (!animate) {
            void navPill.offsetWidth;
            navPill.classList.remove('is-no-anim');
        } else if (pop) {
            navPill.classList.remove('is-popping');
            void navPill.offsetWidth;
            navPill.classList.add('is-popping');
        }
    };

    const alignActiveNavPill = (animate = false) => {
        const activeLink =
            desktopNavLinks.find((l) => l.getAttribute('data-nav-key') === currentActiveId) ||
            desktopNavLinks.find((l) => l.getAttribute('aria-current') === 'page');
        if (activeLink) {
            moveNavPillTo(activeLink, { animate });
        }
    };

    // Smooth page transition on multi-page navbar/footer links
    document.querySelectorAll('a.fh-page-link').forEach((link) => {
        link.addEventListener('click', (e) => {
            if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#')) return;

            const destUrl = new URL(href, window.location.origin);
            if (destUrl.origin !== window.location.origin) return;

            // Clicking the current page scrolls smoothly to top & replays hero entrance
            if (destUrl.pathname === window.location.pathname && destUrl.search === window.location.search) {
                e.preventDefault();
                setMobileMenuOpen(false);
                window.scrollTo({ top: 0, behavior: 'smooth' });
                setTimeout(() => playHeroEntrance(), 200);
                return;
            }

            if (prefersReducedMotion) return;

            e.preventDefault();
            setMobileMenuOpen(false);

            // Immediately glide the desktop pill to the clicked nav item for tactile feedback
            const clickedKey = link.getAttribute('data-nav-key');
            if (clickedKey) {
                const targetDesktopLink = desktopNavLinks.find((l) => l.getAttribute('data-nav-key') === clickedKey);
                if (targetDesktopLink) {
                    desktopNavLinks.forEach((l) => {
                        const match = l === targetDesktopLink;
                        l.classList.toggle('text-[#15803D]', match);
                        l.classList.toggle('font-semibold', match);
                        l.classList.toggle('text-[#4B5563]', !match);
                    });
                    moveNavPillTo(targetDesktopLink, { animate: true, pop: true });
                }
            }

            if (pageStage) {
                pageStage.classList.add('is-leaving');
            }

            setTimeout(() => {
                window.location.href = destUrl.href;
            }, 190);
        });
    });

    window.addEventListener('pageshow', () => {
        if (pageStage) pageStage.classList.remove('is-leaving');
        alignActiveNavPill(false);
    });

    window.addEventListener('resize', () => alignActiveNavPill(false));

    alignActiveNavPill(false);
    syncHeaderCompactState();
    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(() => alignActiveNavPill(false));
    }
});
