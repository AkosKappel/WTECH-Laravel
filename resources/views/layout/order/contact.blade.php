<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Adresa" ])
</head>

<body>
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
        <form class="mx-16" action="" method="post">
            <div class="grid lg:grid-cols-2 grid-cols-1 col-gap-32">
                <div class="lg:col-span-1">
                    <h3 class="text-lg font-bold mt-12 mb-8">Osobné údaje</h3>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-base" for="name">Meno:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2 flex justify-end">
                            <input class="text-base shadow appearance-none border rounded -mt-1 sm:-mt-2 w-full py-2 ml-2 sm:ml-0 px-3 sm:mr-2 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="name" type="text" placeholder="Meno" />
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="surname">Priezvisko:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2 flex justify-end">
                            <input class="text-base shadow appearance-none border rounded -mt-1 sm:-mt-2 w-full py-2 ml-2 sm:ml-0 px-3 sm:mr-2 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="surname" type="text" placeholder="Priezvisko" />
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="phone">Telefón:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2 flex justify-end">
                            <input class="text-base shadow appearance-none border rounded -mt-1 sm:-mt-2 w-full py-2 ml-2 sm:ml-0 px-3 sm:mr-2 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="phone" type="text" placeholder="Telefón" />
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="email">Email:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2 flex justify-end">
                            <input class="text-base shadow appearance-none border rounded -mt-1 sm:-mt-2 w-full py-2 ml-2 sm:ml-0 px-3 sm:mr-2 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="email" type="text" placeholder="Email" />
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-1">
                    <h3 class="text-lg font-bold mt-12 mb-8">Dodacie údaje</h3>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="street">Ulica:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2 flex justify-end">
                            <input class="text-base shadow appearance-none border rounded w-full -mt-1 sm:-mt-2 py-2 ml-2 sm:ml-0 px-3 sm:mr-2 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="street" type="text" placeholder="Ulica" />
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="streetNumber">Popisné číslo:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2 flex justify-end">
                            <input class="text-base shadow appearance-none sm:mr-2 border rounded w-full ml-2 sm:ml-0 py-2 -mt-1 sm:-mt-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="streetNumber" type="text" placeholder="Popisné číslo" />
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="town">Mesto:</label>
                        </div>
                        <div class="md:w-2/3 col-span-2 flex justify-end">
                            <input class="text-base shadow sm:mr-2 appearance-none border rounded ml-2 sm:ml-0 w-full py-2 px-3 text-gray-700 -mt-1 sm:-mt-2 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="town" type="text" placeholder="Mesto" />
                        </div>
                    </div>
                    <div class="my-6 text-left grid grid-cols-3">
                        <div class="col-span-1">
                            <label class="text-sm sm:text-base" for="country">Krajina</label>
                        </div>
                        <div class="md:w-2/3 col-span-2 flex justify-end">
                            <input class="text-base shadow appearance-none sm:mr-2 border rounded w-full ml-2 sm:ml-0 py-2 -mt-1 sm:-mt-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="country" type="text" placeholder="Krajina" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid lg:grid-cols-2 grid-cols-1 col-gap-32">
                <div class="col-span-1 flex justify-center items-end lg:h-64">
                    <a href="{{ url('/cart.html') }}" title="Späť do košíka">
                        <div class="w-4/5 sm:w-48 bg-blue-500 text-center hover:bg-blue-700 text-white font-bold py-2 mb-16 px-4 rounded focus:outline-none focus:shadow-outline rounded-full">Späť</div>
                    </a>
                </div>
                <div class="col-span-1 flex justify-center items-end lg:h-64">
                    <a href="{{ url('/orderDelivery.html') }}" title="Pokračuj na výber dopravy">
                        <div class="w-4/5 sm:w-48 text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 mb-16 px-4 rounded focus:outline-none focus:shadow-outline rounded-full">Pokračovať</div>
                    </a>
                </div>
            </div>
        </form>
    </div>
</main>

@include('layout.partials.footer');
</body>
</html>
