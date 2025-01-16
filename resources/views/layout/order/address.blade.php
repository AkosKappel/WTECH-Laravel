<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Adresa" ])
</head>

<body class="font-body text-gray-600 bg-gray-100">
@include('layout.partials.header')

<main class="flex justify-evenly lg:mx-32 my-8">
    <div class="container">
        <h1 class="font-bold text-2xl my-8 mx-16">Vaša objednávka</h1>
        <div class="space-x-4 text-xl mt-4 mb-8 mx-16">
            <h2 class="inline"><strong>Adresa</strong></h2>
            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
            <h2 class="inline">Doprava</h2>
            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
            <h2 class="inline">Platba</h2>
        </div>

        <form class="mx-16" action="{{ route('address.store') }}" method="POST">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <div class="grid lg:grid-cols-2 grid-cols-1 col-gap-32">
                <div class="lg:col-span-1">
                    <h3 class="text-lg font-bold mt-12 mb-8">Osobné údaje</h3>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-base" for="name">Meno:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2">
                            <input value="{{ old('first_name', Auth::check() ? Auth::user()->first_name : Session::get('first_name')) }}"
                                   id="name" type="text" placeholder="Meno" name="first_name"
                                   class="text-base shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full @error('first_name') border-red-500 @enderror" />
                            @error('first_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="surname">Priezvisko:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2">
                            <input value="{{ old('last_name', Auth::check() ? Auth::user()->last_name : Session::get('last_name')) }}"
                                   id="surname" type="text" placeholder="Priezvisko" name="last_name"
                                   class="text-base shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full @error('last_name') border-red-500 @enderror" />
                            @error('last_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="phone">Telefón:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2">
                            <input value="{{ old('phone_number', Auth::check() ? Auth::user()->phone_number : Session::get('phone_number')) }}"
                                   id="phone" type="text" placeholder="Telefón" name="phone_number"
                                   class="text-base shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full @error('phone_number') border-red-500 @enderror" />
                            @error('phone_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="email">Email:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2">
                            <input value="{{ old('email', Auth::check() ? Auth::user()->email : Session::get('email')) }}"
                                   id="email" type="email" placeholder="Email" name="email"
                                   class="text-base shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full @error('email') border-red-500 @enderror" />
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-1">
                    <h3 class="text-lg font-bold mt-12 mb-8">Dodacie údaje</h3>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="street">Ulica:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2">
                            <input value="{{ old('street', Auth::check() ? Auth::user()->street : Session::get('street')) }}"
                                   id="street" type="text" placeholder="Ulica" name="street"
                                   class="text-base shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full @error('street') border-red-500 @enderror" />
                            @error('street')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="streetNumber">Popisné číslo:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2">
                            <input value="{{ old('descriptive_number', Auth::check() ? Auth::user()->descriptive_number : Session::get('descriptive_number')) }}"
                                   id="streetNumber" type="text" placeholder="Popisné číslo" name="descriptive_number"
                                   class="text-base shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full @error('descriptive_number') border-red-500 @enderror" />
                            @error('descriptive_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="city">Mesto:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2">
                            <input value="{{ old('city', Auth::check() ? Auth::user()->city : Session::get('city')) }}"
                                   id="city" type="text" placeholder="Mesto" name="city"
                                   class="text-base shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full @error('city') border-red-500 @enderror" />
                            @error('city')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="country">Krajina:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2">
                            <input value="{{ old('country', Auth::check() ? Auth::user()->country : Session::get('country')) }}"
                                   id="country" type="text" placeholder="Krajina" name="country"
                                   class="text-base shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full @error('country') border-red-500 @enderror" />
                            @error('country')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            @if (Session::has('message'))
                <div class="text-center my-4 text-green-600">{{ Session::get('message') }}</div>
            @endif

            <!-- buttons -->
            <div class="grid lg:grid-cols-2 grid-cols-1 col-gap-32">
                <div class="col-span-1 flex justify-center items-end lg:h-64">
                    <a href="{{ route('cart') }}" title="Späť do košíka">
                        <div class="w-48 bg-blue-500 text-center hover:bg-blue-700 text-white font-bold py-2 mb-16 px-4 rounded focus:outline-none focus:shadow-outline rounded-full">
                            Späť
                        </div>
                    </a>
                </div>
                <div class="col-span-1 flex justify-center items-end lg:h-64">
                    <button type="submit" class="w-48 text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 mb-16 px-4 rounded focus:outline-none focus:shadow-outline rounded-full">Pokračovať</button>
                </div>
            </div>
        </form>
    </div>
</main>

@include('layout.partials.footer')
</body>
</html>
