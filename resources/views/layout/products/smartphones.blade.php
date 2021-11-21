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

                <form method="GET" action="{{ route('smartphones') }}" class="w-full max-w-sm">
                    <div class="text-sm mt-4 hidden md:block" id="filters">

                        <!-- filter for product price -->
                        <section class="pb-4">
                            <span class="text-gray-700 font-bold py-4 px-8 flex justify-start">Cena (€)</span>
                            <div class="px-12 flex items-center mb-2">
                                <label class="block text-gray-600 mb-1 md:mb-0 pr-4" for="min-price">Od</label>
                                <input class="bg-gray-100 appearance-none border-2 border-gray-200 rounded-xl w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                       id="min-price" name="min-price" type="number" min="0" value="{{ $params['min-price'] }}" />
                            </div>
                            <div class="px-12 flex items-center mb-2">
                                <label class="block text-gray-600 mb-1 md:mb-0 pr-4" for="max-price">Do</label>
                                <input class="bg-gray-100 appearance-none border-2 border-gray-200 rounded-xl w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                       id="max-price" name="max-price" type="number" min="0" value="{{ $params['max-price'] }}" />
                            </div>
                        </section>

                        <!-- filter for product brand -->
                        <section class="pb-4">
                            <span class="text-gray-700 font-bold py-4 px-8 flex justify-start">Značka</span>
                            <div class="flex flex-col text-left px-16">
                            @foreach($params['brands'] as $brand)
                                <label class="text-lg inline-flex items-center" for="{{ $brand['name'] }}">
                                    {{ Form::checkbox($brand['name'], $brand['name'], $brand['status'], ['id' => $brand['name'], 'class' => 'form-checkbox h-4 w-4']) }}
                                    <span class="ml-2">{{ $brand['name'] }}</span>
                                </label>
                            @endforeach
                            </div>
                        </section>

                        <!-- filter for product color -->
                        <section class="pb-4">
                            <span class="text-gray-700 font-bold py-4 px-8 flex justify-start">Farba</span>
                            <div class="flex flex-col text-left px-16">
                            @foreach($params['colors'] as $color)
                                <label class="text-lg inline-flex items-center" for="{{ $color['name-en'] }}">
                                    {{ Form::checkbox($color['name-en'], $color['name-en'], $color['status'], ['id' => $color['name-en'], 'class' => 'form-checkbox h-4 w-4']) }}
                                    <span class="rounded-full h-6 w-6 m-2 flex justify-evenly bg-{{ $color['name-en'] }}-600 bg-{{ $color['name-en'] }} border-2 border-black"></span>
                                    <span class="mx-2">{{ $color['name-sk'] }}</span>
                                </label>
                            @endforeach
                            </div>
                        </section>

                        <!-- apply filters button -->
                        <div class="p-10 flex justify-center">
                            <button class="bg-gray-600 text-white font-bold text-sm px-4 py-2 rounded-full shadow hover:shadow-lg" type="submit">
                                Filtrovať výsledky
                            </button>
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
                            <option id="desc" value="desc" class="sort-option rounded-md text-lg">
                                <a href="{{ route('smartphones', ['sort' => 'desc']) }}" style="color:black;">Najdrahšie</a>
                            </option>
                            <option id="asc" value="asc" class="sort-option rounded-md text-lg">
                                <a href="{{ route('smartphones', ['sort' => 'asc']) }}" style="color:black;">Najlacnejšie</a>
                            </option>
                        </select>
                    </label>
                    <span class="absolute right-2 -top-1.5 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </form>
            </section>

            <!-- grid content -->
            <div class="mt-8 grid 2xl:grid-cols-3 lg:grid-cols-2 sm:grid-cols-1 gap-12">
                <!-- products -->

                @if(count($smartphones) > 0)
                    @foreach($smartphones as $smartphone)
                        <a href="{{ url('smartphones/' . $smartphone->id) }}">
                            <section class="bg-white border-gray-200 rounded max-w-sm overflow-hidden relative shadow-md hover:shadow-lg">
                                @if($smartphone->images->first())
                                    <img src="{{ $smartphone->images->first()->source }}" alt="{{ $smartphone->images->first()->name }}" class="h-64 w-full object-cover" />
                                @else
                                    <img src="{{ asset('images/no_img_available.jpg') }}" alt="image does not exist" class="h-64 w-full object-cover" />
                                @endif
                                <div class="m-4 text-center">
                                    <h2 class="font-bold">{{ $smartphone->name }}</h2>
                                    <p class="block text-gray-900 text-md">{{ number_format((float) $smartphone->price, 2, ',', ' ') }} €</p>
                                </div>
                            </section>
                        </a>
                    @endforeach
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 p-4" role="alert">
                        <p class="font-bold">Nenašli sa žiadne výsledky</p>
                        <h2>Skúste vyhľadávanie podľa iných kritérií.</h2>
                    </div>
                @endif
            </div>

            <!-- page numbers -->
            <nav class="my-12 text-center flex justify-center">
                {{ $smartphones->withQueryString()->onEachSide(1)->links('layout.partials.pagination') }}
            </nav>

        </main>
    </div>
</div>

<script src="{{ url('/js/smartphones.js') }}" type="text/javascript"></script>

@include('layout.partials.footer')
</body>
</html>
