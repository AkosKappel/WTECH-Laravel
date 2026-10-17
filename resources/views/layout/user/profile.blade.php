<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('User Profile') . ' | SmartTech', 'robots' => 'noindex'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    @php
        $user = auth()->user();
        $locked = $user->isDemoAdmin();
        $name = trim($user->first_name . ' ' . $user->last_name);
        $initials = mb_strtoupper(mb_substr($user->first_name ?: $user->email, 0, 1) . mb_substr((string) $user->last_name, 0, 1));
        $field = 'w-full px-3 py-2 rounded-lg border bg-white focus:border-indigo-500 disabled:bg-gray-50 disabled:text-gray-500';
        // each field sits in its own wrapper, so what browser extensions add next to it (password
        // manager icons) stays inside and can't push the layout around
        $fields = [
            __('Personal Information') => ['icon' => 'user', 'fields' => [
                ['first_name', __('First Name'), 'text', 'given-name', __('Enter your first name')],
                ['last_name', __('Last Name'), 'text', 'family-name', __('Enter your last name')],
                ['email', __('Email'), 'email', 'email', __('Enter your email')],
                ['phone_number', __('Phone'), 'tel', 'tel', __('Enter your phone number')],
            ]],
            __('Delivery Information') => ['icon' => 'cart', 'fields' => [
                ['street', __('Street'), 'text', 'address-line1', __('Enter street name')],
                ['descriptive_number', __('Street Number'), 'text', 'address-line2', __('Enter street number')],
                ['city', __('City'), 'text', 'address-level2', __('Enter city')],
                ['country', __('Country'), 'text', 'country-name', __('Enter country')],
            ]],
        ];
    @endphp

    <main class="grow max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
        {{-- Who is signed in, and where to go from here --}}
        <section class="bg-white rounded-2xl shadow-xs p-6 flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="h-16 w-16 shrink-0 rounded-full bg-linear-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-xl font-bold text-white" aria-hidden="true">{{ $initials }}</div>
            <div class="grow min-w-0">
                <h1 class="text-2xl font-bold text-gray-900 truncate">{{ $name ?: __('User Profile') }}</h1>
                <p class="text-gray-500 truncate">{{ $user->email }}</p>
            </div>
            <nav class="flex flex-wrap gap-2" aria-label="{{ __('Profile') }}">
                <a href="{{ route('orders') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="cart" class="w-4 h-4"/>{{ __('My orders') }}
                </a>
                <a href="{{ route('wishlist') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="heart" class="w-4 h-4"/>{{ __('Wishlist') }}
                </a>
                @unless ($locked)
                    <a href="{{ route('passwordChange') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <x-icon name="lock" class="w-4 h-4"/>{{ __('Change Password') }}
                    </a>
                @endunless
            </nav>
        </section>

        @if ($locked)
            <p class="rounded-lg bg-yellow-50 border border-yellow-200 p-4 text-sm text-yellow-900" role="note">{{ __('The demo admin account cannot be changed.') }}</p>
        @endif

        <form method="POST" action="{{ route('profile') }}">
            @csrf
            @method('PUT')
            <fieldset @disabled($locked) class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach ($fields as $title => $section)
                    <section class="bg-white rounded-2xl shadow-xs p-6">
                        <h2 class="flex items-center gap-3 text-lg font-semibold text-gray-900 mb-5">
                            <span class="h-9 w-9 rounded-full bg-indigo-50 flex items-center justify-center"><x-icon name="{{ $section['icon'] }}" class="w-5 h-5 text-indigo-600"/></span>
                            {{ $title }}
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($section['fields'] as [$name, $label, $type, $autocomplete, $placeholder])
                                <div class="relative">
                                    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                                    @if ($name === 'country')
                                        <x-country-select id="country" name="country" autocomplete="country-name" :value="old('country', $user->country)" :invalid="$errors->has('country')"/>
                                    @else
                                        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" autocomplete="{{ $autocomplete }}"
                                               value="{{ old($name, $user->$name) }}" placeholder="{{ $placeholder }}" @if ($name === 'email') required @endif
                                               @if ($name === 'phone_number') inputmode="tel" pattern="\+?[0-9][0-9 \(\)\/.\-]{5,23}" title="{{ __('Enter a phone number with 7 to 15 digits, e.g. +421 900 123 456.') }}" @endif
                                               class="{{ $field }} @error($name) border-red-500 @else border-gray-300 @enderror"/>
                                    @endif
                                    @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </fieldset>

            @unless ($locked)
                <div class="mt-6 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3">
                    <p class="text-sm text-gray-500 sm:mr-auto">{{ __('Your address fills in the checkout for you.') }}</p>
                    <button type="submit" class="inline-flex justify-center items-center gap-2 px-6 py-2.5 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors">
                        <x-icon name="check"/>{{ __('Save Changes') }}
                    </button>
                </div>
            @endunless
        </form>
    </main>

    @include('layout.partials.footer')
</body>
</html>
