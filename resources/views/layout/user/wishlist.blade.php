<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Wishlist') . ' | SmartTech', 'robots' => 'noindex'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ __('Wishlist') }}</h1>

        @if ($smartphones->isEmpty())
            <div class="bg-white shadow-xs rounded-lg p-10 text-center">
                <x-icon name="heart" class="mx-auto w-10 h-10 text-gray-300"/>
                <p class="mt-3 text-gray-700">{{ __('Your wishlist is empty. Tap the heart on a phone you like.') }}</p>
                <a href="{{ route('smartphones') }}" class="mt-4 inline-flex px-5 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">{{ __('Browse phones') }}</a>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($smartphones as $smartphone)
                    <div class="flex flex-col gap-2">
                        @include('layout.partials.product-card', ['smartphone' => $smartphone])
                        <form method="POST" action="{{ route('wishlist.toggle', $smartphone) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-red-600"><x-icon name="trash" class="w-4 h-4"/>{{ __('Remove') }}</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    @include('layout.partials.footer')
</body>
</html>
