<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('My orders') . ' | SmartTech'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-3xl mx-auto space-y-6">
            <div class="flex items-center justify-between gap-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('My orders') }}</h1>
                <a href="{{ route('profile') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">{{ __('Profile') }}</a>
            </div>

            @forelse ($orders as $order)
                <a href="{{ route('orders.show', $order) }}"
                   class="block bg-white shadow-xs rounded-lg p-5 border border-transparent hover:border-indigo-200 hover:shadow-md transition">
                    <div class="flex flex-wrap items-baseline justify-between gap-2">
                        <span class="flex items-center gap-2"><span class="font-semibold text-gray-900">{{ $order->number }}</span>@include('layout.order.partials.status')</span>
                        <span class="text-sm text-gray-500">{{ $order->created_at->timezone(config('demo.reset.timezone'))->format('j. n. Y, H:i') }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between gap-4">
                        <div class="flex -space-x-2 overflow-hidden">
                            @foreach ($order->smartphones->take(4) as $smartphone)
                                @if ($image = $smartphone->images->first())
                                    <img src="{{ $image->url }}" alt="" loading="lazy" class="h-12 w-12 rounded-full bg-gray-100 ring-2 ring-white object-contain p-1"/>
                                @endif
                            @endforeach
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">{{ trans_choice(':count item|:count items', $order->smartphones->sum('pivot.count'), ['count' => $order->smartphones->sum('pivot.count')]) }}</p>
                            <p class="font-semibold text-gray-900">{{ formattedPrice($order->total_price) }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white shadow-xs rounded-lg p-10 text-center">
                    <p class="text-gray-700">{{ __('You have not placed any orders yet.') }}</p>
                    <a href="{{ route('smartphones') }}" class="mt-4 inline-flex px-5 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">{{ __('Browse phones') }}</a>
                </div>
            @endforelse

            {{ $orders->links('layout.partials.pagination') }}
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
