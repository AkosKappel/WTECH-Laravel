{{--
    Shared layout for the error pages. 4xx pages use the full shop header and footer;
    5xx pages ($minimal) avoid anything that needs the database or the session.
--}}
@php $minimal = $minimal ?? false; @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => $code . ' · ' . $heading . ' | SmartTech'])
    <meta name="robots" content="noindex">
</head>
<body class="font-sans text-gray-800 bg-gray-50 flex flex-col min-h-screen">
    @if ($minimal)
        <header class="bg-linear-to-r from-indigo-600 to-purple-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center">
                <a href="{{ url('wtech') }}" class="flex items-center" aria-label="{{ __('Home') }}">
                    <img src="{{ url('wtech/images/logo.png') }}" alt="{{ __('Logo') }}" class="h-8 w-auto"/>
                    <span class="ml-3 text-3xl font-bold italic text-white tracking-tight">SmartTech</span>
                </a>
            </div>
        </header>
    @else
        @include('layout.partials.header')
    @endif

    <main class="grow py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
                </svg>
            </div>
            <p class="mt-6 text-sm font-semibold uppercase tracking-widest text-indigo-600">{{ __('Error :code', ['code' => $code]) }}</p>
            <h1 class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900">{{ $heading }}</h1>
            <p class="mt-4 text-lg text-gray-600">{{ $message }}</p>

            @yield('details')

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                @section('actions')
                    <a href="{{ url('wtech') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-indigo-600 text-sm font-medium text-white shadow-xs hover:bg-indigo-700 transition-colors">{{ __('Go to homepage') }}</a>
                    <a href="{{ url('wtech/smartphones') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-white text-sm font-medium text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50 transition-colors">{{ __('Browse phones') }}</a>
                @show
            </div>

            @unless ($hideSearch ?? false)
                <form method="GET" action="{{ url('wtech/smartphones') }}" class="mt-8 mx-auto max-w-md flex gap-2" role="search">
                    <label for="error-search" class="sr-only">{{ __('Search smartphones') }}</label>
                    <input id="error-search" type="search" name="q" placeholder="{{ __('Search smartphone...') }}" value="{{ $searchValue ?? '' }}"
                           class="flex-1 rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"/>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-gray-900 text-sm font-medium text-white hover:bg-gray-700">{{ __('Search') }}</button>
                </form>
            @endunless
        </div>

        @yield('below')
    </main>

    @unless ($minimal)
        @include('layout.partials.footer')
    @endunless
</body>
</html>
