{{-- Price of a phone: during a sale the sale price, the old price struck through and the discount. $class sizes the current price. --}}
<span class="inline-flex flex-wrap items-baseline gap-x-2">
    <span class="{{ $class ?? '' }} {{ $smartphone->isOnSale() ? 'text-red-600' : 'text-indigo-600' }} font-semibold whitespace-nowrap">{{ formattedPrice($smartphone->current_price) }}</span>
    @if ($smartphone->isOnSale())
        <s class="text-sm text-gray-500 whitespace-nowrap"><span class="sr-only">{{ __('Was') }}</span> {{ formattedPrice($smartphone->price) }}</s>
    @endif
</span>
