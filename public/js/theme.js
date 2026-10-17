// Theme switch in the header: system -> light -> dark -> system. The class on <html> is set
// before the first paint by the inline script in the page head; this keeps it in sync.
(function () {
    const order = ['system', 'light', 'dark'];
    const media = window.matchMedia('(prefers-color-scheme: dark)');

    function stored() {
        try { return localStorage.getItem('theme') || 'system'; } catch (e) { return 'system'; }
    }

    function apply(theme) {
        document.documentElement.classList.toggle('dark', theme === 'dark' || (theme === 'system' && media.matches));
        document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
            const label = JSON.parse(button.dataset.labels)[theme];
            button.setAttribute('aria-label', label);
            button.title = label;
            button.querySelectorAll('[data-theme-icon]').forEach(function (icon) {
                icon.classList.toggle('hidden', icon.dataset.themeIcon !== theme);
            });
        });
    }

    document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            const next = order[(order.indexOf(stored()) + 1) % order.length];
            try {
                if (next === 'system') localStorage.removeItem('theme'); else localStorage.setItem('theme', next);
            } catch (e) {}
            apply(next);
        });
    });
    media.addEventListener('change', function () { apply(stored()); });
    apply(stored());
})();
