<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Používateľské údaje" ])
</head>

<body class="font-body text-gray-600 bg-gray-100 pb-36 sm:pb-0">
@include('layout.partials.header')

<main class="personal-info mt-10 sm:mt-20 mx-auto">
    <div class="grid grid-cols-12">
        <div class="col-span-12 lg:col-span-6">
            <div class="flex">
                <div class="w-11/12 sm:w-full max-w-md mx-auto m-auto">
                    <form class="bg-white shadow-2xl rounded-2xl border px-4 pt-6 pb-8 mb-4 w-full">
                        <div class="text-center">
                            <img src="{{ url('/images/person.png') }}" alt="Osoba" class="w-7 h-7 mb-3 inline" />
                            <h1 class="text-3xl font-medium text-center ml-2 inline">Osobné údaje</h1>
                        </div>
                        <div class="mb-4 mt-8 text-left relative">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm sm:text-base" for="name">Meno:</label>
                                </div>
                                <div class="col-span-8 flex justify-end"><input class="text-sm sm:text-base shadow appearance-none border rounded -mt-1 sm:-mt-2 w-full py-2 ml-2 sm:ml-0 px-3 sm:mr-2 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="name" type="text" placeholder="Meno" /></div>
                            </div>
                        </div>
                        <div class="text-left mt-5 relative">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm sm:text-base" for="surname">Priezvisko:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input class="text-sm sm:text-base shadow appearance-none sm:mr-2 border rounded ml-2 sm:ml-0 w-full py-2 -mt-1 sm:-mt-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="surname" type="text" placeholder="Priezvisko" />
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-5 justify-center">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm sm:text-base" for="phone">Telefón:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input class="text-sm sm:text-base shadow appearance-none border rounded ml-2 sm:ml-0 sm:mr-2 w-full -mt-1 sm:-mt-2 py-2 px-3 text-gray-700 mb-3 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="phone" type="text" placeholder="Telefón" />
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-2 justify-center">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm sm:text-base" for="email">Email:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input class="text-sm sm:text-base shadow sm:mr-2 appearance-none border ml-2 sm:ml-0 rounded w-full py-2 px-3 text-gray-700 -mt-1 sm:-mt-2 mb-3 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="email" type="text" placeholder="Email" />
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button class="w-4/5 sm:w-48 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline rounded-full" type="button">Uložiť zmeny</button>
                            <br />
                            <button class="w-4/5 mt-4 sm:w-48 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline rounded-full" type="button">Zmena hesla</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-6">
            <div class="flex">
                <div class="w-11/12 sm:w-full max-w-md mx-auto m-auto">
                    <form class="bg-white shadow-2xl rounded-2xl border px-4 pt-6 pb-8 mb-4 w-full">
                        <div class="text-center">
                            <img src="{{}}" alt="Osoba" class="w-7 h-7 mb-3 inline" />
                            <h1 class="text-3xl font-medium text-center ml-2 inline">Dodacie údaje</h1>
                        </div>
                        <div class="mb-4 mt-8 text-left relative">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm sm:text-base" for="street">Ulica:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input class="text-sm sm:text-base shadow appearance-none border rounded w-full -mt-1 sm:-mt-2 py-2 ml-2 sm:ml-0 px-3 sm:mr-2 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="street" type="text" placeholder="Ulica" />
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-5 relative">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm sm:text-base" for="streetNumber">Popisné číslo:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input class="text-sm sm:text-base shadow appearance-none sm:mr-2 border rounded w-full ml-2 sm:ml-0 py-2 -mt-1 sm:-mt-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="streetNumber" type="text" placeholder="Popisné číslo" />
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-5">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm sm:text-base" for="town">Mesto:</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input class="text-sm sm:text-base shadow sm:mr-2 appearance-none border rounded ml-2 sm:ml-0 w-full py-2 px-3 text-gray-700 -mt-1 sm:-mt-2 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="town" type="text" placeholder="Mesto" />
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-5 relative">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4">
                                    <label class="sm:ml-3 text-sm sm:text-base" for="country">Krajina</label>
                                </div>
                                <div class="col-span-8 flex justify-end">
                                    <input class="text-sm sm:text-base shadow appearance-none sm:mr-2 border rounded w-full ml-2 sm:ml-0 py-2 -mt-1 sm:-mt-2 px-3 text-gray-700 leading-tight focus:border-gray-500 focus:outline-none focus:shadow-outline rounded-full" id="country" type="text" placeholder="Krajina" />
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <button class="w-4/5 sm:w-48 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 mb-16 px-4 rounded focus:outline-none focus:shadow-outline rounded-full" type="button">Uložiť zmeny</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@include('layout.partials.footer');
</body>
</html>
