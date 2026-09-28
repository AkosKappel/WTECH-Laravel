{{-- Language switcher. $variant: 'dropdown' (desktop header) or 'list' (mobile menu). Each option posts to locale.switch. --}}
@php
    $locales = config('app.locales');
    $current = app()->getLocale();
@endphp

@if (($variant ?? 'dropdown') === 'dropdown')
    <details class="locale-switcher relative">
        <summary class="flex items-center gap-2 px-3 py-2 rounded-full text-sm font-medium text-white hover:bg-white/10 cursor-pointer select-none transition-colors"
                 aria-label="{{ __('Language') }}: {{ $locales[$current]['name'] }}">
            <img src="{{ url('wtech/images/flags/' . $locales[$current]['flag'] . '.svg') }}" alt="" class="h-4 w-6 rounded-xs shadow-xs object-cover"/>
            <span class="uppercase">{{ $current }}</span>
            <svg class="h-4 w-4 text-indigo-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </summary>
        <div class="absolute right-0 mt-2 w-48 py-2 bg-white rounded-lg shadow-xl ring-1 ring-black/5 z-50">
            @foreach ($locales as $code => $locale)
                <form method="POST" action="{{ route('locale.switch', $code) }}">
                    @csrf
                    <button type="submit" lang="{{ $code }}"
                            class="flex items-center gap-3 w-full px-4 py-2 text-sm text-left {{ $code === $current ? 'font-semibold text-indigo-700 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50' }}"
                            @if ($code === $current) aria-current="true" @endif>
                        <img src="{{ url('wtech/images/flags/' . $locale['flag'] . '.svg') }}" alt="" class="h-4 w-6 rounded-xs shadow-xs object-cover"/>
                        <span class="grow">{{ $locale['name'] }}</span>
                        @if ($code === $current)
                            <svg class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </button>
                </form>
            @endforeach
        </div>
    </details>
@else
    <div class="flex flex-wrap gap-2 px-3 py-2" role="group" aria-label="{{ __('Language') }}">
        @foreach ($locales as $code => $locale)
            <form method="POST" action="{{ route('locale.switch', $code) }}">
                @csrf
                <button type="submit" lang="{{ $code }}"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium transition-colors {{ $code === $current ? 'bg-white text-indigo-700' : 'text-white border border-white/40 hover:bg-white/10 ' }}"
                        @if ($code === $current) aria-current="true" @endif>
                    <img src="{{ url('wtech/images/flags/' . $locale['flag'] . '.svg') }}" alt="" class="h-3.5 w-5 rounded-xs object-cover"/>
                    {{ $locale['name'] }}
                </button>
            </form>
        @endforeach
    </div>
@endif
