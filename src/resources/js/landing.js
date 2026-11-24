document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Navigation Menu
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('mobile-menu-icon');

    if (toggleBtn && mobileMenu) {
        const setOpen = (open) => {
            mobileMenu.classList.toggle('hidden', !open);
            toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggleBtn.setAttribute('aria-label', open ? 'Tutup menu navigasi' : 'Buka menu navigasi');
            document.body.classList.toggle('overflow-hidden', open);
            if (menuIcon) menuIcon.textContent = open ? 'close' : 'menu';
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

    // 3. Active Section Underline on Scroll
    const navLinks = Array.from(document.querySelectorAll('header nav a.fh-link[href^="#"]'));
    const sections = navLinks
        .map((link) => {
            const id = link.getAttribute('href')?.slice(1);
            return id ? { link, el: document.getElementById(id) } : null;
        })
        .filter((x) => x && x.el);

    if (sections.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    sections.forEach(({ link, el }) => {
                        if (el === entry.target) {
                            link.setAttribute('aria-current', 'page');
                            link.classList.add('text-[#1A1C1C]', 'font-semibold');
                            link.classList.remove('text-[#50453C]');
                        } else {
                            link.removeAttribute('aria-current');
                            link.classList.remove('text-[#1A1C1C]', 'font-semibold');
                            link.classList.add('text-[#50453C]');
                        }
                    });
                });
            },
            { rootMargin: '-30% 0px -55% 0px' },
        );
        sections.forEach(({ el }) => observer.observe(el));
    }
});
