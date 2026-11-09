@use('App\Notifications\WishlistAlert')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Notifications') . ' | SmartTech', 'robots' => 'noindex'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-3xl mx-auto space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Notifications') }}</h1>
                @if (Auth::user()->unreadNotifications()->exists())
                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 hover:text-indigo-800"><x-icon name="check" class="w-4 h-4"/>{{ __('Mark all as read') }}</button>
                    </form>
                @endif
            </div>

            <p class="text-gray-600">{{ __('When a phone on your wishlist is back in stock or gets cheaper, you will find it here.') }}</p>
            @include('layout.partials.mail-disabled-notice')

            @forelse ($notifications as $notification)
                <div class="flex items-start gap-4 bg-white shadow-xs rounded-lg p-5 border {{ $notification->read_at ? 'border-transparent' : 'border-indigo-200' }}">
                    <x-icon :name="$notification->data['reason'] === WishlistAlert::BACK_IN_STOCK ? 'cart' : 'tag'" class="w-6 h-6 text-indigo-600"/>
                    <div class="grow">
                        <a href="{{ route('details', $notification->data['smartphone']) }}" class="text-gray-900 hover:text-indigo-700 {{ $notification->read_at ? '' : 'font-semibold' }}">{{ WishlistAlert::message($notification->data) }}</a>
                        <p class="mt-1 text-sm text-gray-500">
                            @unless ($notification->read_at)<span class="sr-only">{{ __('Unread') }}, </span>@endunless
                            {{ $notification->created_at->timezone(config('demo.reset.timezone'))->format('j. n. Y, H:i') }}
                        </p>
                    </div>
                    @unless ($notification->read_at)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-sm text-gray-500 hover:text-indigo-700 whitespace-nowrap">{{ __('Mark as read') }}</button>
                        </form>
                    @endunless
                </div>
            @empty
                <div class="bg-white shadow-xs rounded-lg p-10 text-center">
                    <x-icon name="bell" class="mx-auto w-10 h-10 text-gray-300"/>
                    <p class="mt-3 text-gray-700">{{ __('No notifications yet.') }}</p>
                    <a href="{{ route('wishlist') }}" class="mt-4 inline-flex px-5 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">{{ __('Wishlist') }}</a>
                </div>
            @endforelse

            {{ $notifications->links('layout.partials.pagination') }}
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
