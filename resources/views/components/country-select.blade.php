{{-- Country picker: a plain <select> (works without JavaScript, and is what the form submits) that
     public/js/country-select.js turns into a searchable list. Values are the English names. --}}
@props(['value' => null, 'invalid' => false])
<div class="relative" data-country-select data-empty="{{ __('No country found') }}">
    <select {{ $attributes->merge(['class' => 'w-full px-3 py-2 rounded-lg border bg-white focus:border-indigo-500 ' . ($invalid ? 'border-red-500' : 'border-gray-300')]) }}>
        <option value="">{{ __('Choose a country') }}</option>
        @foreach (\App\Support\Address::countries() as $english => $label)
            <option value="{{ $english }}" @selected($value === $english)>{{ $label }}</option>
        @endforeach
    </select>
</div>
@once
    <script src="{{ asset('js/country-select.js') }}?v={{ filemtime(public_path('js/country-select.js')) }}" defer></script>
@endonce
