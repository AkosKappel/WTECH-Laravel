<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Všetky produkty" ])
</head>

<body>
@include('layout.partials.header')

<div class="flex justify-center">
    <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-1">
        <!-- sidebar with filters -->
        <aside class="col-span-1 m-10 min-w-min">
            <div class="my-8 bg-blue-100 text-center">
                <div>
                    <h2 class="font-bold uppercase px-16 py-4 border-b border-gray-100 bg-gray-700 text-gray-100">Filtrovanie</h2>
                    <div class="px-4 cursor-pointer md:hidden" id="burger-icon">
                        <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </div>
                </div>
                <form action="" method="get" class="w-full max-w-sm">
                    <div class="text-sm mt-4 hidden md:block" id="filters">
                        <!-- product price -->
                        <div class="pb-4">
                            <span class="text-gray-700 font-bold py-4 px-8 flex justify-start">Cena (€)</span>
                            <div class="px-12 md:flex md:items-center mb-2">
                                <label class="block text-gray-600 md:text-right mb-1 md:mb-0 pr-4" for="min-price">Od</label>
                                <input class="bg-gray-100 appearance-none border-2 border-gray-200 rounded-xl w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="min-price" type="number" min="0" value="" />
                            </div>
                            <div class="px-12 md:flex md:items-center mb-2">
                                <label class="block text-gray-600 md:text-right mb-1 md:mb-0 pr-4" for="max-price">Do</label>
                                <input class="bg-gray-100 appearance-none border-2 border-gray-200 rounded-xl w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="max-price" type="number" min="0" value="" />
                            </div>
                        </div>
                        <!-- product logo -->
                        <div class="pb-4">
                            <span class="text-gray-700 font-bold py-4 px-8 flex justify-start">Značka</span>
                            <div class="flex flex-col text-left px-16">
                                <label class="text-lg inline-flex items-center" for="samsung">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="samsung" />
                                    <span class="ml-2">Samsung</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="apple">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="apple" />
                                    <span class="ml-2">Apple</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="xiaomi">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="xiaomi" />
                                    <span class="ml-2">Xiaomi</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="nokia">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="nokia" />
                                    <span class="ml-2">Nokia</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="huawei">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="huawei" />
                                    <span class="ml-2">Huawei</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="sony">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="sony" />
                                    <span class="ml-2">Sony</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="lenovo">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="lenovo" />
                                    <span class="ml-2">Lenovo</span>
                                </label>
                            </div>
                        </div>
                        <!-- product color -->
                        <div class="pb-4">
                            <span class="text-gray-700 font-bold py-4 px-8 flex justify-start">Farba</span>
                            <div class="flex flex-col text-left px-16">
                                <label class="text-lg inline-flex items-center" for="red">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="red" />
                                    <span class="rounded-full h-6 w-6 m-2 flex justify-evenly bg-red-600 border-2 border-black"></span>
                                    <span class="mx-2">červená</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="green">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="green" />
                                    <span class="rounded-full h-6 w-6 m-2 flex justify-evenly bg-green-600 border-2 border-black"></span>
                                    <span class="mx-2">zelená</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="blue">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="blue" />
                                    <span class="rounded-full h-6 w-6 m-2 flex justify-evenly bg-blue-600 border-2 border-black"></span>
                                    <span class="mx-2">modrá</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="yellow">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="yellow" />
                                    <span class="rounded-full h-6 w-6 m-2 flex justify-evenly bg-yellow-600 border-2 border-black"></span>
                                    <span class="mx-2">žltá</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="purple">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="purple" />
                                    <span class="rounded-full h-6 w-6 m-2 flex justify-evenly bg-purple-600 border-2 border-black"></span>
                                    <span class="mx-2">fialová</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="pink">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="pink" />
                                    <span class="rounded-full h-6 w-6 m-2 flex justify-evenly bg-pink-600 border-2 border-black"></span>
                                    <span class="mx-2">ružuvá</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="white">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="white" />
                                    <span class="rounded-full h-6 w-6 m-2 flex justify-evenly bg-white border-2 border-black"></span>
                                    <span class="mx-2">biela</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="gray">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="gray" />
                                    <span class="rounded-full h-6 w-6 m-2 flex justify-evenly bg-gray-700 border-2 border-black"></span>
                                    <span class="mx-2">sivá</span>
                                </label>
                                <label class="text-lg inline-flex items-center" for="black">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" id="black" />
                                    <span class="rounded-full h-6 w-6 m-2 flex justify-evenly bg-black border-2 border-black"></span>
                                    <span class="mx-2">čierna</span>
                                </label>
                            </div>
                        </div>
                        <!-- apply filters button -->
                        <div class="p-10 flex justify-center">
                            <button class="bg-gray-600 text-white font-bold text-sm px-4 py-2 rounded-full shadow hover:shadow-lg" type="button">Filtrovať výsledky</button>
                        </div>
                    </div>
                </form>
            </div>
        </aside>

        <!-- grid of products -->
        <main class="max-w-6xl px-4 sm:px-16 py-8 xl:col-span-3 lg:col-span-3 md:col-span-2 sm:col-span-1">
            <div class="flex ml-4 justify-end">
                <div class="relative">
                    <label class="text-sm mr-2">
                        <span class="m-2">Zoradiť podľa:</span>
                        <select class="font-bold rounded-md border shadow-sm appearance-none border-gray-400 py-2 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-gray-100 focus:ring-indigo-500 border-2 text-base pl-3 pr-10">
                            <option class="rounded-md text-lg">Najlacnejšie</option>
                            <option class="rounded-md text-lg">Najdrahšie</option>
                        </select>
                    </label>
                    <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                <svg class="m-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </span>
                </div>
            </div>
            <div>
                <h1 class="text-xl font-bold pb-2 mt-4 border-b border-gray-300">Dostupné smartfóny</h1>
                <div class="mt-8 grid 2xl:grid-cols-3 lg:grid-cols-2 sm:grid-cols-1 gap-12">
                    <!-- products -->
                    <a href="productDetails.html">
                        <section class="bg-white border-gray-200 rounded max-w-sm overflow-hidden relative shadow-md hover:shadow-lg">
                            <img src="{{ url('/images/smartphone-1.jpg') }}" alt="Xiaomi smartphone" class="h-64 w-full object-cover" />
                            <div class="m-4 text-center">
                                <h2 class="font-bold">Xiaomi Redmi Note 10 Pro 6GB/128GB</h2>
                                <p class="block text-gray-900 text-md">289.00 €</p>
                            </div>
                        </section>
                    </a>
                    <a href="productDetails.html">
                        <section class="bg-white border-gray-200 rounded max-w-sm overflow-hidden relative shadow-md hover:shadow-lg">
                            <img src="{{ url('/images/smartphone-2.jpg') }}" alt="Samsung smartphone" class="h-64 w-full object-cover" />
                            <div class="m-4 text-center">
                                <h2 class="font-bold">Samsung Galaxy S21 5G G991B 8GB/128GB</h2>
                                <p class="block text-gray-900 text-md">289.00 €</p>
                            </div>
                        </section>
                    </a>
                    <a href="#">
                        <section class="bg-white border-gray-200 rounded max-w-sm overflow-hidden relative shadow-md hover:shadow-lg">
                            <img src="{{ url('/images/smartphone-3.jpg') }}" alt="Apple smartphone" class="h-64 w-full object-cover" />
                            <div class="m-4 text-center">
                                <h2 class="font-bold">Apple iPhone 12 mini 64 GB</h2>
                                <p class="block text-gray-900 text-md">560.00 €</p>
                            </div>
                        </section>
                    </a>
                    <a href="#">
                        <section class="bg-white border-gray-200 rounded max-w-sm overflow-hidden relative shadow-md hover:shadow-lg">
                            <img src="{{ url('/images/smartphone-1.jpg') }}" alt="Samsung smartphone" class="h-64 w-full object-cover" />
                            <div class="m-4 text-center">
                                <h2 class="font-bold">Samsung Galaxy A52 64 GB</h2>
                                <p class="block text-gray-900 text-md">299.00 €</p>
                            </div>
                        </section>
                    </a>
                    <a href="#">
                        <section class="bg-white border-gray-200 rounded max-w-sm overflow-hidden relative shadow-md hover:shadow-lg">
                            <img src="{{ url('/images/smartphone-2.jpg') }}" alt="Huawei smartphone" class="h-64 w-full object-cover" />
                            <div class="m-4 text-center">
                                <h2 class="font-bold">Huawei P40 Pro 8/128 GB</h2>
                                <p class="block text-gray-900 text-md">899.00 €</p>
                            </div>
                        </section>
                    </a>
                    <a href="#">
                        <section class="bg-white border-gray-200 rounded max-w-sm overflow-hidden relative shadow-md hover:shadow-lg">
                            <img src="{{ url('/images/smartphone-3.jpg') }}" alt="Xiaomi smartphone" class="h-64 w-full object-cover" />
                            <div class="m-4 text-center">
                                <h2 class="font-bold">Xiaomi Mi 11 Ultra 256 GB</h2>
                                <p class="block text-gray-900 text-md">1099.00 €</p>
                            </div>
                        </section>
                    </a>
                    <a href="#">
                        <section class="bg-white border-gray-200 rounded max-w-sm overflow-hidden relative shadow-md hover:shadow-lg">
                            <img src="{{ url('/images/smartphone-1.jpg') }}" alt="Apple smartphone" class="h-64 w-full object-cover" />
                            <div class="m-4 text-center">
                                <h2 class="font-bold">Apple iphone Xs 64 GB</h2>
                                <p class="block text-gray-900 text-md">699.00 €</p>
                            </div>
                        </section>
                    </a>
                    <a href="productDetails.html">
                        <section class="bg-white border-gray-200 rounded max-w-sm overflow-hidden relative shadow-md hover:shadow-lg">
                            <img src="{{ url('/images/smartphone-2.jpg') }}" alt="Apple smartphone" class="h-64 w-full object-cover" />
                            <div class="m-4 text-center">
                                <h2 class="font-bold">Apple iPhone 11 64GB</h2>
                                <p class="block text-gray-900 text-md">289.00 €</p>
                            </div>
                        </section>
                    </a>
                </div>
            </div>

            <!-- page numbers -->
            <!-- cast kodu je prevzata z https://tailwindui.com/components/application-ui/navigation/pagination -->
            <nav class="my-12 text-center">
                <div class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Predchádzajúce</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <!-- Current page: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
                    <a href="#" aria-current="page" class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">1</a>
                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">2</a>
                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium">3</a>
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium">8</a>
                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">9</a>
                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">10</a>
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Ďalšie</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </nav>
        </main>
    </div>
</div>

@include('layout.partials.footer');
</body>
</html>
