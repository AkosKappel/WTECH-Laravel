<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => "Vytvorenie účtu" ])
</head>

<body class="font-body text-gray-600 bg-gray-100">
<main class="flex h-screen">
    <div class="w-10/12 sm:w-full max-w-md mx-auto m-auto">

        <form method="POST" action="{{ route('storeAfterOrder') }}" class="bg-white shadow-2xl rounded-2xl border px-8 pt-6 pb-8 mb-4 w-full">
            @csrf
            <h1 class="text-3xl font-medium text-center">Vytvorenie účtu</h1>

            <!-- input fields: email, password -->
            <div class="mb-4 mt-8 text-center relative">
                <label for="email"></label>
                <input id="email" type="email" name="email" value="{{ Session::get('email') }}" placeholder="Email" required
                       class="shadow appearance-none border rounded w-full sm:w-4/5 py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" />
                <div class="absolute right-2 sm:right-10 top-1">
                    <img src="{{ url('wtech/images/email.png') }}" alt="Email" class="w-7 mr-2" />
                </div>
            </div>
            <div class="text-center relative">
                <label for="password"></label>
                <input class="shadow appearance-none border rounded w-full sm:w-4/5 py-2 px-3 text-gray-700 mb-3 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full"
                       name="password" id="password" required autocomplete="current-password"
                       type="password" placeholder="Heslo" />
                <div class="absolute right-2 sm:right-10 top-1">
                    <img src="{{ url('wtech/images/password.png')}}" alt="Heslo" class="w-7 mr-2" />
                </div>
            </div>

            @if ($errors->any())
                <div class="text-center my-4 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex justify-center mt-5">
                <button class="w-4/5 sm:w-3/5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline rounded-full" type="submit">Zaregistrovať sa</button>
            </div>
        </form>

    </div>
</main>
</body>
</html>
