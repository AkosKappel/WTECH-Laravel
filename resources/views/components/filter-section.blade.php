{{-- Collapsible catalog filter section; when collapsed, the header still shows what is selected --}}
@props(['name', 'title', 'selected' => [], 'clearUrl' => null])

<div class="filter-section relative border-b border-gray-200" data-section="{{ $name }}">
    <details open>
        <summary class="flex items-center gap-2 px-4 py-3 cursor-pointer select-none hover:bg-gray-50 {{ $selected ? 'pr-24' : '' }}">
            <svg class="filter-chevron h-4 w-4 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
            <span class="flex-1 min-w-0">
                <span class="flex items-center gap-2 text-sm font-medium text-gray-900">
                    {{ $title }}
                    @if ($selected)
                        <span class="h-2 w-2 rounded-full bg-indigo-600" aria-hidden="true"></span>
                    @endif
                </span>
                @if ($selected)
                    <span class="filter-summary text-xs text-indigo-700 truncate">
                        <span class="sr-only">{{ __('Selected') }}:</span>
                        {{ $summary ?? implode(', ', $selected) }}
                    </span>
                @endif
            </span>
        </summary>
        <fieldset class="px-4 pb-4">
            <legend class="sr-only">{{ $title }}</legend>
            {{ $slot }}
        </fieldset>
    </details>
    @if ($selected && $clearUrl)
        <a href="{{ $clearUrl }}" data-catalog-link
           class="absolute top-3 right-4 px-2 py-0.5 rounded-sm text-xs font-medium text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50"
           aria-label="{{ __('Clear filter: :filter', ['filter' => $title]) }}">{{ __('Clear') }}</a>
    @endif
</div>
