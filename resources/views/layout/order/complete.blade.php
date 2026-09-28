<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Order Confirmed') . ' | SmartTech'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-3xl mx-auto space-y-8">
            @if (session()->has('success_message'))
                <div class="rounded-lg bg-green-50 border border-green-200 p-4 text-sm font-medium text-green-800" role="status">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            {{-- Confirmation Header --}}
            <div class="text-center">
                <div class="mx-auto h-16 w-16 rounded-full bg-linear-to-r from-indigo-600 to-purple-600 flex items-center justify-center">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="mt-6 text-3xl font-bold text-gray-900">
                    {{ __('Thank you for your order') }}@if ($order->user->first_name), {{ $order->user->first_name }}@endif!
                </h1>
                <p class="mt-2 text-gray-600">
                    {{ __('Order number') }}
                    <span class="font-semibold text-gray-900">{{ $order->number }}</span>
                    · {{ $order->created_at->timezone(config('demo.reset.timezone'))->format('j. n. Y, H:i') }}
                </p>
            </div>

            {{-- Demo Notice --}}
            <div class="rounded-lg bg-yellow-50 border border-yellow-200 p-4 text-sm text-yellow-900" role="note">
                <span class="font-semibold">{{ __('This was a demo order.') }}</span>
                {{ __('Nothing will be shipped and no payment will be taken. In a real shop you would now receive a confirmation e-mail.') }}
                @include('layout.partials.reset-notice')
            </div>

            {{-- Ordered Items --}}
            <section class="bg-white shadow-xs rounded-lg overflow-hidden">
                <h2 class="px-6 py-4 text-lg font-semibold text-gray-900 border-b border-gray-100">{{ __('Order summary') }}</h2>
                <ul class="divide-y divide-gray-100">
                    @foreach ($order->smartphones as $smartphone)
                        @php $unitPrice = $smartphone->pivot->price ?? $smartphone->price; @endphp
                        <li class="px-6 py-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 min-w-0">
                                @if ($smartphone->images->first())
                                    <img src="{{ $smartphone->images->first()->url }}"
                                         alt="{{ $smartphone->name }}" class="h-16 w-16 object-contain shrink-0"/>
                                @endif
                                <div class="min-w-0">
                                    <a href="{{ route('details', $smartphone) }}" class="font-medium text-gray-900 hover:text-indigo-600">{{ $smartphone->name }}</a>
                                    <p class="text-sm text-gray-500">{{ $smartphone->pivot->count }} × {{ formattedPrice($unitPrice) }}</p>
                                </div>
                            </div>
                            <span class="font-medium text-gray-900 whitespace-nowrap">{{ formattedPrice($unitPrice * $smartphone->pivot->count) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="px-6 py-4 bg-gray-50 space-y-1">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>{{ __('Shipping') }}</span>
                        <span>{{ __('Free') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900">
                        <span>{{ __('Total') }}</span>
                        <span>{{ formattedPrice($order->total_price) }}</span>
                    </div>
                </div>
            </section>

            {{-- Delivery & Payment --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <section class="bg-white shadow-xs rounded-lg p-6">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-3">{{ __('Delivery') }}</h2>
                    <p class="font-medium text-gray-900">{{ __($order->delivery_method) }}</p>
                    <address class="mt-2 not-italic text-sm text-gray-600 leading-relaxed">
                        {{ $order->user->first_name }} {{ $order->user->last_name }}<br>
                        {{ $order->user->street }} {{ $order->user->descriptive_number }}<br>
                        {{ $order->user->city }}, {{ $order->user->country }}<br>
                        {{ $order->user->phone_number }}
                    </address>
                </section>
                <section class="bg-white shadow-xs rounded-lg p-6">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-3">{{ __('Payment') }}</h2>
                    <p class="font-medium text-gray-900">{{ __($order->payment_method) }}</p>
                    <p class="mt-2 text-sm text-gray-600">{{ __('Not charged – demo order.') }}</p>
                    <p class="mt-4 text-sm text-gray-600">{{ __('Confirmation for') }} <span class="font-medium text-gray-900">{{ $order->user->email }}</span></p>
                </section>
            </div>

            {{-- Create Account (guests who ticked the checkbox at checkout) --}}
            @if ($canCreateAccount)
                <section class="bg-white shadow-xs rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Create your account') }}</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Choose a password to save your details for the next order. Your account will use') }}
                        <span class="font-medium text-gray-900">{{ $order->user->email }}</span>.
                    </p>

                    @if ($errors->any())
                        <ul class="mt-4 rounded-lg bg-red-50 p-4 text-sm text-red-700 list-disc list-inside space-y-1" role="alert">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <form method="POST" action="{{ route('storeAfterOrder') }}" class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @csrf
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                            <input id="password" name="password" type="password" required autocomplete="new-password"
                                   class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"/>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                   class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"/>
                        </div>
                        <div class="sm:col-span-2">
                            <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Create account') }}
                            </button>
                        </div>
                    </form>
                </section>
            @endif

            {{-- Next Steps --}}
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('smartphones') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700">
                    {{ __('Continue shopping') }}
                </a>
                @auth
                    <a href="{{ route('profile') }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                        {{ __('Go to your profile') }}
                    </a>
                @endauth
            </div>
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
