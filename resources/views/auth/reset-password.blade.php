<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Reset Password')])
</head>

<body class="font-sans bg-linear-to-br from-indigo-50 to-purple-50 text-gray-900">
    @include('layout.partials.demo-banner')
    <main class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ __('Logo') }}" class="h-12 mx-auto"/>
                </a>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="bg-white shadow-xl rounded-2xl p-8 space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <h1 class="text-2xl font-bold text-center text-gray-900">
                    {{ __('Reset Password') }}
                </h1>

                <p class="text-center text-sm text-gray-600">
                    {{ __('Choose a new password for your account.') }}
                </p>

                {{-- Email --}}
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('email') border-red-500 @enderror"
                           placeholder="{{ __('Enter your email') }}" required autocomplete="email"/>
                    @error('email')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New password --}}
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('New password') }}</label>
                    <input type="password" id="password" name="password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('password') border-red-500 @enderror"
                           placeholder="{{ __('Enter your new password') }}" required autofocus autocomplete="new-password"/>
                    @error('password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm password --}}
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                           placeholder="{{ __('Enter your new password again') }}" required autocomplete="new-password"/>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-xs text-sm font-medium text-white bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ __('Reset Password') }}
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ __('Back to Login') }}</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
