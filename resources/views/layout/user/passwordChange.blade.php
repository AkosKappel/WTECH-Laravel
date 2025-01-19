<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Change Password') ])
</head>

<body class="font-sans bg-gradient-to-br from-indigo-50 to-purple-50 text-gray-900">
    <main class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ url('wtech/images/logo.png') }}" alt="{{ __('Logo') }}" class="h-12 mx-auto"/>
                </a>
            </div>

            <form method="POST" action="{{ route('passwordChange') }}" class="bg-white shadow-xl rounded-2xl p-8 space-y-6">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <h1 class="text-2xl font-bold text-center text-gray-900">
                    {{ __('Change Password') }}
                </h1>

                {{-- Current Password Field --}}
                <div class="space-y-2">
                    <label for="currentPassword" class="block text-sm font-medium text-gray-700">
                        {{ __('Current Password') }}
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="currentPassword" 
                            name="oldPassword"
                            class="w-full px-4 py-2 pl-4 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('oldPassword') border-red-500 @enderror"
                            placeholder="{{ __('Enter your current password') }}"
                            required
                            autocomplete="current-password"
                        />
                    </div>
                    @error('oldPassword')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password Field --}}
                <div class="space-y-2">
                    <label for="newPassword" class="block text-sm font-medium text-gray-700">
                        {{ __('New Password') }}
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="newPassword" 
                            name="newPassword"
                            class="w-full px-4 py-2 pl-4 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('newPassword') border-red-500 @enderror"
                            placeholder="{{ __('Enter your new password') }}"
                            required
                            autocomplete="new-password"
                        />
                    </div>
                    @error('newPassword')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ __('Change Password') }}
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

                {{-- Back to Profile Link --}}
                <div class="text-center space-y-4">
                    <p class="text-sm text-gray-600">
                        {{ __('Want to go back?') }}
                    </p>
                    <a href="{{ route('profile') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ __('Back to Profile') }}
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
