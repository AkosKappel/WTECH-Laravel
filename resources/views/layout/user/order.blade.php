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
                <h1 class="mt-2 text-3xl font-bold text-gray-900 flex flex-wrap items-center gap-3">{{ __('Order') }} {{ $order->number }} @include('layout.order.partials.status')</h1>
                <p class="mt-1 text-gray-600">{{ $order->created_at->timezone(config('demo.reset.timezone'))->format('j. n. Y, H:i') }}</p>
            </div>

            @can('isAdmin')
                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="bg-white shadow-xs rounded-lg p-6 flex flex-wrap items-end gap-3">
                    @csrf
                    @method('PATCH')
                    <label class="grow">
                        <span class="block text-sm font-medium text-gray-700 mb-1">{{ __('Status') }}</span>
                        <select name="status" class="w-full py-2 pl-3 pr-8 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500">
                            @foreach (\App\Models\Order::STATUSES as $status)
                                <option value="{{ $status }}" @selected($order->status === $status)>{{ \App\Models\Order::statusLabel($status) }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700"><x-icon name="check"/>{{ __('Update status') }}</button>
                </form>
            @endcan

            @include('layout.order.partials.summary')
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
