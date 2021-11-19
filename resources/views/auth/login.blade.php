<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Prihlásenie" ])
</head>
    <body class="font-body text-gray-600 bg-gray-100">
        <main class="flex h-screen">
            <div class="w-10/12 sm:w-full max-w-md mx-auto m-auto">
            <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

{{--                <form method="POST" action="{{ route('login') }}">--}}
{{--                    @csrf--}}

                    <!-- Email Address -->
{{--                    <div>--}}
{{--                        <x-label for="email" :value="__('Email')" />--}}

{{--                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />--}}
{{--                    </div>--}}

                    <!-- Password -->
{{--                    <div class="mt-4">--}}
{{--                        <x-label for="password" :value="__('Password')" />--}}

{{--                        <x-input id="password" class="block mt-1 w-full"--}}
{{--                                        type="password"--}}
{{--                                        name="password"--}}
{{--                                        required autocomplete="current-password" />--}}
{{--                    </div>--}}

                    <!-- Remember Me -->
{{--                    <div class="block mt-4">--}}
{{--                        <label for="remember_me" class="inline-flex items-center">--}}
{{--                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">--}}
{{--                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
{{--                        </label>--}}
{{--                    </div>--}}

{{--                    <div class="flex items-center justify-end mt-4">--}}
{{--                        @if (Route::has('password.request'))--}}
{{--                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">--}}
{{--                                {{ __('Forgot your password?') }}--}}
{{--                            </a>--}}
{{--                        @endif--}}

{{--                        <x-button class="ml-3">--}}
{{--                            {{ __('Log in') }}--}}
{{--                        </x-button>--}}
{{--                    </div>--}}
{{--                </form>--}}

                <form method="POST" action="{{ route('login') }}" class="bg-white shadow-2xl rounded-2xl border px-8 pt-6 pb-8 mb-4 w-full">
                    @csrf

                    <h1 class="text-3xl font-medium text-center">Prihlásenie</h1>
                    <div class="mb-4 mt-8 text-center relative">
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus class="shadow appearance-none border rounded w-full sm:w-4/5 py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" placeholder="Email" />
                        <div class="absolute right-2 sm:right-10 top-1">
                            <img src="{{ url('/images/email.png') }}" alt="Email" class="w-7 mr-2" />
                        </div>
                    </div>
                    <div class="text-center relative">
                        <input class="shadow appearance-none border rounded w-full sm:w-4/5 py-2 px-3 text-gray-700 mb-3 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" type="password"
                               name="password"
                               id="password"
                               required autocomplete="current-password" type="password" placeholder="Heslo" />
                        <div class="absolute right-2 sm:right-10 top-1">
                            <img src="{{ url('/images/password.png') }}" alt="Heslo" class="w-7 mr-2" />
                        </div>
                    </div>
                    <div class="flex justify-center mt-5">
                        <button class="w-4/5 sm:w-3/5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline rounded-full" type="submit">Prihlásiť sa</button>
                    </div>
                    <div class="flex justify-center mt-2">
                        <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" title="Zabudnuté heslo" href="{{ route('password.request') }}"> Zabudnuté heslo? </a>
                    </div>
                    <div class="mt-24 justify-center">
                        <h3 class="block text-xl font-medium text-center">Ešte nemáte účet?</h3>
                        <div class="text-center mt-3">
                            <a href="{{ route('register') }}" title="Presmerovanie na registráciu">
                                <button class="w-4/5 sm:w-3/5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline rounded-full" type="button">Zaregistrovať sa</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
