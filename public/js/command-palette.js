// Command palette (layout/partials/command-palette): Ctrl+K or Cmd+K opens it, typing filters the pages
// and fetches matching phones from /search/suggest, the last entry searches the catalog for what was typed.
(function () {
    const dialog = document.getElementById('command-palette');
    if (!dialog) return;

    const input = dialog.querySelector('#command-palette-input');
    const search = dialog.querySelector('[data-palette-search]');
    const searchOption = search.querySelector('[role="option"]');
    let timer = null, controller = null;

    // "Objednávky" matches "objednavky": compare without case and accents
    const normalize = function (text) { return text.normalize('NFD').replace(/\p{M}/gu, '').toLowerCase(); };

    // the options are the links; hiding filters their list items
    function visibleOptions() {
        return Array.from(dialog.querySelectorAll('[role="option"]')).filter(function (option) { return !option.parentElement.hidden; });
    }

    function select(option) {
        dialog.querySelectorAll('[role="option"]').forEach(function (other) { other.setAttribute('aria-selected', 'false'); });
        if (!option) { input.removeAttribute('aria-activedescendant'); return; }
        option.setAttribute('aria-selected', 'true');
        input.setAttribute('aria-activedescendant', option.id);
        option.scrollIntoView({ block: 'nearest' });
    }

    function selected() {
        return dialog.querySelector('[role="option"][aria-selected="true"]');
    }

    function clearProducts() {
        dialog.querySelectorAll('[data-palette-product]').forEach(function (item) { item.remove(); });
    }

    function renderProducts(results) {
        const current = selected();
        const moved = current && current !== visibleOptions()[0];
        clearProducts();
        results.forEach(function (result, i) {
            const item = document.createElement('li');
            item.setAttribute('role', 'presentation');
            item.dataset.paletteProduct = '';
            const option = document.createElement('a');
            option.id = 'palette-product-' + i;
            option.setAttribute('role', 'option');
            option.setAttribute('aria-selected', 'false');
            option.tabIndex = -1;
            option.href = result.url;
            option.className = searchOption.className;
            const image = document.createElement(result.image ? 'img' : 'span');
            image.className = 'h-8 w-8 shrink-0 rounded-sm object-contain' + (result.image ? '' : ' bg-gray-100');
            if (result.image) { image.src = result.image; image.alt = ''; }
            const name = document.createElement('span');
            name.className = 'grow min-w-0 truncate';
            name.textContent = result.name;
            const price = document.createElement('span');
            price.className = 'text-sm font-semibold text-indigo-600 whitespace-nowrap';
            price.textContent = result.price;
            option.append(image, name, price);
            item.append(option);
            search.before(item);
        });
        // the phones arrive while the visitor may be moving through the list: keep their place
        select(moved && current.isConnected ? current : visibleOptions()[0]);
    }

    function fetchProducts(query) {
        clearTimeout(timer);
        if (controller) controller.abort();
        if (query.length < 2) { clearProducts(); return; }
        timer = setTimeout(function () {
            controller = new AbortController();
            fetch(dialog.dataset.suggestUrl + '?q=' + encodeURIComponent(query), { signal: controller.signal, headers: { 'Accept': 'application/json' } })
                .then(function (response) { return response.ok ? response.json() : null; })
                .then(function (data) { if (input.value.trim() === query) renderProducts(data ? data.results : []); })
                .catch(function () { /* aborted, offline or in maintenance: the pages and the search entry still work */ });
        }, 200);
    }

    function filter() {
        const query = input.value.trim();
        const needle = normalize(query);
        dialog.querySelectorAll('[data-palette-item]').forEach(function (item) {
            item.hidden = !normalize(item.dataset.paletteItem).includes(needle);
        });
        search.hidden = query === '';
        search.querySelector('[data-palette-search-label]').textContent = searchOption.dataset.template.replace(':query', query);
        searchOption.href = dialog.querySelector('form').action + '?q=' + encodeURIComponent(query);
        select(visibleOptions()[0]);
        fetchProducts(query);
    }

    function open() {
        input.value = '';
        filter();
        dialog.showModal();
    }

    input.addEventListener('input', filter);

    input.addEventListener('keydown', function (event) {
        const options = visibleOptions();
        const current = options.indexOf(selected());
        if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
            event.preventDefault();
            const step = event.key === 'ArrowDown' ? 1 : -1;
            select(options[(current + step + options.length) % options.length]);
        } else if (event.key === 'Enter' && options[current]) {
            event.preventDefault();
            options[current].click();
        } else if (event.key === 'Escape') {
            // a search field would only clear its text on the first Escape
            event.preventDefault();
            dialog.close();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key.toLowerCase() === 'k' && (event.ctrlKey || event.metaKey) && !event.altKey && !event.shiftKey) {
            event.preventDefault();
            if (dialog.open) dialog.close(); else open();
        }
    });

    dialog.addEventListener('click', function (event) {
        // a click on the backdrop lands on the dialog itself; closedby="any" isn't supported everywhere yet
        if (event.target === dialog) dialog.close();
        // close before leaving, so the page restored with the back button doesn't show it open
        if (event.target.closest('[role="option"]')) dialog.close();
    });

    // the header button, with the shortcut this system uses
    const mac = /Mac|iPhone|iPad/.test(navigator.platform);
    document.querySelectorAll('[data-command-palette-open]').forEach(function (button) {
        button.hidden = false;
        if (mac) {
            button.setAttribute('aria-keyshortcuts', 'Meta+K');
            button.querySelector('kbd').textContent = '⌘K';
        }
        button.addEventListener('click', open);
    });
})();
