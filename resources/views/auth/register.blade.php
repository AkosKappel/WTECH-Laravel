<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Registration') ])
</head>

<body class="font-sans bg-gradient-to-br from-indigo-50 to-purple-50 text-gray-900">
    <main class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ url('wtech/images/logo.png') }}" alt="{{ __('Logo') }}" class="h-12 mx-auto"/>
                </a>
            </div>

            <form method="POST" action="{{ route('register') }}" class="bg-white shadow-xl rounded-2xl p-8 space-y-6">
                @csrf

                <h1 class="text-2xl font-bold text-center text-gray-900">
                    {{ __('Create Account') }}
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
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                        />
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        {{ __('Password') }}
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            class="w-full px-4 py-2 pl-4 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('password') border-red-500 @enderror"
                            placeholder="{{ __('Enter your password') }}"
                            required
                            autocomplete="new-password"
                        />
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ __('Sign Up') }}
                    </button>
                </div>

                {{-- Divider --}}
                <div class="relative py-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-white text-sm text-gray-500">
                            {{ __('or') }}
                        </span>
                    </div>
                </div>

                {{-- Login Link --}}
                <div class="text-center space-y-4">
                    <p class="text-sm text-gray-600">
                        {{ __('Already have an account?') }}
                    </p>
                    <a href="{{ route('login') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ __('Sign In') }}
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
