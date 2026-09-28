{{-- Contents of the catalog filter form; re-rendered by catalog-filters.js after every change --}}
@if ($filters->q !== '')
    <input type="hidden" name="q" value="{{ $filters->q }}">
@endif
@if ($filters->sort)
    <input type="hidden" name="sort" value="{{ $filters->sort }}">
@endif

{{-- Availability --}}
<div class="px-4 py-3 border-b border-gray-200">
    <label class="flex items-center justify-between cursor-pointer">
        <span class="text-sm font-medium text-gray-900">{{ __('In stock only') }}</span>
        <span class="flex items-center gap-2">
            <span class="text-xs text-gray-400">{{ $facets['stock'] }}</span>
            <input type="checkbox" name="stock" value="in" class="toggle-input sr-only" {{ $filters->inStock ? 'checked' : '' }}>
            <span class="toggle" aria-hidden="true"></span>
        </span>
    </label>
</div>

{{-- Price --}}
<x-filter-section name="price" :title="__('Price')" :selected="$filters->selectedLabels('price')" :clear-url="$filters->clearUrl('price')">
    <div class="price-range relative h-6" data-min="{{ $priceBounds[0] }}" data-max="{{ $priceBounds[1] }}">
        <div class="price-range-track"></div>
        <div class="price-range-fill"></div>
        <input type="range" min="{{ $priceBounds[0] }}" max="{{ $priceBounds[1] }}" step="10" value="{{ $filters->priceMin ?? $priceBounds[0] }}" data-thumb="min" aria-label="{{ __('Minimum price') }}" tabindex="-1">
        <input type="range" min="{{ $priceBounds[0] }}" max="{{ $priceBounds[1] }}" step="10" value="{{ $filters->priceMax ?? $priceBounds[1] }}" data-thumb="max" aria-label="{{ __('Maximum price') }}" tabindex="-1">
    </div>
    <div class="mt-3 flex items-center gap-2">
        <label class="flex-1">
            <span class="block text-xs text-gray-500">{{ __('From') }} (€)</span>
            <input type="number" name="price_min" min="{{ $priceBounds[0] }}" max="{{ $priceBounds[1] }}" step="1" inputmode="numeric" data-price="min"
                   value="{{ $filters->priceMin !== null ? (int) $filters->priceMin : '' }}" placeholder="{{ $priceBounds[0] }}"
                   class="mt-1 w-full rounded-md border border-gray-300 px-2 py-1 text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
        </label>
        <span class="pt-5 text-gray-400" aria-hidden="true">–</span>
        <label class="flex-1">
            <span class="block text-xs text-gray-500">{{ __('To') }} (€)</span>
            <input type="number" name="price_max" min="{{ $priceBounds[0] }}" max="{{ $priceBounds[1] }}" step="1" inputmode="numeric" data-price="max"
                   value="{{ $filters->priceMax !== null ? (int) $filters->priceMax : '' }}" placeholder="{{ $priceBounds[1] }}"
                   class="mt-1 w-full rounded-md border border-gray-300 px-2 py-1 text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
        </label>
    </div>
</x-filter-section>

{{-- Brand --}}
<x-filter-section name="brand" :title="__('Brand')" :selected="$filters->selectedLabels('brand')" :clear-url="$filters->clearUrl('brand')">
    <input type="search" data-brand-search placeholder="{{ __('Search brands…') }}" aria-label="{{ __('Search brands…') }}" autocomplete="off"
           class="js-only mb-2 w-full rounded-md border border-gray-300 px-2 py-1 text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
    <ul class="space-y-1 max-h-64 overflow-y-auto pr-1" data-brand-list>
        @foreach ($filters->brandOptions() as $slug => $name)
            @php $count = $facets['brand'][$slug] ?? 0; $checked = in_array($slug, $filters->brands, true); @endphp
            <li data-brand-name="{{ $name }}">
                <label class="flex items-center gap-2 px-1 py-1 rounded-md cursor-pointer hover:bg-gray-50 {{ $count === 0 && !$checked ? 'opacity-40' : '' }}">
                    <input type="checkbox" name="brand[]" value="{{ $slug }}" {{ $checked ? 'checked' : '' }}
                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    @include('layout.partials.brand-logo', ['brand' => (object) ['name' => $name, 'logo_url' => \App\Support\CatalogFilters::brandLogoUrl($slug)], 'size' => 'w-6 h-6'])
                    <span class="flex-grow text-sm text-gray-700">{{ $name }}</span>
                    <span class="text-xs text-gray-400">{{ $count }}</span>
                </label>
            </li>
        @endforeach
    </ul>
    <p class="hidden text-xs text-gray-500 px-1" data-brand-empty>{{ __('No brand matches.') }}</p>
</x-filter-section>

{{-- Colour --}}
<x-filter-section name="color" :title="__('Color')" :selected="$filters->selectedLabels('color')" :clear-url="$filters->clearUrl('color')">
    @if ($filters->colors)
        <x-slot name="summary">
            @foreach ($filters->colors as $color)
                <span class="inline-flex items-center gap-1 mr-1"><span class="chip-dot" style="background-color: {{ \App\Models\Color::hex($color) }}" aria-hidden="true"></span>{{ \Illuminate\Support\Str::ucfirst(__($color)) }}</span>
            @endforeach
        </x-slot>
    @endif
    <div class="flex flex-wrap gap-2">
        @foreach ($filters->colorOptions() as $color)
            @php $count = $facets['color'][$color] ?? 0; $checked = in_array($color, $filters->colors, true); @endphp
            <label class="swatch {{ $count === 0 && !$checked ? 'is-empty' : '' }}" title="{{ \Illuminate\Support\Str::ucfirst(__($color)) }} ({{ $count }})">
                <input type="checkbox" name="color[]" value="{{ $color }}" class="sr-only" {{ $checked ? 'checked' : '' }}>
                <span class="swatch-dot" style="background-color: {{ \App\Models\Color::hex($color) }}"></span>
                <span class="sr-only">{{ __($color) }}</span>
            </label>
        @endforeach
    </div>
</x-filter-section>

{{-- RAM, display size, operating system --}}
@foreach ([
    'ram' => [__('RAM'), \App\Support\CatalogFilters::RAM],
    'display' => [__('Display size'), \App\Support\CatalogFilters::DISPLAY],
    'os' => [__('Operating system'), \App\Support\CatalogFilters::OS],
] as $filter => [$title, $options])
    <x-filter-section :name="$filter" :title="$title" :selected="$filters->selectedLabels($filter)" :clear-url="$filters->clearUrl($filter)">
        <div class="flex flex-wrap gap-2">
            @foreach ($options as $option)
                @php $count = $facets[$filter][$option] ?? 0; $checked = in_array($option, $filters->$filter, true); @endphp
                <label class="pill {{ $count === 0 && !$checked ? 'opacity-40' : '' }}">
                    <input type="checkbox" name="{{ $filter }}[]" value="{{ $option }}" class="sr-only" {{ $checked ? 'checked' : '' }}>
                    <span>{{ $filters->optionLabel($filter, $option) }} <span class="pill-count">{{ $count }}</span></span>
                </label>
            @endforeach
        </div>
    </x-filter-section>
@endforeach

{{-- Actions --}}
<div class="p-4 flex gap-3">
    <button type="submit" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors" data-apply>
        {{ __('Apply Filters') }}
    </button>
    @if ($filters->hasActiveFilters())
        <a href="{{ route('smartphones') }}" data-catalog-link class="flex-1 text-center bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors">
            {{ __('Clear all') }}
        </a>
    @endif
</div>
