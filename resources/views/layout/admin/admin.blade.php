<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('All products') . ' | SmartTech'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow py-12">
        @include('layout.admin.partials.nav')

        <div class="mx-auto w-11/12 2xl:w-4/5 space-y-6">
            {{-- Page header --}}
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Products') }}</h1>
                <div class="flex items-center gap-4">
                    @can('isAdmin')
                        <a href="{{ route('admin.error-test') }}" target="_blank" rel="noopener" class="text-xs text-gray-500 hover:text-gray-700 underline"
                           title="{{ __('Opens the error page with the details only admins see') }}">{{ __('Preview error page') }}</a>
                    @endcan
                    @can('create', \App\Models\Smartphone::class)
                        <a href="{{ route('smartphones.add') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white shadow-xs hover:bg-indigo-700 transition-colors">
                            <x-icon name="plus"/>{{ __('Add product') }}
                        </a>
                    @endcan
                </div>
            </div>

            {{-- Search and sort --}}
            <form method="GET" action="{{ route('admin') }}" class="flex flex-col sm:flex-row gap-3">
                <label class="relative grow">
                    <span class="sr-only">{{ __('Search products') }}</span>
                    <x-icon name="search" class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"/>
                    <input type="search" name="q" value="{{ $q }}" placeholder="{{ __('Search products') }}"
                           class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"/>
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    {{ __('Sort by') }}
                    <select name="sort" class="py-2 pl-3 pr-8 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500" onchange="this.form.submit()">
                        @foreach (['name' => __('Name A–Z'), 'price-asc' => __('Price: low to high'), 'price-desc' => __('Price: high to low'), 'stock' => __('Stock: lowest first'), 'newest' => __('Newest')] as $value => $label)
                            <option value="{{ $value }}" @selected($sort === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <noscript><button type="submit" class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-sm">{{ __('Apply') }}</button></noscript>
            </form>

            {{-- Product table --}}
            <section class="bg-white rounded-lg shadow-xs overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th scope="col" class="px-4 py-3 font-medium">{{ __('Product name') }}</th>
                            <th scope="col" class="px-4 py-3 font-medium hidden md:table-cell">{{ __('Brand') }}</th>
                            <th scope="col" class="px-4 py-3 font-medium text-right">{{ __('Unit price') }}</th>
                            <th scope="col" class="px-4 py-3 font-medium">{{ __('Stock') }}</th>
                            <th scope="col" class="px-4 py-3 font-medium text-right"><span class="sr-only">{{ __('Actions') }}</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($smartphones as $product)
                            @php $image = $product->images->first(); @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3 min-w-48">
                                        <div class="h-12 w-12 shrink-0 rounded-md bg-gray-100 flex items-center justify-center overflow-hidden">
                                            @if ($image)
                                                <img src="{{ $image->url }}" alt="" loading="lazy" class="h-full w-full object-contain p-1"/>
                                            @else
                                                <x-icon name="photo" class="w-6 h-6 text-gray-300"/>
                                            @endif
                                        </div>
                                        <a href="{{ route('details', $product) }}" class="font-medium text-gray-900 hover:text-indigo-600">{{ $product->name }}</a>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600 hidden md:table-cell">{{ $product->brand?->name }}</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-900 whitespace-nowrap">{{ formattedPrice($product->price) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if ($product->quantity <= 0)
                                        <span class="px-2 py-0.5 rounded-full bg-red-50 text-xs font-medium text-red-700">{{ __('Out of stock') }}</span>
                                    @elseif ($product->quantity <= 3)
                                        <span class="px-2 py-0.5 rounded-full bg-yellow-100 text-xs font-medium text-yellow-800">{{ __('Only :count left', ['count' => (int) $product->quantity]) }}</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-green-50 text-xs font-medium text-green-700">{{ __(':count in stock', ['count' => (int) $product->quantity]) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        @can('update', $product)
                                            <a href="{{ route('smartphones.edit', $product) }}" class="p-2 rounded-md text-gray-500 hover:bg-indigo-50 hover:text-indigo-700"
                                               aria-label="{{ __('Edit :name', ['name' => $product->name]) }}" title="{{ __('Edit') }}">
                                                <x-icon name="pencil"/>
                                            </a>
                                        @endcan
                                        @can('delete', $product)
                                            <form action="{{ route('smartphones.delete', $product) }}" method="POST"
                                                  data-confirm="{{ __('Delete :name? This cannot be undone.', ['name' => $product->name]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-md text-gray-500 hover:bg-red-50 hover:text-red-700"
                                                        aria-label="{{ __('Delete :name', ['name' => $product->name]) }}" title="{{ __('Delete') }}">
                                                    <x-icon name="trash"/>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-10 text-center text-gray-500">{{ __('No results found') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            {{ $smartphones->onEachSide(1)->links('layout.partials.pagination') }}
        </div>
    </main>

    @include('layout.partials.footer')
    <script>
        // ask before deleting; forms without JavaScript submit directly
        document.querySelectorAll('form[data-confirm]').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!window.confirm(form.dataset.confirm)) event.preventDefault();
            });
        });
    </script>
</body>
</html>
