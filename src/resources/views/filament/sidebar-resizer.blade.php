<div
    id="fh-sidebar-resizer"
    class="fh-sidebar-resizer hidden lg:flex"
    x-data="{}"
    x-show="$store.sidebar.isOpen"
    x-cloak
    title="Geser untuk atur lebar sidebar (klik 2x untuk reset)"
    aria-label="Atur lebar sidebar"
    role="separator"
    aria-orientation="vertical"
>
    <span class="fh-sidebar-resizer-grip"></span>
</div>

<script>
    (function () {
        const STORAGE_KEY = 'fixhome_admin_sidebar_width';
        const MIN_WIDTH = 220;
        const MAX_WIDTH = 440;
        const DEFAULT_WIDTH = 288;

        function clampWidth(val) {
            const num = parseInt(val, 10);
            if (Number.isNaN(num)) return DEFAULT_WIDTH;
            return Math.min(MAX_WIDTH, Math.max(MIN_WIDTH, num));
        }

        function applySidebarWidth(px) {
            const clamped = clampWidth(px);
            document.documentElement.style.setProperty('--sidebar-width', clamped + 'px');
            return clamped;
        }

        function restoreSidebarWidth() {
            try {
                const saved = localStorage.getItem(STORAGE_KEY);
                if (saved) {
                    applySidebarWidth(saved);
                }
            } catch (e) {}
        }

        function bindResizer() {
            restoreSidebarWidth();

            const handle = document.getElementById('fh-sidebar-resizer');
            if (!handle || handle.dataset.bound === '1') return;
            handle.dataset.bound = '1';

            let isDragging = false;
            let startX = 0;
            let startWidth = DEFAULT_WIDTH;

            const onPointerMove = (e) => {
                if (!isDragging) return;
                const delta = e.clientX - startX;
                const nextWidth = applySidebarWidth(startWidth + delta);
                try {
                    localStorage.setItem(STORAGE_KEY, String(nextWidth));
                } catch (err) {}
            };

            const onPointerUp = () => {
                if (!isDragging) return;
                isDragging = false;
                handle.classList.remove('is-dragging');
                document.body.classList.remove('fh-sidebar-resizing');
                window.removeEventListener('pointermove', onPointerMove);
                window.removeEventListener('pointerup', onPointerUp);
                window.removeEventListener('pointercancel', onPointerUp);
            };

            handle.addEventListener('pointerdown', (e) => {
                if (window.innerWidth < 1024) return;
                const sidebar = handle.closest('.fi-sidebar');
                if (!sidebar) return;
                e.preventDefault();
                isDragging = true;
                startX = e.clientX;
                startWidth = sidebar.getBoundingClientRect().width || DEFAULT_WIDTH;
                handle.classList.add('is-dragging');
                document.body.classList.add('fh-sidebar-resizing');
                window.addEventListener('pointermove', onPointerMove);
                window.addEventListener('pointerup', onPointerUp);
                window.addEventListener('pointercancel', onPointerUp);
            });

            handle.addEventListener('dblclick', () => {
                applySidebarWidth(DEFAULT_WIDTH);
                try {
                    localStorage.removeItem(STORAGE_KEY);
                } catch (err) {}
            });
        }

        bindResizer();

        if (!window.__fhSidebarResizerHooked) {
            window.__fhSidebarResizerHooked = true;
            document.addEventListener('DOMContentLoaded', bindResizer);
            document.addEventListener('livewire:navigated', bindResizer);
        }
    })();
</script>
