<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Smartphones') ])
</head>

<body class="bg-gray-50">
    @include('layout.partials.header')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            {{-- Sidebar Filters --}}
            <aside class="lg:col-span-1">
                <div class="sticky top-20">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-indigo-600 to-purple-600">
                            <h2 class="text-lg font-semibold text-white">
                                {{ __('Filters') }}
                            </h2>
                            <button class="lg:hidden text-white hover:text-indigo-100" id="burger-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                        </div>

                        <form method="GET" action="{{ route('smartphones') }}" class="hidden lg:block" id="filters">
                            {{-- Price Filter --}}
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="text-sm font-medium text-gray-900 mb-4">{{ __('Price') }} (€)</h3>
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm text-gray-600" for="min-price">{{ __('Min') }}</label>
                                    <input type="number" 
                                           id="min-price" 
                                           name="min-price" 
                                           min="0" 
                                           value="{{ $params['min-price'] ?? 0 }}"
                                           class="w-20 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                                    <label class="text-sm text-gray-600" for="max-price">{{ __('Max') }}</label>
                                    <input type="number" 
                                           id="max-price" 
                                           name="max-price" 
                                           min="0" 
                                           value="{{ $params['max-price'] }}"
                                           class="w-20 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                                </div>
                            </div>

                            {{-- Brand Filter --}}
                            <div class="p-4 border-b border-gray-200 grid grid-cols-2 gap-x-4 gap-y-2">
                                <h3 class="text-sm font-medium text-gray-900 mb-4 col-span-2">{{ __('Brand') }}</h3>
                                @foreach($params['brands'] as $brand)
                                    <label class="flex items-center">
                                        {{ Form::checkbox($brand['name'], $brand['name'], $brand['status'], [
                                            'id' => $brand['name'],
                                            'class' => 'rounded border-gray-300 text-indigo-600 focus:ring-indigo-500'
                                        ]) }}
                                        <span class="ml-2 text-sm text-gray-600">{{ $brand['name'] }}</span>
                                    </label>
                                @endforeach
                            </div>

                            {{-- Color Filter --}}
                            <div class="p-4 border-b border-gray-200 grid grid-cols-2 gap-x-4 gap-y-2">
                                <h3 class="text-sm font-medium text-gray-900 mb-4 col-span-2">{{ __('Color') }}</h3>
                                @foreach($params['colors'] as $color)
                                    <label class="flex items-center">
                                        {{ Form::checkbox($color['name-en'], $color['name-en'], $color['status'], [
                                            'id' => $color['name-en'],
                                            'class' => 'rounded border-gray-300 text-indigo-600 focus:ring-indigo-500'
                                        ]) }}
                                        <span class="ml-2 flex items-center">
                                            <span class="h-4 w-4 rounded-full border border-gray-200 bg-{{ $color['name-en'] }}-600 bg-{{ $color['name-en'] }}"></span>
                                            <span class="ml-2 text-sm text-gray-600">{{ $color['name-en'] }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            {{-- Sort Options --}}
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="text-sm font-medium text-gray-900 mb-4">{{ __('Sort By') }}</h3>
                                <div class="space-y-2">
                                    @foreach($params['sort'] as $sort)
                                        <label class="flex items-center">
                                            {{ Form::radio('sort', $sort['id'], $sort['status'], [
                                                'id' => $sort['id'],
                                                'class' => 'border-gray-300 text-indigo-600 focus:ring-indigo-500'
                                            ]) }}
                                            <span class="ml-2 text-sm text-gray-600">{{ $sort['name'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="p-4 space-y-3">
                                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors">
                                    {{ __('Apply Filters') }}
                                </button>
                                <a href="{{ route('smartphones') }}" class="block text-center w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors">
                                    {{ __('Reset Filters') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- Main Content --}}
            <main class="lg:col-span-3 mt-8 lg:mt-0">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <header class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">{{ __('Available Smartphones') }}</h1>
                    </header>

                    @if(count($smartphones) > 0)
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($smartphones as $smartphone)
                                <a href="{{ route('details', $smartphone->id) }}" class="group">
                                    <article class="bg-white rounded-lg overflow-hidden border border-gray-200 transition-shadow hover:shadow-lg">
                                        <div class="aspect-w-3 aspect-h-4 bg-gray-200">
                                            @if($smartphone->images->first())
                                                <img src="{{ url('wtech/' . $smartphone->images->first()->source) }}" 
                                                     alt="{{ $smartphone->images->first()->name }}"
                                                     class="h-full w-full object-cover object-center group-hover:opacity-75 transition-opacity"/>
                                            @else
                                                <img src="{{ url('wtech/images/no_img_available.jpg') }}" 
                                                     alt="{{ __('No image available') }}"
                                                     class="h-full w-full object-cover object-center"/>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h2 class="text-lg font-medium text-gray-900">{{ $smartphone->name }}</h2>
                                            <p class="mt-1 text-lg font-semibold text-indigo-600">{{ formattedPrice($smartphone->price) }}</p>
                                        </div>
                                    </article>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-md bg-yellow-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">{{ __('No results found') }}</h3>
                                    <p class="mt-2 text-sm text-yellow-700">{{ __('Try adjusting your search criteria.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Pagination --}}
                    <nav class="mt-8">
                        {{ $smartphones->withQueryString()->onEachSide(1)->links('layout.partials.pagination') }}
                    </nav>
                </div>
            </main>
        </div>
    </div>

    @include('layout.partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const burgerIcon = document.getElementById('burger-icon');
            const filters = document.getElementById('filters');

            burgerIcon.addEventListener('click', function() {
                filters.classList.toggle('hidden');
            });

            // Close filters when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInside = filters.contains(event.target) || burgerIcon.contains(event.target);
                if (!isClickInside && !filters.classList.contains('lg:block') && window.innerWidth < 1024) {
                    filters.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
