// Searchable country field: hides the <select> and shows a text box with a filtered list
// (accent-insensitive, keyboard: arrows, Enter, Escape). The select stays the form field.
(function () {
    const fold = (text) => text.normalize('NFD').replace(/\p{M}/gu, '').toLowerCase();

    document.querySelectorAll('[data-country-select]').forEach(function (wrapper, index) {
        const select = wrapper.querySelector('select');
        const options = Array.from(select.options).filter((option) => option.value !== '');
        const listId = 'country-list-' + index;

        const input = document.createElement('input');
        input.type = 'text';
        input.id = select.id;
        select.removeAttribute('id');
        input.className = select.className + ' pr-10';
        input.placeholder = select.options[0].text;
        input.autocomplete = 'off';
        input.spellcheck = false;
        input.required = select.required;
        select.required = false;
        input.setAttribute('role', 'combobox');
        input.setAttribute('aria-autocomplete', 'list');
        input.setAttribute('aria-expanded', 'false');
        input.setAttribute('aria-controls', listId);

        const list = document.createElement('ul');
        list.id = listId;
        list.setAttribute('role', 'listbox');
        list.className = 'absolute z-30 mt-1 w-full max-h-60 overflow-auto rounded-lg bg-white py-1 shadow-lg ring-1 ring-black/5 hidden';

        select.hidden = true;
        select.tabIndex = -1;
        wrapper.append(input, list);

        let active = -1;
        let shown = [];

        function label() {
            return select.selectedIndex > 0 ? select.options[select.selectedIndex].text : '';
        }

        function render(filter) {
            const needle = fold(filter);
            shown = options.filter((option) => fold(option.text).includes(needle));
            list.replaceChildren(...shown.map(function (option, i) {
                const item = document.createElement('li');
                item.id = listId + '-' + i;
                item.setAttribute('role', 'option');
                item.setAttribute('aria-selected', option.selected ? 'true' : 'false');
                item.textContent = option.text;
                item.className = 'cursor-pointer px-3 py-2 text-sm text-gray-900 hover:bg-indigo-50' + (option.selected ? ' font-semibold' : '');
                item.addEventListener('mousedown', function (event) {
                    event.preventDefault();
                    choose(option);
                });
                return item;
            }));
            if (!shown.length) {
                const empty = document.createElement('li');
                empty.className = 'px-3 py-2 text-sm text-gray-500';
                empty.textContent = wrapper.dataset.empty || '–';
                list.append(empty);
            }
            highlight(shown.length ? 0 : -1);
        }

        function highlight(i) {
            active = i;
            Array.from(list.children).forEach((item, n) => item.classList.toggle('bg-indigo-50', n === i));
            if (i >= 0) {
                input.setAttribute('aria-activedescendant', listId + '-' + i);
                list.children[i].scrollIntoView({ block: 'nearest' });
            } else {
                input.removeAttribute('aria-activedescendant');
            }
        }

        function open() {
            render(input.value === label() ? '' : input.value);
            list.classList.remove('hidden');
            input.setAttribute('aria-expanded', 'true');
        }

        function close() {
            list.classList.add('hidden');
            input.setAttribute('aria-expanded', 'false');
        }

        function choose(option) {
            select.value = option.value;
            select.dispatchEvent(new Event('change', { bubbles: true }));
            input.value = option.text;
            close();
        }

        input.value = label();
        input.addEventListener('focus', open);
        input.addEventListener('input', function () {
            open();
            render(input.value);
        });
        input.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                event.preventDefault();
                if (list.classList.contains('hidden')) open();
                const step = event.key === 'ArrowDown' ? 1 : -1;
                highlight(Math.max(0, Math.min(shown.length - 1, active + step)));
            } else if (event.key === 'Enter' && !list.classList.contains('hidden')) {
                event.preventDefault();
                if (shown[active]) choose(shown[active]);
            } else if (event.key === 'Escape') {
                input.value = label();
                close();
            }
        });
        input.addEventListener('blur', function () {
            // typed a full name without picking it from the list: take it; anything else goes back
            const exact = options.find((option) => fold(option.text) === fold(input.value.trim()));
            if (exact) choose(exact); else input.value = label();
            close();
        });
    });
})();
