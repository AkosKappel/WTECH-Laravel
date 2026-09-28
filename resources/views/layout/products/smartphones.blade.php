<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => $filters->pageTitle()])
</head>

<body class="bg-gray-50">
    @include('layout.partials.header')

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
                            @include('layout.products.partials.filters')
                        </form>
                        {{-- restore collapsed sections before the first paint --}}
                        <script>
                            (function () {
                                try {
                                    var closedSections = JSON.parse(localStorage.getItem('catalog.closedFilters') || '[]');
                                    document.querySelectorAll('#filters [data-section]').forEach(function (section) {
                                        if (closedSections.indexOf(section.dataset.section) !== -1) section.querySelector('details').removeAttribute('open');
                                    });
                                } catch (e) {}
                            })();
                        </script>
                    </div>
                </div>
            </aside>

            {{-- Results --}}
            <main class="lg:col-span-3 mt-6 lg:mt-0">
                <p id="catalog-status" class="sr-only" aria-live="polite" aria-atomic="true"></p>
                <div id="catalog-results" class="catalog-results bg-white rounded-lg shadow-sm p-6">
                    @include('layout.products.partials.results')
                </div>
            </main>
        </div>
    </div>

    @include('layout.partials.footer')

    <script src="{{ url('wtech/js/catalog-filters.js') }}?v={{ filemtime(public_path('js/catalog-filters.js')) }}" defer></script>
</body>
</html>
