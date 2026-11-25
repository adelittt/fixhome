document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile & Tablet Navigation Menu
    const headerEl = document.getElementById('site-header');
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

    // Subtle header shadow on scroll
    if (headerEl) {
        const updateHeaderShadow = () => {
            headerEl.classList.toggle('shadow-sm', window.scrollY > 8);
        };
        updateHeaderShadow();
        window.addEventListener('scroll', updateHeaderShadow, { passive: true });
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

    // 3. Responsive Active Header State (Sliding Spring Pill + Instant Click + Scrollspy)
    const desktopNav = document.getElementById('desktop-nav');
    const navPill = document.getElementById('nav-active-pill');
    const desktopNavLinks = desktopNav
        ? Array.from(desktopNav.querySelectorAll('.fh-nav-link[data-nav-target]'))
        : [];
    const mobileNavLinks = mobileMenu
        ? Array.from(mobileMenu.querySelectorAll('.fh-nav-link[data-nav-target]'))
        : [];
    const bottomLinks = Array.from(document.querySelectorAll('.fh-bottom-link[data-nav-target]'));
    const allTargetTriggers = Array.from(document.querySelectorAll('a[data-nav-target]'));

    let currentActiveId = 'beranda';

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
            // Force reflow then re-enable spring transition
            void navPill.offsetWidth;
            navPill.classList.remove('is-no-anim');
        } else if (pop) {
            navPill.classList.remove('is-popping');
            void navPill.offsetWidth;
            navPill.classList.add('is-popping');
        }
    };

    const setActiveSection = (targetId, { animatePill = true, popPill = false } = {}) => {
        currentActiveId = targetId;

        let activeDesktopLink = null;
        desktopNavLinks.forEach((link) => {
            const isActive = link.getAttribute('data-nav-target') === targetId;
            if (isActive) {
                activeDesktopLink = link;
                link.setAttribute('aria-current', 'page');
                link.classList.add('text-[#15803D]', 'font-semibold');
                link.classList.remove('text-[#4B5563]', 'hover:text-[#111827]');
            } else {
                link.removeAttribute('aria-current');
                link.classList.remove('text-[#15803D]', 'font-semibold');
                link.classList.add('text-[#4B5563]', 'hover:text-[#111827]');
            }
        });

        if (activeDesktopLink) {
            moveNavPillTo(activeDesktopLink, { animate: animatePill, pop: popPill });
        }

        mobileNavLinks.forEach((link) => {
            const isActive = link.getAttribute('data-nav-target') === targetId;
            if (isActive) {
                link.setAttribute('aria-current', 'page');
                link.classList.add('bg-[#DCFCE7]', 'text-[#15803D]', 'font-semibold');
                link.classList.remove('text-[#4B5563]', 'font-medium', 'hover:text-[#111827]', 'hover:bg-[#F3F4F6]');
            } else {
                link.removeAttribute('aria-current');
                link.classList.remove('bg-[#DCFCE7]', 'text-[#15803D]', 'font-semibold');
                link.classList.add('text-[#4B5563]', 'hover:text-[#111827]', 'hover:bg-[#F3F4F6]');
            }
        });

        bottomLinks.forEach((link) => {
            const isActive = link.getAttribute('data-nav-target') === targetId;
            if (isActive) {
                link.classList.add('bg-[#DCFCE7]', 'text-[#15803D]', 'font-bold');
                link.classList.remove('text-[#4B5563]');
            } else {
                link.classList.remove('bg-[#DCFCE7]', 'text-[#15803D]', 'font-bold');
                link.classList.add('text-[#4B5563]');
            }
        });
    };

    let clickLockUntil = 0;

    allTargetTriggers.forEach((trigger) => {
        trigger.addEventListener('click', (e) => {
            const targetId = trigger.getAttribute('data-nav-target');
            const targetEl = targetId ? document.getElementById(targetId) : null;
            if (!targetEl) return;

            e.preventDefault();
            clickLockUntil = Date.now() + 750;
            setActiveSection(targetId, { animatePill: true, popPill: true });
            setMobileMenuOpen(false);

            const headerOffset = headerEl ? headerEl.offsetHeight + 8 : 72;
            const topPos = targetId === 'beranda'
                ? 0
                : Math.max(0, targetEl.getBoundingClientRect().top + window.scrollY - headerOffset);

            window.scrollTo({ top: topPos, behavior: 'smooth' });
            if (history.replaceState) {
                history.replaceState(null, '', `#${targetId}`);
            }
        });
    });

    const uniqueTargetIds = Array.from(new Set(desktopNavLinks.map((l) => l.getAttribute('data-nav-target')).filter(Boolean)));
    const trackedSections = uniqueTargetIds
        .map((id) => ({ id, el: document.getElementById(id) }))
        .filter((x) => x.el);

    if (trackedSections.length > 0) {
        const syncScrollSpy = (animatePill = true) => {
            if (Date.now() < clickLockUntil) return;
            const scrollY = window.scrollY;
            if (scrollY < 120) {
                setActiveSection('beranda', { animatePill });
                return;
            }
            const probe = scrollY + (headerEl ? headerEl.offsetHeight + 40 : 104);
            let currentId = trackedSections[0].id;
            for (const sec of trackedSections) {
                if (sec.el.offsetTop <= probe) {
                    currentId = sec.id;
                }
            }
            setActiveSection(currentId, { animatePill });
        };

        window.addEventListener('scroll', () => syncScrollSpy(true), { passive: true });
        window.addEventListener('resize', () => {
            const activeLink = desktopNavLinks.find((l) => l.getAttribute('data-nav-target') === currentActiveId);
            if (activeLink) moveNavPillTo(activeLink, { animate: false });
        });

        // Initial pill placement (snap without flash) + re-align once web fonts finish loading
        syncScrollSpy(false);
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(() => {
                const activeLink = desktopNavLinks.find((l) => l.getAttribute('data-nav-target') === currentActiveId);
                if (activeLink) moveNavPillTo(activeLink, { animate: false });
            });
        }
    }
});
