{{-- Shared layout for the information pages (About, Contact, Shipping, ...) --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => $title . ' | SmartTech'])
</head>
<body class="font-sans text-gray-800 bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow py-12 px-4 sm:px-6 lg:px-8">
        <article class="max-w-3xl mx-auto">
            <header class="mb-8">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">{{ $title }}</h1>
                @isset($lead)
                    <p class="mt-3 text-lg text-gray-600">{{ $lead }}</p>
                @endisset
            </header>

            @if ($fictional ?? false)
                <div class="mb-8 rounded-lg bg-yellow-50 border border-yellow-200 p-4 text-sm text-yellow-900" role="note">
                    <span class="font-semibold">{{ __('Demo content.') }}</span>
                    {{ __('SmartTech is not a real shop. The conditions below are fictional and only show what such a page would look like.') }}
                </div>
            @endif

            <div class="space-y-8">
                @yield('content')
            </div>
        </article>
    </main>

    @include('layout.partials.footer')
</body>
</html>
