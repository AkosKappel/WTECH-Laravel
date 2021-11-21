<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Používateľské údaje" ])
</head>

<body class="font-body text-gray-600 bg-gray-100 flex flex-col h-screen justify-between">
    @include('layout.partials.header')
    <main class="personal-info flex justify-center mt-5 md:mt-0">
        <div class="grid grid-cols-12 bg-white justify-center lg:w-4/5 xl:w-3/5 shadow-2xl rounded-2xl border px-4 pt-6 pb-8 mb-4">
            <form class="col-span-12" method="POST" action="{{ route('profile') }}">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <!-- Personal data -->
                <div class="grid grid-cols-12">
                    <div class="col-span-12 md:col-span-6 md:mr-5">
                        <div class="text-center">
                            <img src="{{ url('/images/person.png') }}" alt="Osoba" class="w-7 h-7 mb-3 inline" />
                            <h1 class="text-3xl font-medium text-center ml-2 inline">Osobné údaje</h1>
                        </div>
                        <div class="mb-4 mt-8 text-left relative">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm md:text-base" for="name">Meno:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input value="{{ Auth()->user()->first_name }}" id="name" type="text" placeholder="Meno" name="first_name"
                                           class="text-sm sm:text-base shadow appearance-none border rounded -mt-1 sm:-mt-2 w-full py-2 ml-2 sm:ml-0 px-3 sm:mr-2 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" />
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-5 relative">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm md:text-base" for="surname">Priezvisko:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input value="{{ Auth()->user()->last_name }}" id="surname" type="text" placeholder="Priezvisko" name="last_name"
                                           class="text-sm sm:text-base shadow appearance-none sm:mr-2 border rounded ml-2 sm:ml-0 w-full py-2 -mt-1 sm:-mt-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" />
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-5 justify-center">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm md:text-base" for="phone">Telefón:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input value="{{ Auth()->user()->phone_number }}" id="phone" type="text" placeholder="Telefón" name="phone_number"
                                           class="text-sm sm:text-base shadow appearance-none border rounded ml-2 sm:ml-0 sm:mr-2 w-full -mt-1 sm:-mt-2 py-2 px-3 text-gray-700 mb-3 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" />
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-2 justify-center">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm md:text-base" for="email">Email:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input value="{{ Auth()->user()->email }}" id="email" type="text" placeholder="Email" name="email"
                                           class="text-sm sm:text-base shadow sm:mr-2 appearance-none border ml-2 sm:ml-0 rounded w-full py-2 px-3 text-gray-700 -mt-1 sm:-mt-2 mb-3 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery data -->
                    <div class="col-span-12 md:col-span-6 md:ml-5">
                        <div class="text-center">
                            <img src="{{ url('/images/truck.png') }}" alt="Osoba" class="w-7 h-7 mb-3 inline" />
                            <h1 class="text-3xl font-medium text-center ml-2 inline">Dodacie údaje</h1>
                        </div>
                        <div class="mb-4 mt-8 text-left relative">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm md:text-base" for="street">Ulica:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input value="{{ Auth()->user()->street }}" id="street" type="text" placeholder="Ulica" name="street"
                                           class="text-sm sm:text-base shadow appearance-none border rounded w-full -mt-1 sm:-mt-2 py-2 ml-2 sm:ml-0 px-3 sm:mr-2 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" />
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-5 relative">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm md:text-base" for="streetNumber">Popisné číslo:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input value="{{ Auth()->user()->descriptive_number }}" id="streetNumber" type="text" placeholder="Popisné číslo" name="descriptive_number"
                                           class="text-sm sm:text-base shadow appearance-none sm:mr-2 border rounded w-full ml-2 sm:ml-0 py-2 -mt-1 sm:-mt-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" />
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-5">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm md:text-base" for="town">Mesto:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input value="{{ Auth()->user()->city }}" id="town" type="text" placeholder="Mesto" name="city"
                                           class="text-sm sm:text-base shadow sm:mr-2 appearance-none border rounded ml-2 sm:ml-0 w-full py-2 px-3 text-gray-700 -mt-1 sm:-mt-2 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" />
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-5 relative">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm sm:text-base" for="country">Krajina</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input value="{{ Auth()->user()->country }}" id="country" type="text" placeholder="Krajina" name="country"
                                           class="text-sm sm:text-base shadow appearance-none sm:mr-2 border rounded w-full ml-2 sm:ml-0 py-2 -mt-1 sm:-mt-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (Session::has('message'))
                    <div class="text-center my-4 text-green-600">{{ Session::get('message') }}</div>
                @endif

                <!-- Errors -->
                @if ($errors->any())
                    <div class="text-center my-4 text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Buttons -->
                <div class="col-span-12 text-center mt-3">
                    <button class="w-4/5 sm:w-48 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline rounded-full" type="submit">Uložiť zmeny</button>
                    <br />
                    <a href="{{ route('passwordChange') }}" class="w-4/5 mt-4 sm:w-48 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline rounded-full" type="button">
                        Zmena hesla
                    </a>
                </div>
            </form>
        </div>
    </main>
    @include('layout.partials.footer')
</body>
</html>
