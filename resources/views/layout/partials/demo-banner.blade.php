{{-- Demo Notice --}}
<div class="bg-yellow-100 border-b border-yellow-200 text-yellow-900" role="note">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 text-center text-xs sm:text-sm">
        <span class="font-semibold">{{ __('Demo shop') }}</span>
        <span class="mx-1" aria-hidden="true">·</span>
        {{ __('A portfolio project – no real orders, payments or deliveries. Please don\'t enter real personal data.') }}
        <a href="{{ route('about') }}" class="font-semibold underline hover:text-yellow-700 whitespace-nowrap">
            {{ __('Learn more') }}
        </a>
    </div>
</div>
