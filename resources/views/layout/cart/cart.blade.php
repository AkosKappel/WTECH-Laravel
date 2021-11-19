<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Nákupný košík" ])
</head>

<body class="font-body text-gray-600 bg-gray-100">
@include('layout.partials.header')

<main class="lg:mx-16 my-12">
    <h1 class="text-center font-bold text-3xl lg:text-4xl px-2 mt-4">Váš nákupný košík</h1>
    <div class="hidden md:grid grid-cols-12 mx-auto w-11/12 2xl:w-4/5 rounded-md mt-5 -mb-2 items-center">
        <div class="col-span-5"></div>
        <div class="col-span-2 text-center text-xl">Cena za kus</div>
        <div class="col-span-2 text-center text-xl">Množstvo</div>
        <div class="col-span-3 text-center text-xl">Cena za množstvo</div>
    </div>
    <div class="text-center mx-auto w-11/12 2xl:w-4/5">
        <div class="grid grid-cols-12 mx-auto bg-gray-300 rounded-md p-2 my-4 items-center">
            <div class="col-span-12 md:col-span-5 text-center md:text-left">
                <div class="grid grid-cols-12 items-center">
                    <div class="col-span-12 md:col-span-7 xl:col-span-5 text-center">
                        <img src="{{ url('/images/samsung.png') }}" alt="Samsung" class="h-36 inline-block" />
                    </div>
                    <div class="col-span-12 md:col-span-5 xl:col-span-7">
                        <p class="inline text-lg font-semibold">Samsung Galaxy A52F 6GB/128GB</p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 mt-2 md:col-span-2 md:mt-0 text-center">
                <p class="inline text-lg font-semibold md:hidden">Cena za kus:</p>
                <p class="inline text-lg font-semibold">189,99 €</p>
            </div>
            <div class="col-span-12 mt-2 md:col-span-2 md:mt-0 items-center content-center">
                <div class="inline-flex h-10 w-32 rounded-lg relative bg-transparent overflow-hidden">
                    <button data-action="decrement" class="bg-blue-500 text-gray-100 hover:text-gray-100 hover:bg-blue-800 h-full w-20 rounded-l cursor-pointer outline-none">
                        <span class="text-2xl font-bold">−</span>
                    </button>
                    <input type="number" class="pl-1 md:pl-2 outline-none text-center w-full bg-blue-500 font-bold text-lg flex items-center text-gray-100" id="product-1-quantity" value="1" min="1" />
                    <button data-action="increment" class="bg-blue-500 text-gray-100 hover:text-gray-100 hover:bg-blue-800 h-full w-20 rounded-r cursor-pointer">
                        <span class="text-2xl font-bold">+</span>
                    </button>
                </div>
            </div>
            <div class="col-span-12 mt-2 h-full w-full md:col-span-3 md:mt-2 md:text-right relative">
                <div class="grid grid-rows-12 h-full">
                    <div class="row-span-6 md:mt-4 self-end text-center">
                        <p class="inline-block text-lg font-semibold md:hidden">Cena za množstvo:</p>
                        <p class="inline-block text-lg font-semibold">189,99 €</p>
                    </div>
                    <div class="row-span-6 self-end text-right">
                        <form action="" method="get">
                            <button class="underline" type="submit">Odstrániť</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 mx-auto bg-gray-300 rounded-md p-2 my-4 items-center">
            <div class="col-span-12 md:col-span-5 text-center md:text-left">
                <div class="grid grid-cols-12 items-center">
                    <div class="col-span-12 md:col-span-7 xl:col-span-5 text-center">
                        <img src="{{ url('/images/samsung.png') }}" alt="Samsung" class="h-36 inline-block" />
                    </div>
                    <div class="col-span-12 md:col-span-5 xl:col-span-7">
                        <p class="inline text-lg font-semibold">Samsung Galaxy S21 Ultra 5G 8GB/256GB čierny</p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 mt-2 md:col-span-2 md:mt-0 text-center">
                <p class="inline text-lg font-semibold md:hidden">Cena za kus:</p>
                <p class="inline text-lg font-semibold">1099,99 €</p>
            </div>
            <div class="col-span-12 mt-2 md:col-span-2 md:mt-0 items-center content-center">
                <div class="inline-flex h-10 w-32 rounded-lg relative bg-transparent overflow-hidden">
                    <button data-action="decrement" class="bg-blue-500 text-gray-100 hover:text-gray-100 hover:bg-blue-800 h-full w-20 rounded-l cursor-pointer outline-none">
                        <span class="text-2xl font-bold">−</span>
                    </button>
                    <input type="number" class="pl-1 md:pl-2 outline-none text-center w-full bg-blue-500 font-bold text-lg flex items-center text-gray-100" id="product-2-quantity" value="2" min="1" />
                    <button data-action="increment" class="bg-blue-500 text-gray-100 hover:text-gray-100 hover:bg-blue-800 h-full w-20 rounded-r cursor-pointer">
                        <span class="text-2xl font-bold">+</span>
                    </button>
                </div>
            </div>
            <div class="col-span-12 mt-2 h-full w-full md:col-span-3 md:mt-2 md:text-right relative">
                <div class="grid grid-rows-12 h-full">
                    <div class="row-span-6 md:mt-4 self-end text-center">
                        <p class="inline-block text-lg font-semibold md:hidden">Cena za množstvo:</p>
                        <p class="inline-block text-lg font-semibold">2199,98 €</p>
                    </div>
                    <div class="row-span-6 self-end text-right">
                        <form action="" method="get">
                            <button class="underline" type="submit">Odstrániť</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 mx-auto bg-gray-300 rounded-md p-2 my-4 items-center">
            <div class="col-span-12 md:col-span-5 text-center md:text-left">
                <div class="grid grid-cols-12 items-center">
                    <div class="col-span-12 md:col-span-7 xl:col-span-5 text-center">
                        <img src="{{ url('/images/iphone12.png') }}" alt="iPhone" class="h-36 inline-block" />
                    </div>
                    <div class="col-span-12 md:col-span-5 xl:col-span-7">
                        <p class="inline text-lg font-semibold">iPhone 12 Pro 6GB/128GB modrý</p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 mt-2 md:col-span-2 md:mt-0 text-center">
                <p class="inline text-lg font-semibold md:hidden">Cena za kus:</p>
                <p class="inline text-lg font-semibold">1099,99 €</p>
            </div>
            <div class="col-span-12 mt-2 md:col-span-2 md:mt-0 items-center content-center">
                <div class="inline-flex h-10 w-32 rounded-lg relative bg-transparent overflow-hidden">
                    <button data-action="decrement" class="bg-blue-500 text-gray-100 hover:text-gray-100 hover:bg-blue-800 h-full w-20 rounded-l cursor-pointer outline-none">
                        <span class="text-2xl font-bold">−</span>
                    </button>
                    <input type="number" class="pl-1 md:pl-2 outline-none text-center w-full bg-blue-500 font-bold text-lg flex items-center text-gray-100" id="product-3-quantity" value="2" min="1" />
                    <button data-action="increment" class="bg-blue-500 text-gray-100 hover:text-gray-100 hover:bg-blue-800 h-full w-20 rounded-r cursor-pointer">
                        <span class="text-2xl font-bold">+</span>
                    </button>
                </div>
            </div>
            <div class="col-span-12 mt-2 h-full w-full md:col-span-3 md:mt-2 md:text-right relative">
                <div class="grid grid-rows-12 h-full">
                    <div class="row-span-6 md:mt-4 self-end text-center">
                        <p class="inline-block text-lg font-semibold md:hidden">Cena za množstvo:</p>
                        <p class="inline-block text-lg font-semibold">2199,98 €</p>
                    </div>
                    <div class="row-span-6 self-end text-right">
                        <form action="" method="get">
                            <button class="underline" type="submit">Odstrániť</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex w-11/12 2xl:w-4/5 mx-auto mt-2 sm:mt-10 sm:pr-2 text-right justify-self-center justify-center md:justify-end">
        <p class="text-2xl font-bold">Celková cena: 3539,96 €</p>
    </div>
    <div class="flex w-11/12 2xl:w-4/5 mx-auto mt-5 md:mt-10 pr-2 text-center md:text-right justify-self-center justify-center items-center md:justify-end">
        <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-6">
                <a href="{{ url('/smartphones') }}" title="Pokračovať v nákupe" class="text-xl font-bold underline md:mr-10">Pokračovať v nákupe</a>
            </div>
            <div class="col-span-12 md:col-span-6">
                <a href="{{ url('/address') }}" title="Pokračovať v objednávke" class="w-full mt-2 md:mt-0 block md:inline bg-gray-300 rounded-md py-3 px-5 text-center text-xl font-bold">Pokračovať v objednávke</a>
            </div>
        </div>
    </div>
</main>

@include('layout.partials.footer')
</body>
</html>

