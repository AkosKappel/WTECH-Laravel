{{-- Items, total, delivery address and payment of an order. Used on the confirmation page, in the order history and in the admin zone. --}}
{{-- Ordered Items --}}
<section class="bg-white shadow-xs rounded-lg overflow-hidden">
    <h2 class="px-6 py-4 text-lg font-semibold text-gray-900 border-b border-gray-100">{{ __('Order summary') }}</h2>
    <ul class="divide-y divide-gray-100">
        @foreach ($order->smartphones as $smartphone)
            @php $unitPrice = $smartphone->pivot->price ?? $smartphone->price; @endphp
            <li class="px-6 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4 min-w-0">
                    @if ($smartphone->images->first())
                        <img src="{{ $smartphone->images->first()->url }}"
                             alt="{{ $smartphone->name }}" class="h-16 w-16 object-contain shrink-0"/>
                    @endif
                    <div class="min-w-0">
                        <a href="{{ route('details', $smartphone) }}" class="font-medium text-gray-900 hover:text-indigo-600">{{ $smartphone->name }}</a>
                        <p class="text-sm text-gray-500">{{ $smartphone->pivot->count }} × {{ formattedPrice($unitPrice) }}</p>
                    </div>
                </div>
                <span class="font-medium text-gray-900 whitespace-nowrap">{{ formattedPrice($unitPrice * $smartphone->pivot->count) }}</span>
            </li>
        @endforeach
    </ul>
    <div class="px-6 py-4 bg-gray-50 space-y-1">
        @if ($order->discount > 0)
            <div class="flex justify-between text-sm text-gray-600">
                <span>{{ __('Subtotal') }}</span>
                <span>{{ formattedPrice($order->subtotal) }}</span>
            </div>
            <div class="flex justify-between text-sm text-green-700">
                <span>{{ __('Discount') }} ({{ $order->discount_code }})</span>
                <span>−{{ formattedPrice($order->discount) }}</span>
            </div>
        @endif
        <div class="flex justify-between text-sm text-gray-600">
            <span>{{ __('Shipping') }}</span>
            <span>{{ __('Free') }}</span>
        </div>
        <div class="flex justify-between text-lg font-bold text-gray-900">
            <span>{{ __('Total') }}</span>
            <span>{{ formattedPrice($order->total_price) }}</span>
        </div>
    </div>
</section>

{{-- Delivery & Payment --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <section class="bg-white shadow-xs rounded-lg p-6">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-3">{{ __('Delivery') }}</h2>
        <p class="font-medium text-gray-900">{{ __($order->delivery_method) }}</p>
        <address class="mt-2 not-italic text-sm text-gray-600 leading-relaxed">
            {{ $order->user->first_name }} {{ $order->user->last_name }}<br>
            {{ $order->user->street }} {{ $order->user->descriptive_number }}<br>
            {{ $order->user->city }}, {{ $order->user->country }}<br>
            {{ $order->user->phone_number }}
        </address>
    </section>
    <section class="bg-white shadow-xs rounded-lg p-6">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-3">{{ __('Payment') }}</h2>
        <p class="font-medium text-gray-900">{{ __($order->payment_method) }}</p>
        <p class="mt-2 text-sm text-gray-600">{{ __('Not charged – demo order.') }}</p>
        <p class="mt-4 text-sm text-gray-600">{{ __('Confirmation for') }} <span class="font-medium text-gray-900">{{ $order->user->email }}</span></p>
    </section>
</div>
