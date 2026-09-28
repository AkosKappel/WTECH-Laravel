// Live search suggestions for every .search-box form: fetches /search/suggest, keyboard navigation, no library.
(function () {
    document.querySelectorAll('form.search-box').forEach(function (form) {
        const input = form.querySelector('input[name="q"]');
        const panel = form.querySelector('.search-results');
        let timer = null, controller = null, active = -1, items = [];

        function close() {
            panel.classList.add('hidden');
            input.setAttribute('aria-expanded', 'false');
            input.removeAttribute('aria-activedescendant');
            active = -1;
        }

        function highlight(index) {
            items.forEach(function (item, i) { item.classList.toggle('bg-indigo-50', i === index); item.setAttribute('aria-selected', i === index ? 'true' : 'false'); });
            active = index;
            if (index >= 0) input.setAttribute('aria-activedescendant', items[index].id);
        }

        function escape(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function render(data) {
            if (!data.results.length) {
                panel.innerHTML = '<p class="px-4 py-3 text-sm text-gray-500">' + escape(panel.dataset.empty) + '</p>';
            } else {
                panel.innerHTML = data.results.map(function (result, i) {
                    return '<a id="' + input.id + '-option-' + i + '" role="option" href="' + result.url + '" class="flex items-center gap-3 px-4 py-2 hover:bg-indigo-50">'
                        + (result.image ? '<img src="' + result.image + '" alt="" class="h-10 w-10 object-contain shrink-0">' : '<span class="h-10 w-10 shrink-0 rounded-sm bg-gray-100"></span>')
                        + '<span class="grow min-w-0"><span class="block text-sm text-gray-900 truncate">' + escape(result.name) + '</span>'
                        + (result.in_stock ? '' : '<span class="block text-xs text-gray-500">' + escape(panel.dataset.out) + '</span>') + '</span>'
                        + '<span class="text-sm font-semibold text-indigo-600 whitespace-nowrap">' + escape(result.price) + '</span></a>';
                }).join('') + '<a href="' + data.all_url + '" class="block px-4 py-2 border-t border-gray-100 text-sm font-medium text-indigo-600 hover:bg-indigo-50">'
                    + escape(panel.dataset.all.replace(':count', data.total)) + ' →</a>';
            }
            items = Array.from(panel.querySelectorAll('[role="option"]'));
            active = -1;
            panel.classList.remove('hidden');
            input.setAttribute('aria-expanded', 'true');
        }

        input.addEventListener('input', function () {
            clearTimeout(timer);
            const q = input.value.trim();
            if (q.length < 2) { close(); return; }
            timer = setTimeout(function () {
                if (controller) controller.abort();
                controller = new AbortController();
                fetch(form.dataset.suggestUrl + '?q=' + encodeURIComponent(q), { signal: controller.signal, headers: { 'Accept': 'application/json' } })
                    .then(function (response) { return response.ok ? response.json() : null; })
                    .then(function (data) { if (data && input.value.trim() === q) render(data); })
                    .catch(function () { /* aborted or offline: keep the plain form */ });
            }, 200);
        });

        input.addEventListener('keydown', function (event) {
            if (panel.classList.contains('hidden')) return;
            if (event.key === 'ArrowDown') { event.preventDefault(); highlight(Math.min(active + 1, items.length - 1)); }
            else if (event.key === 'ArrowUp') { event.preventDefault(); highlight(Math.max(active - 1, -1)); }
            else if (event.key === 'Enter' && active >= 0) { event.preventDefault(); window.location.assign(items[active].href); }
            else if (event.key === 'Escape') { close(); }
        });

        document.addEventListener('click', function (event) { if (!form.contains(event.target)) close(); });
        input.addEventListener('focus', function () { if (panel.innerHTML && input.value.trim().length >= 2) { panel.classList.remove('hidden'); input.setAttribute('aria-expanded', 'true'); } });
    });
})();
