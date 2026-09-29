<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Email Verification') ])
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

            <div class="bg-white shadow-xl rounded-2xl p-8 space-y-6">
                <h1 class="text-2xl font-bold text-center text-gray-900">
                    {{ __('Email Verification') }}
                </h1>

                <p class="text-center text-sm text-gray-600">
                    {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you. If you didn\'t receive the email, we will gladly send you another.') }}
                </p>

                @if (session('status') == 'verification-link-sent')
                    <p class="text-center text-sm font-medium text-green-600">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </p>
                @endif

                {{-- Resend Button --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-xs text-sm font-medium text-white bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-xs text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
