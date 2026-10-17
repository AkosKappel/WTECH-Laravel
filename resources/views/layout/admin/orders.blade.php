<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Orders') . ' | SmartTech'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow py-12">
        @include('layout.admin.partials.nav')

        <div class="mx-auto w-11/12 2xl:w-4/5 space-y-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Orders') }}</h1>

            {{-- Shop figures --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach ([
                    __('Orders') => number_format($stats['orders']),
                    __('Revenue') => formattedPrice($stats['revenue']),
                    __('Customers') => number_format($stats['customers']),
                ] as $label => $value)
                    <div class="bg-white rounded-lg shadow-xs p-5">
                        <p class="text-sm text-gray-500">{{ $label }}</p>
                        <p class="mt-1 text-2xl font-bold text-gray-900">{{ $value }}</p>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <section class="bg-white rounded-lg shadow-xs p-5">
                    <h2 class="font-semibold text-gray-900 mb-3">{{ __('Best sellers') }}</h2>
                    <ol class="space-y-2 text-sm">
                        @forelse ($topProducts as $smartphone)
                            <li class="flex justify-between gap-4">
                                <a href="{{ route('details', $smartphone) }}" class="text-gray-700 hover:text-indigo-600 truncate">{{ $smartphone->name }}</a>
                                <span class="text-gray-500 whitespace-nowrap">{{ __(':count sold', ['count' => $smartphone->units_sold]) }}</span>
                            </li>
                        @empty
                            <li class="text-gray-500">{{ __('No orders yet.') }}</li>
                        @endforelse
                    </ol>
                </section>
                <section class="bg-white rounded-lg shadow-xs p-5">
                    <h2 class="font-semibold text-gray-900 mb-3">{{ __('Low stock') }}</h2>
                    <ul class="space-y-2 text-sm">
                        @forelse ($lowStock as $smartphone)
                            <li class="flex justify-between gap-4">
                                <a href="{{ route('smartphones.edit', $smartphone) }}" class="text-gray-700 hover:text-indigo-600 truncate">{{ $smartphone->name }}</a>
                                <span class="whitespace-nowrap {{ $smartphone->quantity <= 0 ? 'text-red-600 font-medium' : 'text-yellow-700' }}">
                                    {{ $smartphone->quantity <= 0 ? __('Out of stock') : __('Only :count left', ['count' => (int) $smartphone->quantity]) }}
                                </span>
                            </li>
                        @empty
                            <li class="text-gray-500">{{ __('All phones are well stocked.') }}</li>
                        @endforelse
                    </ul>
                </section>
            </div>

            {{-- Order list --}}
            <section class="bg-white rounded-lg shadow-xs overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-medium">{{ __('Order number') }}</th>
                            <th scope="col" class="px-5 py-3 font-medium">{{ __('Date') }}</th>
                            <th scope="col" class="px-5 py-3 font-medium">{{ __('Customer') }}</th>
                            <th scope="col" class="px-5 py-3 font-medium">{{ __('Status') }}</th>
                            <th scope="col" class="px-5 py-3 font-medium text-right">{{ __('Products') }}</th>
                            <th scope="col" class="px-5 py-3 font-medium text-right">{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3"><a href="{{ route('orders.show', $order) }}" class="font-medium text-indigo-600 hover:text-indigo-800">{{ $order->number }}</a></td>
                                <td class="px-5 py-3 whitespace-nowrap text-gray-600">{{ $order->created_at->timezone(config('demo.reset.timezone'))->format('j. n. Y, H:i') }}</td>
                                <td class="px-5 py-3 text-gray-700">{{ trim($order->user->first_name . ' ' . $order->user->last_name) ?: $order->user->email }}</td>
                                <td class="px-5 py-3">@include('layout.order.partials.status')</td>
                                <td class="px-5 py-3 text-right text-gray-600">{{ $order->smartphones_count }}</td>
                                <td class="px-5 py-3 text-right font-medium text-gray-900 whitespace-nowrap">{{ formattedPrice($order->total_price) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-8 text-center text-gray-500">{{ __('No orders yet.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            {{ $orders->links('layout.partials.pagination') }}
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
