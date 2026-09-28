<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => ($filters->q !== '' ? __('Search: :query', ['query' => $filters->q]) : __('Smartphones')) . ' | SmartTech'])
</head>

<body class="bg-gray-50">
    @include('layout.partials.header')

    @php
        $total = $smartphones->total();
        $sortIcons = [
            'relevance' => 'M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z',
            'newest' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z',
            'price-asc' => 'M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z',
            'price-desc' => 'M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z',
            'name' => 'M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z',
        ];
        $sorts = $filters->q !== '' ? \App\Support\CatalogFilters::SORTS : array_values(array_diff(\App\Support\CatalogFilters::SORTS, ['relevance']));
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            {{-- Sidebar Filters --}}
            <aside class="lg:col-span-1">
                <div class="lg:sticky lg:top-20">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <button type="button" id="filters-toggle" aria-controls="filters" aria-expanded="false"
                                class="w-full flex items-center justify-between p-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-left lg:cursor-default">
                            <span class="text-lg font-semibold text-white">{{ __('Filters') }}</span>
                            <svg class="lg:hidden w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                        </button>

                        <form method="GET" action="{{ route('smartphones') }}" id="filters" class="hidden lg:block catalog-filters">
                            @if ($filters->q !== '')
                                <input type="hidden" name="q" value="{{ $filters->q }}">
                            @endif
                            @if ($filters->sort)
                                <input type="hidden" name="sort" value="{{ $filters->sort }}">
                            @endif

                            {{-- Price --}}
                            <fieldset class="p-4 border-b border-gray-200">
                                <legend class="sr-only">{{ __('Price') }}</legend>
                                <p class="text-sm font-medium text-gray-900 mb-3" aria-hidden="true">{{ __('Price') }}</p>
                                <div class="price-range relative h-6" data-min="{{ $priceBounds[0] }}" data-max="{{ $priceBounds[1] }}">
                                    <div class="price-range-track"></div>
                                    <div class="price-range-fill"></div>
                                    <input type="range" min="{{ $priceBounds[0] }}" max="{{ $priceBounds[1] }}" step="10" value="{{ $filters->priceMin ?? $priceBounds[0] }}" data-thumb="min" aria-label="{{ __('Minimum price') }}" tabindex="-1">
                                    <input type="range" min="{{ $priceBounds[0] }}" max="{{ $priceBounds[1] }}" step="10" value="{{ $filters->priceMax ?? $priceBounds[1] }}" data-thumb="max" aria-label="{{ __('Maximum price') }}" tabindex="-1">
                                </div>
                                <div class="mt-3 flex items-center gap-2">
                                    <label class="flex-1">
                                        <span class="block text-xs text-gray-500">{{ __('From') }} (€)</span>
                                        <input type="number" name="price_min" min="0" step="1" inputmode="numeric" data-price="min"
                                               value="{{ $filters->priceMin !== null ? (int) $filters->priceMin : '' }}" placeholder="{{ $priceBounds[0] }}"
                                               class="mt-1 w-full rounded-md border border-gray-300 px-2 py-1 text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
                                    </label>
                                    <span class="pt-5 text-gray-400" aria-hidden="true">–</span>
                                    <label class="flex-1">
                                        <span class="block text-xs text-gray-500">{{ __('To') }} (€)</span>
                                        <input type="number" name="price_max" min="0" step="1" inputmode="numeric" data-price="max"
                                               value="{{ $filters->priceMax !== null ? (int) $filters->priceMax : '' }}" placeholder="{{ $priceBounds[1] }}"
                                               class="mt-1 w-full rounded-md border border-gray-300 px-2 py-1 text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
                                    </label>
                                </div>
                            </fieldset>

                            {{-- Availability --}}
                            <div class="p-4 border-b border-gray-200">
                                <label class="flex items-center justify-between cursor-pointer">
                                    <span class="text-sm font-medium text-gray-900">{{ __('In stock only') }}</span>
                                    <span class="flex items-center gap-2">
                                        <span class="text-xs text-gray-400">{{ $facets['stock'] }}</span>
                                        <input type="checkbox" name="stock" value="in" class="toggle-input sr-only" {{ $filters->inStock ? 'checked' : '' }}>
                                        <span class="toggle" aria-hidden="true"></span>
                                    </span>
                                </label>
                            </div>

                            {{-- Brand --}}
                            <fieldset class="p-4 border-b border-gray-200">
                                <legend class="text-sm font-medium text-gray-900 mb-3">{{ __('Brand') }}</legend>
                                <input type="search" data-brand-search placeholder="{{ __('Search brands…') }}" aria-label="{{ __('Search brands…') }}" autocomplete="off"
                                       class="hidden js-only mb-2 w-full rounded-md border border-gray-300 px-2 py-1 text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
                                <ul class="space-y-1 max-h-64 overflow-y-auto pr-1" data-brand-list>
                                    @foreach ($filters->brandOptions() as $slug => $name)
                                        @php $count = $facets['brand'][$slug] ?? 0; $checked = in_array($slug, $filters->brands, true); @endphp
                                        <li data-brand-name="{{ $name }}">
                                            <label class="flex items-center gap-2 px-1 py-1 rounded-md cursor-pointer hover:bg-gray-50 {{ $count === 0 && !$checked ? 'opacity-40' : '' }}">
                                                <input type="checkbox" name="brand[]" value="{{ $slug }}" {{ $checked ? 'checked' : '' }}
                                                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                @include('layout.partials.brand-logo', ['brand' => (object) ['name' => $name, 'logo_url' => file_exists(public_path('images/brands/' . $slug . '.svg')) ? url('wtech/images/brands/' . $slug . '.svg') : null], 'size' => 'w-6 h-6'])
                                                <span class="flex-grow text-sm text-gray-700">{{ $name }}</span>
                                                <span class="text-xs text-gray-400">{{ $count }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                                <p class="hidden text-xs text-gray-500 px-1" data-brand-empty>{{ __('No brand matches.') }}</p>
                            </fieldset>

                            {{-- Colour --}}
                            <fieldset class="p-4 border-b border-gray-200">
                                <legend class="text-sm font-medium text-gray-900 mb-3">{{ __('Color') }}</legend>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($filters->colorOptions() as $color)
                                        @php $count = $facets['color'][$color] ?? 0; $checked = in_array($color, $filters->colors, true); @endphp
                                        <label class="swatch {{ $count === 0 && !$checked ? 'is-empty' : '' }}" title="{{ __($color) }} ({{ $count }})">
                                            <input type="checkbox" name="color[]" value="{{ $color }}" class="sr-only" {{ $checked ? 'checked' : '' }}>
                                            <span class="swatch-dot" style="background-color: {{ \App\Models\Color::hex($color) }}"></span>
                                            <span class="sr-only">{{ __($color) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </fieldset>

                            {{-- RAM, display size, operating system --}}
                            @foreach ([
                                'ram' => [__('RAM'), \App\Support\CatalogFilters::RAM, [\App\Support\CatalogFilters::class, 'ramLabel']],
                                'display' => [__('Display size'), \App\Support\CatalogFilters::DISPLAY, [\App\Support\CatalogFilters::class, 'displayLabel']],
                                'os' => [__('Operating system'), \App\Support\CatalogFilters::OS, [\App\Support\CatalogFilters::class, 'osLabel']],
                            ] as $filter => [$title, $options, $label])
                                <fieldset class="p-4 border-b border-gray-200">
                                    <legend class="text-sm font-medium text-gray-900 mb-3">{{ $title }}</legend>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($options as $option)
                                            @php $count = $facets[$filter][$option] ?? 0; $checked = in_array($option, $filters->$filter, true); @endphp
                                            <label class="pill {{ $count === 0 && !$checked ? 'opacity-40' : '' }}">
                                                <input type="checkbox" name="{{ $filter }}[]" value="{{ $option }}" class="sr-only" {{ $checked ? 'checked' : '' }}>
                                                <span>{{ $label($option) }} <span class="pill-count">{{ $count }}</span></span>
                                            </label>
                                        @endforeach
                                    </div>
                                </fieldset>
                            @endforeach

                            {{-- Actions --}}
                            <div class="p-4 flex gap-3">
                                <button type="submit" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors" data-apply>
                                    {{ __('Apply Filters') }}
                                </button>
                                @if ($filters->hasActiveFilters())
                                    <a href="{{ route('smartphones') }}" class="flex-1 text-center bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors">
                                        {{ __('Clear all') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- Results --}}
            <main class="lg:col-span-3 mt-6 lg:mt-0">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ $filters->q !== '' ? __('Results for “:query”', ['query' => $filters->q]) : __('Smartphones') }}
                            </h1>
                            <p class="mt-1 text-sm text-gray-500">{{ trans_choice(':count phone|:count phones', $total, ['count' => $total]) }}</p>
                        </div>

                        {{-- Sort --}}
                        <details class="sort-menu relative self-start sm:self-auto">
                            <summary class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 bg-white hover:bg-gray-50 cursor-pointer select-none">
                                <svg class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="{{ $sortIcons[$filters->sort()] }}" clip-rule="evenodd"/></svg>
                                <span><span class="text-gray-500">{{ __('Sort') }}:</span> {{ \App\Support\CatalogFilters::sortLabel($filters->sort()) }}</span>
                                <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </summary>
                            <ul class="absolute right-0 sm:right-0 left-0 sm:left-auto mt-2 w-60 py-2 bg-white rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 z-40">
                                @foreach ($sorts as $sort)
                                    <li>
                                        <a href="{{ $filters->url(['sort' => $sort === $filters->defaultSort() ? null : $sort]) }}"
                                           class="flex items-center gap-3 px-4 py-2 text-sm {{ $sort === $filters->sort() ? 'font-semibold text-indigo-700 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50' }}"
                                           @if ($sort === $filters->sort()) aria-current="true" @endif>
                                            <svg class="h-4 w-4 {{ $sort === $filters->sort() ? 'text-indigo-600' : 'text-gray-400' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="{{ $sortIcons[$sort] }}" clip-rule="evenodd"/></svg>
                                            {{ \App\Support\CatalogFilters::sortLabel($sort) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </details>
                    </header>

                    {{-- Active filters --}}
                    @if ($chips = $filters->chips())
                        <div class="mb-6 flex flex-wrap items-center gap-2" aria-label="{{ __('Active filters') }}">
                            @foreach ($chips as $chip)
                                <a href="{{ $chip['url'] }}" class="inline-flex items-center gap-1 pl-3 pr-2 py-1 rounded-full bg-indigo-50 text-sm text-indigo-700 hover:bg-indigo-100 transition-colors"
                                   aria-label="{{ __('Remove filter :filter', ['filter' => $chip['label']]) }}">
                                    {{ $chip['label'] }}
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </a>
                            @endforeach
                            <a href="{{ route('smartphones') }}" class="text-sm text-gray-500 hover:text-gray-700 underline ml-1">{{ __('Clear all') }}</a>
                        </div>
                    @endif

                    @if ($total > 0)
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($smartphones as $smartphone)
                                @include('layout.partials.product-card', ['smartphone' => $smartphone])
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                            </svg>
                            <h2 class="mt-4 text-lg font-medium text-gray-900">{{ __('No results found') }}</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Try another spelling, or remove some filters.') }}</p>
                            @if ($filters->hasActiveFilters())
                                <a href="{{ route('smartphones') }}" class="mt-4 inline-flex px-4 py-2 rounded-md bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">{{ __('Show all phones') }}</a>
                            @endif
                        </div>
                    @endif

                    {{-- Pagination --}}
                    <nav class="mt-8">
                        {{ $smartphones->onEachSide(1)->links('layout.partials.pagination') }}
                    </nav>
                </div>
            </main>
        </div>
    </div>

    @include('layout.partials.footer')

    <script src="{{ url('wtech/js/catalog-filters.js') }}?v={{ filemtime(public_path('js/catalog-filters.js')) }}" defer></script>
</body>
</html>
