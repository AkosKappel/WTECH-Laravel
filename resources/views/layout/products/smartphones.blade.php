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
        <aside class="col-span-1 mx-10 min-w-min">
            <div class="my-8 bg-blue-100 text-center">
                <section>
                    <h2 class="font-bold uppercase px-16 py-4 border-b border-gray-100 bg-gray-700 text-gray-100">Filtrovanie</h2>
                    <div class="px-4 cursor-pointer md:hidden" id="burger-icon">
                        <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </div>
                </section>
                <form method="get" action="{{ resource_path('/smartphones') }}" class="w-full max-w-sm">
                    <div class="text-sm mt-4 hidden md:block" id="filters">

                        <!-- product price -->
                        <section class="pb-4">
                            <span class="text-gray-700 font-bold py-4 px-8 flex justify-start">Cena (€)</span>
                            <div class="px-12 flex items-center mb-2">
                                <label class="block text-gray-600 mb-1 md:mb-0 pr-4" for="min-price">Od</label>
                                <input class="bg-gray-100 appearance-none border-2 border-gray-200 rounded-xl w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="min-price" type="number" min="0" value="" />
                            </div>
                            <div class="px-12 flex items-center mb-2">
                                <label class="block text-gray-600 mb-1 md:mb-0 pr-4" for="max-price">Do</label>
                                <input class="bg-gray-100 appearance-none border-2 border-gray-200 rounded-xl w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="max-price" type="number" min="0" value="" />
                            </div>
                        </section>

                        <!-- product brand -->
                        <section class="pb-4">
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
                        </section>

                        <!-- product color -->
                        <section class="pb-4">
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
                        </section>

                        <!-- apply filters button -->
                        <div class="p-10 flex justify-center">
                            <button class="bg-gray-600 text-white font-bold text-sm px-4 py-2 rounded-full shadow hover:shadow-lg" type="button">Filtrovať výsledky</button>
                        </div>
                    </div>
                </form>
            </div>
        </aside>

        <!-- main grid -->
        <main class="max-w-7xl px-4 sm:px-16 py-8 xl:col-span-3 lg:col-span-3 md:col-span-2 sm:col-span-1">
            <!-- grid header -->
            <section class="relative flex justify-between ml-4 border-b">
                <h1 class="text-xl font-bold pb-2 mt-4 border-gray-300">Dostupné smartfóny</h1>
                <form method="GET" action="{{ route('smartphones') }}">
                    <label class="text-sm mr-2">
                        <span class="m-2 hidden lg:inline">Zoradiť podľa:</span>
                        <select id="sort" name="sort" class="font-bold rounded-md border shadow-sm appearance-none border-gray-400 py-2 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-gray-100 focus:ring-indigo-500 border-2 text-base pl-3 pr-10">
                            <option value="desc" class="sort-option rounded-md text-lg selected">
                                <a href="{{ route('smartphones', ['sort' => 'desc']) }}" style="color:black;">Najdrahšie</a>
                            </option>
                            <option value="asc" class="sort-option rounded-md text-lg">
                                <a href="{{ route('smartphones', ['sort' => 'asc']) }}" style="color:black;">Najlacnejšie</a>
                            </option>
                        </select>
                    </label>
                    <span class="absolute right-2 -top-2 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </form>
            </section>

            <!-- grid content -->
            <div class="mt-8 grid 2xl:grid-cols-3 lg:grid-cols-2 sm:grid-cols-1 gap-12">
                <!-- products -->
                @foreach($smartphones as $smartphone)
                    <a href="{{ url('smartphones/' . $smartphone->id) }}">
                        <section class="bg-white border-gray-200 rounded max-w-sm overflow-hidden relative shadow-md hover:shadow-lg">
                            <img src="{{ $smartphone->images->first()->source }}" alt="{{ $smartphone->images->first()->name }}" class="h-64 w-full object-cover" />
                            <div class="m-4 text-center">
                                <h2 class="font-bold">{{ $smartphone->name }}</h2>
                                <p class="block text-gray-900 text-md">{{ number_format((float) $smartphone->price, 2, ',', ' ') }} €</p>
                            </div>
                        </section>
                    </a>
                @endforeach
            </div>

            <!-- page numbers -->
            <nav class="my-12 text-center flex justify-center">
                {{ $smartphones->onEachSide(1)->links('layout.partials.pagination') }}
            </nav>

        </main>
    </div>
</div>

<script src="{{ url('/js/smartphones.js') }}" type="text/javascript"></script>

@include('layout.partials.footer')
</body>
</html>
