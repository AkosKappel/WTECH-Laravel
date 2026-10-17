{{-- Announcement of planned maintenance, shown up to 48 hours before it starts --}}
@php $maintenance = \App\Support\Maintenance::upcoming(); @endphp
@if ($maintenance)
    @php $tz = config('demo.reset.timezone'); @endphp
    <div class="bg-indigo-50 border-b border-indigo-100 text-indigo-900 text-sm" role="note">
        <p class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 text-center">
            <span class="font-semibold">{{ __('Planned maintenance') }}:</span>
            {{ $maintenance['starts_at']->timezone($tz)->format('j. n. Y, H:i') }}@if ($maintenance['ends_at'])–{{ $maintenance['ends_at']->timezone($tz)->format('H:i') }}@endif.
            {{ $maintenance['message'] }}
        </p>
    </div>
@endif
