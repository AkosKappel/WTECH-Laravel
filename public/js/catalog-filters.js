// Catalog filters: apply changes without reloading the page (clean URLs, history), price slider,
// brand quick search, collapsible sections, mobile toggle. Without JavaScript the form and links work as usual.
(function () {
    const form = document.getElementById('filters');
    const results = document.getElementById('catalog-results');
    if (!form || !results) return;
    const status = document.getElementById('catalog-status');
    form.classList.add('is-enhanced');

    // ---- mobile toggle ------------------------------------------------------------
    const toggle = document.getElementById('filters-toggle');
    toggle.addEventListener('click', function () {
        if (window.innerWidth >= 1024) return;
        const open = form.classList.toggle('hidden') === false;
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    // ---- clean URL, same format as App\Support\CatalogFilters ----------------------
    function checkedValues(name) {
        return Array.from(form.querySelectorAll('input[name="' + name + '[]"]:checked')).map(function (input) { return input.value; });
    }

    function buildUrl() {
        const range = form.querySelector('.price-range');
        const bounds = { min: Number(range.dataset.min), max: Number(range.dataset.max) };
        const priceMin = form.querySelector('[data-price="min"]').value;
        const priceMax = form.querySelector('[data-price="max"]').value;
        const params = [];
        const add = function (key, value) { if (value !== '' && value !== null) params.push(key + '=' + value); };
        const list = function (values) { return values.map(encodeURIComponent).join(','); };
        const q = form.querySelector('input[name="q"]');
        let min = priceMin === '' ? null : Number(priceMin);
        let max = priceMax === '' ? null : Number(priceMax);
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

    // ---- loading results in place -------------------------------------------------
    let pending = null;

    // remembers the focused control, so it can be focused again after the swap
    function focusKey() {
        const el = document.activeElement;
        if (!el || !form.contains(el)) return null;
        if (el.name) return '[name="' + el.name + '"]' + (el.type === 'checkbox' ? '[value="' + el.value + '"]' : '');
        if (el.dataset.thumb) return '[data-thumb="' + el.dataset.thumb + '"]';
        if (el.hasAttribute('data-brand-search')) return '[data-brand-search]';
        const section = el.closest('[data-section]');
        if (section) return '[data-section="' + section.dataset.section + '"] ' + (el.tagName === 'SUMMARY' ? 'summary' : 'a');
        return null;
    }

    function load(url, options) {
        options = options || {};
        if (pending) pending.abort();
        const controller = window.AbortController ? new AbortController() : null;
        pending = controller;
        results.classList.add('is-loading');
        results.setAttribute('aria-busy', 'true');

        fetch(url, {
            headers: { 'X-Catalog-Partial': '1', 'Accept': 'application/json' },
            credentials: 'same-origin',
            cache: 'no-store',
            signal: controller ? controller.signal : undefined,
        }).then(function (response) {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json().then(function (data) { return { data: data, url: response.url || url }; });
        }).then(function (result) {
            if (pending !== controller) return;
            pending = null;
            render(result.data);
            if (options.push) history.pushState({ catalog: true }, '', result.url);
            else if (options.replace) history.replaceState({ catalog: true }, '', result.url);
            if (options.scroll) {
                const top = results.getBoundingClientRect().top + window.pageYOffset - 90;
                if (window.pageYOffset > top) window.scrollTo({ top: top, behavior: reducedMotion() ? 'auto' : 'smooth' });
            }
            if (options.focusResults) results.querySelector('[data-results-heading]').focus({ preventScroll: true });
        }).catch(function (error) {
            if (error && error.name === 'AbortError') return;
            window.location.assign(url); // fall back to a normal page load
        });
    }

    function render(data) {
        const focus = focusKey();
        const brandSearch = form.querySelector('[data-brand-search]');
        const brandQuery = brandSearch ? brandSearch.value : '';
        const brandList = form.querySelector('[data-brand-list]');
        const brandScroll = brandList ? brandList.scrollTop : 0;

        form.innerHTML = data.filters;
        results.innerHTML = data.results;
        document.title = data.title;
        results.classList.remove('is-loading');
        results.removeAttribute('aria-busy');
        if (status) status.textContent = data.status;

        restoreSections();
        initForm();
        const newSearch = form.querySelector('[data-brand-search]');
        if (newSearch && brandQuery) { newSearch.value = brandQuery; filterBrands(); }
        const newList = form.querySelector('[data-brand-list]');
        if (newList) newList.scrollTop = brandScroll;
        if (focus) {
            // a section's "Clear" link disappears once it's used, so focus the section header instead
            const target = form.querySelector(focus) || form.querySelector(focus.replace(/ a$/, ' summary'));
            if (target) target.focus({ preventScroll: true });
        }
    }

    function apply() {
        load(buildUrl(), { push: true });
    }

    function reducedMotion() {
        return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    history.replaceState({ catalog: true }, '', window.location.href);
    window.addEventListener('popstate', function (event) {
        if (event.state && event.state.catalog) load(window.location.href, {});
    });

    // form controls (delegated, so they keep working after the form is re-rendered)
    form.addEventListener('submit', function (event) { event.preventDefault(); apply(); });
    let sliderTimer = null;
    form.addEventListener('change', function (event) {
        const target = event.target;
        if (target.matches('[data-thumb]')) {
            // arrow keys fire a change per step, so wait until they stop
            clearTimeout(sliderTimer);
            sliderTimer = setTimeout(apply, 350);
        } else if (target.matches('input[type="checkbox"], [data-price]')) {
            apply();
        }
    });
    form.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' && event.target.matches('[data-brand-search]')) event.preventDefault();
    });

    // links to other filter combinations: chips, per-section clear, sort, pagination, clear all
    document.addEventListener('click', function (event) {
        const link = event.target.closest('a[data-catalog-link], #catalog-results nav a[href]');
        if (!link || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
        if (link.origin !== window.location.origin || link.pathname !== new URL(form.action).pathname) return;
        event.preventDefault();
        const menu = link.closest('details.sort-menu');
        if (menu) menu.removeAttribute('open');
        const paging = !!link.closest('nav');
        load(link.href, { push: true, scroll: paging, focusResults: paging || !form.contains(link) });
    });

    // ---- collapsible sections, remembered per visitor --------------------------------
    const STORAGE_KEY = 'catalog.closedFilters';

    function closedSections() {
        try { return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]'); } catch (e) { return []; }
    }

    function restoreSections() {
        const closed = closedSections();
        form.querySelectorAll('[data-section]').forEach(function (section) {
            section.querySelector('details').open = closed.indexOf(section.dataset.section) === -1;
        });
    }

    // "toggle" doesn't bubble, so listen in the capture phase
    form.addEventListener('toggle', function (event) {
        const section = event.target.closest && event.target.closest('[data-section]');
        if (!section || event.target !== section.querySelector('details')) return;
        const name = section.dataset.section;
        const closed = closedSections().filter(function (item) { return item !== name; });
        if (!event.target.open) closed.push(name);
        try { localStorage.setItem(STORAGE_KEY, JSON.stringify(closed)); } catch (e) {}
    }, true);

    // ---- price slider ---------------------------------------------------------------
    function paint() {
        const range = form.querySelector('.price-range');
        const min = Number(range.dataset.min), max = Number(range.dataset.max);
        const thumbs = { min: range.querySelector('[data-thumb="min"]'), max: range.querySelector('[data-thumb="max"]') };
        const span = max - min || 1;
        const lo = (Number(thumbs.min.value) - min) / span * 100;
        const hi = (Number(thumbs.max.value) - min) / span * 100;
        const fill = range.querySelector('.price-range-fill');
        fill.style.left = lo + '%';
        fill.style.width = Math.max(0, hi - lo) + '%';
    }

    form.addEventListener('input', function (event) {
        const target = event.target;
        const range = form.querySelector('.price-range');
        const bounds = { min: Number(range.dataset.min), max: Number(range.dataset.max) };
        if (target.dataset.thumb) {
            const side = target.dataset.thumb;
            const minThumb = range.querySelector('[data-thumb="min"]'), maxThumb = range.querySelector('[data-thumb="max"]');
            // keep the thumbs from crossing
            if (Number(minThumb.value) > Number(maxThumb.value)) target.value = side === 'min' ? maxThumb.value : minThumb.value;
            const value = Number(target.value);
            const atEdge = side === 'min' ? value <= bounds.min : value >= bounds.max;
            form.querySelector('[data-price="' + side + '"]').value = atEdge ? '' : value;
            paint();
        } else if (target.dataset.price) {
            if (target.value !== '') range.querySelector('[data-thumb="' + target.dataset.price + '"]').value = target.value;
            paint();
        } else if (target.matches('[data-brand-search]')) {
            filterBrands();
        }
    });

    // ---- brand quick search (typo-tolerant, ignores accents) ------------------------
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

    function filterBrands() {
        const needle = normalize(form.querySelector('[data-brand-search]').value);
        let visible = 0;
        form.querySelectorAll('[data-brand-list] li').forEach(function (item) {
            const match = fuzzy(needle, normalize(item.dataset.brandName));
            item.classList.toggle('hidden', !match);
            if (match) visible++;
        });
        form.querySelector('[data-brand-empty]').classList.toggle('hidden', visible > 0);
    }

    // ---- sort menu: close on outside click / Escape ---------------------------------
    document.addEventListener('click', function (event) {
        const menu = results.querySelector('details.sort-menu');
        if (menu && !menu.contains(event.target)) menu.removeAttribute('open');
    });
    document.addEventListener('keydown', function (event) {
        const menu = results.querySelector('details.sort-menu');
        if (event.key === 'Escape' && menu) menu.removeAttribute('open');
    });

    // things that have to be set up again whenever the form is re-rendered
    function initForm() {
        form.querySelectorAll('[data-thumb]').forEach(function (thumb) { thumb.removeAttribute('tabindex'); });
        paint();
    }
    initForm();
})();
