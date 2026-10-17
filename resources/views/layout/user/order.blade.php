<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Order') . ' ' . $order->number . ' | SmartTech', 'robots' => 'noindex'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-3xl mx-auto space-y-8">
            <div>
                @if (auth()->id() === $order->user_id)
                    <a href="{{ route('orders') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">← {{ __('My orders') }}</a>
                @else
                    <a href="{{ route('admin.orders') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">← {{ __('Orders') }}</a>
                @endif
                <h1 class="mt-2 text-3xl font-bold text-gray-900">{{ __('Order') }} {{ $order->number }}</h1>
                <p class="mt-1 text-gray-600">{{ $order->created_at->timezone(config('demo.reset.timezone'))->format('j. n. Y, H:i') }}</p>
            </div>

            @include('layout.order.partials.summary')
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
