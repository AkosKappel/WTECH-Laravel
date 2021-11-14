<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Doprava" ])
</head>

<body>
@include('layout.partials.header')

<main class="flex justify-evenly lg:mx-32 my-8">
    <div class="container">
        <h1 class="font-bold text-2xl my-8 mx-16">Vaša objednávka</h1>
        <div class="space-x-4 text-xl mt-4 mb-8 mx-16">
            <h2 class="inline">Adresa</h2>
            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
            <h2 class="inline"><strong>Doprava</strong></h2>
            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
            <h2 class="inline">Platba</h2>
        </div>
        <form class="mx-16" action="" method="post">
            <div class="block">
                <div class="my-12 mx-4">
                    <div>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="transport" value="1" />
                            <span class="text-lg mx-4 my-1">Doručenie kuriérom</span>
                        </label>
                        <span class="text-right">
                  <strong class="text-lg">0.00 €</strong>
                </span>
                    </div>
                    <div>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="transport" value="2" />
                            <span class="text-lg mx-4 my-1">Osobný odber</span>
                        </label>
                        <span class="text-right w-16">
                  <strong class="text-lg">0.00 €</strong>
                </span>
                    </div>
                    <div>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="transport" value="3" />
                            <span class="text-left text-lg mx-4 my-1">Doručenie na poštu</span>
                            <strong class="text-right text-lg">0.00 €</strong>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="transport" value="3" />
                            <span class="text-lg mx-4 my-1">Zásielkovňa</span>
                            <strong class="text-right text-lg">0.00 €</strong>
                        </label>
                    </div>
                </div>
            </div>
            <!-- buttons -->
            <div class="grid lg:grid-cols-2 grid-cols-1 col-gap-32">
                <div class="col-span-1 flex justify-center items-end lg:h-64">
                    <a href="{{ url('/address') }}" title="Späť na dodacie údaje">
                        <div class="w-48 bg-blue-500 text-center hover:bg-blue-700 text-white font-bold py-2 mb-16 px-4 rounded focus:outline-none focus:shadow-outline rounded-full">
                            Späť
                        </div>
                    </a>
                </div>
                <div class="col-span-1 flex justify-center items-end lg:h-64">
                    <a href="{{ url('/payment') }}" title="Pokračuj na spôsob platby">
                        <div class="w-48 text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 mb-16 px-4 rounded focus:outline-none focus:shadow-outline rounded-full">
                            Pokračovať
                        </div>
                    </a>
                </div>
            </div>
        </form>
    </div>
</main>

@include('layout.partials.footer');
</body>
</html>
