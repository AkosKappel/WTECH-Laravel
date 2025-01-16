<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Zmena hesla" ])
</head>

<body class="font-body text-gray-600 bg-gray-100">
    <main class="flex h-screen">
        <div class="w-10/12 sm:w-full max-w-md mx-auto m-auto">
            <form action="{{ route('passwordChange') }}" method="POST" class="bg-white shadow-2xl rounded-2xl border px-8 pt-6 pb-8 mb-4 w-full">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <h1 class="text-3xl font-medium text-center">Zmena hesla</h1>
                <div class="mb-4 mt-8 text-center relative">
                    <input name="oldPassword" class="shadow appearance-none border rounded w-full sm:w-4/5 py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="currentPassword" type="password" placeholder="Súčasné heslo" />
                    <div class="absolute right-2 sm:right-10 top-1">
                        <img src="{{ url('wtech/images/password.png') }}" alt="Heslo" class="w-7 mr-2" />
                    </div>
                </div>
                <div class="text-center relative">
                    <input name="newPassword" class="shadow appearance-none border rounded w-full sm:w-4/5 py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="newPassword" type="password" placeholder="Nové heslo" />
                    <div class="absolute right-2 sm:right-10 top-1">
                        <img src="{{ url('wtech/images/password.png') }}" alt="Heslo" class="w-7 mr-2" />
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
                    <button class="w-4/5 sm:w-3/5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline rounded-full" type="submit">Zmeniť heslo</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
