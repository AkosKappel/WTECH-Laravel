// Catalog filters: apply on change with clean URLs, price slider, brand quick search, mobile toggle.
(function () {
    const form = document.getElementById('filters');
    if (!form) return;

    // ---- mobile toggle ------------------------------------------------------------
    const toggle = document.getElementById('filters-toggle');
    toggle.addEventListener('click', function () {
        if (window.innerWidth >= 1024) return;
        const open = form.classList.toggle('hidden') === false;
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    // ---- clean URL, same format as App\Support\CatalogFilters ----------------------
    const range = form.querySelector('.price-range');
    const bounds = { min: Number(range.dataset.min), max: Number(range.dataset.max) };
    const priceInputs = { min: form.querySelector('[data-price="min"]'), max: form.querySelector('[data-price="max"]') };

    function checkedValues(name) {
        return Array.from(form.querySelectorAll('input[name="' + name + '[]"]:checked')).map(function (input) { return input.value; });
    }

    function buildUrl() {
        const params = [];
        const add = function (key, value) { if (value !== '' && value !== null) params.push(key + '=' + value); };
        const list = function (values) { return values.map(encodeURIComponent).join(','); };
        const q = form.querySelector('input[name="q"]');
        let min = priceInputs.min.value === '' ? null : Number(priceInputs.min.value);
        let max = priceInputs.max.value === '' ? null : Number(priceInputs.max.value);
        if (min !== null && min <= Math.max(0, bounds.min)) min = null;
        if (max !== null && max >= bounds.max) max = null;
        if (min !== null && max !== null && min > max) { const swap = min; min = max; max = swap; }

        if (q) add('q', encodeURIComponent(q.value));
        add('brand', list(checkedValues('brand')));
        add('color', list(checkedValues('color')));
        add('price', min === null && max === null ? '' : (min === null ? '' : min) + '-' + (max === null ? '' : max));
        add('ram', list(checkedValues('ram')));
        add('display', list(checkedValues('display')));
        add('os', list(checkedValues('os')));
        add('stock', form.querySelector('input[name="stock"]').checked ? 'in' : '');
        const sort = form.querySelector('input[name="sort"]');
        if (sort) add('sort', encodeURIComponent(sort.value));
        return form.action + (params.length ? '?' + params.join('&') : '');
    }

    function apply() {
        form.classList.add('is-loading');
        window.location.assign(buildUrl());
    }

    form.addEventListener('submit', function (event) { event.preventDefault(); apply(); });
    form.querySelectorAll('input[type="checkbox"]').forEach(function (input) { input.addEventListener('change', apply); });
    Object.values(priceInputs).forEach(function (input) { input.addEventListener('change', apply); });
    form.querySelector('[data-apply]').classList.add('hidden'); // changes apply immediately with JavaScript

    // ---- price slider ---------------------------------------------------------------
    const thumbs = { min: range.querySelector('[data-thumb="min"]'), max: range.querySelector('[data-thumb="max"]') };
    const fill = range.querySelector('.price-range-fill');
    Object.values(thumbs).forEach(function (thumb) { thumb.removeAttribute('tabindex'); });

    function paint() {
        const span = bounds.max - bounds.min || 1;
        const lo = (Number(thumbs.min.value) - bounds.min) / span * 100;
        const hi = (Number(thumbs.max.value) - bounds.min) / span * 100;
        fill.style.left = lo + '%';
        fill.style.width = Math.max(0, hi - lo) + '%';
    }

    ['min', 'max'].forEach(function (side) {
        thumbs[side].addEventListener('input', function () {
            // keep the thumbs from crossing
            if (Number(thumbs.min.value) > Number(thumbs.max.value)) {
                thumbs[side].value = side === 'min' ? thumbs.max.value : thumbs.min.value;
            }
            const value = Number(thumbs[side].value);
            const atEdge = side === 'min' ? value <= bounds.min : value >= bounds.max;
            priceInputs[side].value = atEdge ? '' : value;
            paint();
        });
        thumbs[side].addEventListener('change', apply);
        priceInputs[side].addEventListener('input', function () {
            if (priceInputs[side].value !== '') thumbs[side].value = priceInputs[side].value;
            paint();
        });
    });
    paint();

    // ---- brand quick search (typo-tolerant, ignores accents) ------------------------
    const brandSearch = form.querySelector('[data-brand-search]');
    const brandItems = Array.from(form.querySelectorAll('[data-brand-list] li'));
    const empty = form.querySelector('[data-brand-empty]');
    const normalize = function (text) { return text.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase().trim(); };

    // matches substrings, and letters in order with one typo allowed ("samsng", "motrla")
    function fuzzy(needle, haystack) {
        if (!needle || haystack.indexOf(needle) !== -1) return true;
        let i = 0, misses = 0;
        for (const char of needle) {
            const found = haystack.indexOf(char, i);
            if (found === -1) { if (++misses > 1) return false; } else { i = found + 1; }
        }
        return needle.length >= 3;
    }

    brandSearch.classList.remove('hidden');
    brandSearch.addEventListener('input', function () {
        const needle = normalize(brandSearch.value);
        let visible = 0;
        brandItems.forEach(function (item) {
            const match = fuzzy(needle, normalize(item.dataset.brandName));
            item.classList.toggle('hidden', !match);
            if (match) visible++;
        });
        empty.classList.toggle('hidden', visible > 0);
    });
    brandSearch.addEventListener('keydown', function (event) { if (event.key === 'Enter') event.preventDefault(); });

    // ---- sort menu: close on outside click / Escape ---------------------------------
    const sortMenu = document.querySelector('details.sort-menu');
    if (sortMenu) {
        document.addEventListener('click', function (event) { if (!sortMenu.contains(event.target)) sortMenu.removeAttribute('open'); });
        document.addEventListener('keydown', function (event) { if (event.key === 'Escape') sortMenu.removeAttribute('open'); });
    }
})();
