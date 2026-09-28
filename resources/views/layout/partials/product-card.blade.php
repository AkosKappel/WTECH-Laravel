{{-- Product card for grids. All cards are the same size: a 4:3 image frame, a 2-line name and the price row pinned to the bottom. --}}
@php
    $image = $smartphone->images->first();
    // photos fill the frame; illustrations (SVG) and the placeholder are shown whole on a backdrop
    $isPhoto = $image && !\Illuminate\Support\Str::endsWith($image->source, '.svg');
@endphp
<a href="{{ route('details', $smartphone->id) }}"
   class="group flex flex-col h-full bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-lg hover:border-indigo-200 transition">
    <div class="product-card-media relative overflow-hidden {{ $isPhoto ? 'bg-gray-100' : 'bg-gradient-to-b from-gray-50 to-gray-200 p-5' }}">
        @if ($image)
            <img src="{{ url('wtech/' . ltrim($image->source, '/')) }}"
                 alt="{{ $smartphone->name }}"
                 loading="lazy"
                 class="w-full h-full {{ $isPhoto ? 'object-cover' : 'object-contain' }} object-center transform group-hover:scale-105 transition-transform duration-500"/>
        @else
            <div class="w-full h-full flex flex-col items-center justify-center text-gray-400" role="img" aria-label="{{ __('No image available') }}">
                <svg class="h-12 w-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A1.5 1.5 0 0021.75 19.5V4.5A1.5 1.5 0 0020.25 3H3.75A1.5 1.5 0 002.25 4.5v15A1.5 1.5 0 003.75 21zM14.25 8.625a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                </svg>
                <span class="mt-2 text-sm font-medium">{{ __('No image') }}</span>
            </div>
        @endif
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
