{{-- Brand logo from public/images/brands, or the brand's first letter when there is no logo file --}}
<div class="{{ $size ?? 'w-16 h-16' }} bg-white rounded-full flex items-center justify-center shadow-inner">
    @if ($brand->logo_url)
        <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }} logo" class="w-3/5 h-3/5 object-contain opacity-80 group-hover:opacity-100 transition-opacity" loading="lazy"/>
    @else
        <span class="text-3xl font-bold text-indigo-600" aria-hidden="true">{{ mb_substr($brand->name, 0, 1) }}</span>
    @endif
</div>
