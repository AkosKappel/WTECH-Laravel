{{-- Product card for grids. All cards are the same height: fixed image area, 2-line name, price row pinned to the bottom. --}}
@php $image = $smartphone->images->first(); @endphp
<a href="{{ route('details', $smartphone->id) }}"
   class="group flex flex-col h-full bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-lg hover:border-indigo-200 transition">
    <div class="h-56 sm:h-64 flex items-center justify-center bg-white p-4 border-b border-gray-100">
        <img src="{{ $image ? url('wtech/' . ltrim($image->source, '/')) : url('wtech/images/no_img_available.jpg') }}"
             alt="{{ $image ? $smartphone->name : __('No image available') }}"
             loading="lazy"
             class="max-h-full max-w-full object-contain transform group-hover:scale-105 transition-transform duration-300"/>
    </div>
    <div class="flex flex-col flex-grow p-4">
        <h{{ $level ?? 2 }} class="product-card-title text-base font-medium text-gray-900 group-hover:text-indigo-600 transition-colors" title="{{ $smartphone->name }}">
            {{ $smartphone->name }}
        </h{{ $level ?? 2 }}>
        <div class="mt-auto pt-3 flex items-center justify-between gap-2">
            <p class="text-lg font-semibold text-indigo-600 whitespace-nowrap">{{ formattedPrice($smartphone->price) }}</p>
            @if ($smartphone->quantity <= 0)
                <span class="px-2 py-0.5 rounded-full bg-gray-100 text-xs font-medium text-gray-600 whitespace-nowrap">{{ __('Out of stock') }}</span>
            @elseif ($smartphone->quantity <= 3)
                <span class="px-2 py-0.5 rounded-full bg-yellow-100 text-xs font-medium text-yellow-800 whitespace-nowrap">{{ __('Only :count left', ['count' => (int) $smartphone->quantity]) }}</span>
            @endif
        </div>
    </div>
</a>
