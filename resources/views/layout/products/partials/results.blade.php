{{-- Catalog results: heading, sort, active filter chips, grid and pagination; re-rendered by catalog-filters.js --}}
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
    $chipIcons = [
        // magnifier, tag (price), chip (RAM), phone (display), cog (OS), check (stock)
        'q' => 'M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z',
        'price' => 'M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z',
        'ram' => 'M13 7H7v6h6V7z M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H9v1a1 1 0 11-2 0v-1H5a2 2 0 01-2-2v-2H2a1 1 0 110-2h1V9H2a1 1 0 010-2h1V5a2 2 0 012-2h2V2zM5 5h10v10H5V5z',
        'display' => 'M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z',
        'os' => 'M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z',
        'stock' => 'M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z',
    ];
@endphp

<header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 focus:outline-hidden" tabindex="-1" data-results-heading>
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
        <ul class="absolute right-0 sm:right-0 left-0 sm:left-auto mt-2 w-60 py-2 bg-white rounded-lg shadow-xl ring-1 ring-black/5 z-40">
            @foreach ($sorts as $sort)
                <li>
                    <a data-catalog-link href="{{ $filters->url(['sort' => $sort === $filters->defaultSort() ? null : $sort]) }}"
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
    <div class="mb-6 flex flex-wrap items-center gap-2" role="group" aria-label="{{ __('Active filters') }}">
        @foreach ($chips as $chip)
            <a href="{{ $chip['url'] }}" data-catalog-link
               class="filter-chip inline-flex items-center gap-1.5 pl-2 pr-2 py-1 rounded-full bg-indigo-50 text-sm text-indigo-700 hover:bg-indigo-100 transition-colors"
               aria-label="{{ __('Remove filter :filter', ['filter' => $chip['label']]) }}">
                @switch($chip['type'])
                    @case('color')
                        <span class="chip-dot" style="background-color: {{ \App\Models\Color::hex($chip['value']) }}" aria-hidden="true"></span>
                        @break
                    @case('brand')
                        @if ($logo = \App\Support\CatalogFilters::brandLogoUrl($chip['value']))
                            <span class="chip-logo" aria-hidden="true"><img src="{{ $logo }}" alt=""></span>
                        @endif
                        @break
                    @default
                        @if (isset($chipIcons[$chip['type']]))
                            <svg class="h-4 w-4 text-indigo-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="{{ $chipIcons[$chip['type']] }}" clip-rule="evenodd"/></svg>
                        @endif
                @endswitch
                <span>{{ $chip['label'] }}</span>
                <svg class="h-4 w-4 opacity-70" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
            </a>
        @endforeach
        <a href="{{ route('smartphones') }}" data-catalog-link class="text-sm text-gray-500 hover:text-gray-700 underline ml-1">{{ __('Clear all') }}</a>
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
            <a href="{{ route('smartphones') }}" data-catalog-link class="mt-4 inline-flex px-4 py-2 rounded-md bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">{{ __('Show all phones') }}</a>
        @endif
    </div>
@endif

{{-- Pagination --}}
<nav class="mt-8">
    {{ $smartphones->onEachSide(1)->links('layout.partials.pagination') }}
</nav>
