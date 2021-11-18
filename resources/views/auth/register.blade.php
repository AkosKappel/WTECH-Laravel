<x-guest-layout>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <body class="font-body text-gray-600 bg-gray-100">
        <main class="flex h-screen">
            <div class="w-10/12 sm:w-full max-w-md mx-auto m-auto">
                <form method="POST" action="{{ route('register') }}" class="bg-white shadow-2xl rounded-2xl border px-8 pt-6 pb-8 mb-4 w-full">
                    @csrf
                    <h1 class="text-3xl font-medium text-center">Registrácia</h1>
                    <div class="mb-4 mt-8 text-center relative">
                        <input id="email" type="email" name="email" :value="old('email')" required class="shadow appearance-none border rounded w-full sm:w-4/5 py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" placeholder="Email" />
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
                            <img src="{{ url('/images/password.png')}}" alt="Heslo" class="w-7 mr-2" />
                        </div>
                    </div>
                    <div class="flex justify-center mt-5">
                        <button class="w-4/5 sm:w-3/5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline rounded-full" type="submit">Zaregistrovať sa</button>
                    </div>
                </form>
            </div>
        </main>
    </body>

{{--        <form method="POST" action="{{ route('register') }}" >--}}
{{--            @csrf--}}

{{--            <!-- Email Address -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-label for="email" :value="__('Email')" />--}}

{{--                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />--}}
{{--            </div>--}}

{{--            <!-- Password -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-label for="password" :value="__('Password')" />--}}

{{--                <x-input id="password" class="block mt-1 w-full"--}}
{{--                                type="password"--}}
{{--                                name="password"--}}
{{--                                required autocomplete="new-password" />--}}
{{--            </div>--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">--}}
{{--                    {{ __('Already registered?') }}--}}
{{--                </a>--}}

{{--                <x-button class="ml-4">--}}
{{--                    {{ __('Register') }}--}}
{{--                </x-button>--}}
{{--            </div>--}}
{{--        </form>--}}


</x-guest-layout>
