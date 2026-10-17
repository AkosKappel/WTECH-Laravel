{{-- Status badge of an order --}}
<span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium whitespace-nowrap {{ \App\Models\Order::STATUS_STYLES[$order->status] ?? '' }}">{{ \App\Models\Order::statusLabel($order->status) }}</span>
