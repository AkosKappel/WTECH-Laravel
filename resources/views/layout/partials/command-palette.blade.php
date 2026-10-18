{{-- Ctrl+K / Cmd+K quick find (public/js/command-palette.js): type to filter the pages, see matching phones
     from the search suggestions, or press Enter on the last entry to search the catalog. --}}
@php
    $pages = [
        [__('Home'), route('home'), 'arrow-right'],
        [__('Products'), route('smartphones'), 'search'],
        [__('Compare phones'), route('compare'), 'scale'],
        [__('Shopping Cart'), route('cart'), 'cart'],
    ];
    if (Auth::check()) {
        $pages[] = [__('Profile'), route('profile'), 'user'];
        $pages[] = [__('My orders'), route('orders'), 'user'];
        $pages[] = [__('Wishlist'), route('wishlist'), 'heart'];
    } else {
        $pages[] = [__('Sign In'), route('login'), 'log-in'];
    }
    if (Gate::allows('adminZone')) {
        $pages[] = [__('Admin') . ': ' . __('Products'), route('admin'), 'lock'];
    }
    if (Gate::allows('create', \App\Models\Smartphone::class)) {
        $pages[] = [__('Admin') . ': ' . __('Add product'), route('smartphones.add'), 'plus'];
    }
    if (Gate::allows('isAdmin')) {
        foreach (\App\Support\AdminPages::all() as $route => [$label]) {
            $pages[] = [__('Admin') . ': ' . $label, route($route), 'lock'];
        }
    }
    // the footer's pages
    foreach ([
        'about' => __('About this project'),
        'contact' => __('Contact'),
        'shipping' => __('Shipping'),
        'payment-methods' => __('Payment Methods'),
        'returns' => __('Returns & Claims'),
        'terms' => __('Terms and Conditions'),
        'privacy' => __('Privacy Policy'),
    ] as $route => $label) {
        $pages[] = [$label, route($route), 'arrow-right'];
    }
    $option = 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 aria-selected:bg-indigo-50 aria-selected:text-gray-900';
@endphp
<dialog id="command-palette" aria-label="{{ __('Quick find') }}" closedby="any"
        class="mx-auto mt-[12vh] w-[calc(100%-2rem)] max-w-lg rounded-xl bg-white p-0 text-gray-900 shadow-2xl ring-1 ring-black/5 backdrop:bg-black/50"
        data-suggest-url="{{ route('search.suggest') }}">
    <form action="{{ route('smartphones') }}" method="GET" class="border-b border-gray-200">
        <label class="flex items-center gap-3 px-4">
            <x-icon name="search" class="w-5 h-5 text-gray-400"/>
            <span class="sr-only">{{ __('Page or phone') }}</span>
            <input id="command-palette-input" name="q" type="search" autocomplete="off" maxlength="100"
                   placeholder="{{ __('Jump to a page or search phones') }}"
                   role="combobox" aria-autocomplete="list" aria-controls="command-palette-list" aria-expanded="true"
                   class="w-full border-0 bg-transparent! py-4 text-gray-900 shadow-none outline-hidden focus:shadow-none"/>
        </label>
    </form>
    <ul id="command-palette-list" role="listbox" aria-label="{{ __('Quick find') }}" class="max-h-80 overflow-y-auto p-2">
        @foreach ($pages as [$label, $url, $icon])
            <li role="presentation" data-palette-item="{{ $label }}">
                <a id="palette-option-{{ $loop->index }}" role="option" href="{{ $url }}" tabindex="-1" class="{{ $option }}">
                    <x-icon :name="$icon" class="w-5 h-5 text-gray-500"/>{{ $label }}
                </a>
            </li>
        @endforeach
        {{-- command-palette.js adds the matching phones before this entry and points it at the search for what was typed --}}
        <li role="presentation" data-palette-search hidden>
            <a id="palette-option-search" role="option" href="{{ route('smartphones') }}" tabindex="-1" class="{{ $option }}"
               data-template="{{ __('Search phones for “:query”') }}">
                <x-icon name="search" class="w-5 h-5 text-gray-500"/><span data-palette-search-label></span>
            </a>
        </li>
    </ul>
    <p class="flex flex-wrap gap-x-3 gap-y-1 border-t border-gray-100 px-4 py-2 text-xs text-gray-500">
        <span><kbd>↑</kbd> <kbd>↓</kbd> {{ __('to move') }}</span>
        <span><kbd>Enter</kbd> {{ __('to open') }}</span>
        <span><kbd>Esc</kbd> {{ __('to close') }}</span>
    </p>
</dialog>
