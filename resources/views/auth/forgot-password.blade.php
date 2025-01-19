<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Password Recovery') ])
</head>

<body class="font-sans bg-gradient-to-br from-indigo-50 to-purple-50 text-gray-900">
    <main class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ url('wtech/images/logo.png') }}" alt="{{ __('Logo') }}" class="h-12 mx-auto"/>
                </a>
            </div>

            <form method="GET" action="{{--  --}}" class="bg-white shadow-xl rounded-2xl p-8 space-y-6">
                <h1 class="text-2xl font-bold text-center text-gray-900">
                    {{ __('Password Recovery') }}
                </h1>

                {{-- Email Field --}}
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        {{ __('Email') }}
                    </label>
                    <div class="relative">
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            class="w-full px-4 py-2 pl-4 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('email') border-red-500 @enderror"
                            placeholder="{{ __('Enter your email') }}"
                            required
                            autocomplete="email"
                        />
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <img src="{{ url('wtech/images/email.png') }}" alt="Email" class="w-6 h-6" />
                        </div>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Session Status --}}
                <x-auth-session-status class="text-center my-4 text-green-600" :status="session('status')" />

                {{-- Validation Errors --}}
                <x-auth-validation-errors class="text-center my-4 text-red-600" :errors="$errors" />

                <p class="text-center text-sm text-gray-600">
                    {{ __('Enter your registered email address. A password reset link will be sent to your email.') }}
                </p>

                {{-- Submit Button --}}
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ __('Recover Password') }}
                    </button>
                </div>

                {{-- Back to Login Link --}}
                <div class="text-center space-y-4">
                    <p class="text-sm text-gray-600">
                        {{ __('Remember your password?') }}
                    </p>
                    <a href="{{ route('login') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ __('Back to Login') }}
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
