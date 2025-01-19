<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => "Všetky produkty" ])
</head>

<body class="font-body text-gray-600 bg-gray-100 flex flex-col h-screen justify-between">
    @include('layout.partials.header')
    <main class="lg:mx-16 my-12 ">
        @if (session()->has('success_message'))
            <div class="flex justify-center bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                <p class="font-bold">{{ session()->get('success_message') }}</p>
            </div>
        @endif

        <div class="hidden md:grid grid-cols-12 mx-auto w-11/12 2xl:w-4/5 rounded-md mt-5 -mb-2 items-center">
            <div class="col-span-5 text-center text-xl">Názov produktu</div>
            <div class="col-span-3 text-center text-xl">Cena za kus</div>
            <div class="col-span-2 text-center text-xl">Množstvo na sklade</div>
            <div class="col-span-2 text-center text-xl">Akcie</div>
        </div>

        <div class="text-center mx-auto w-11/12 2xl:w-4/5">
            @foreach($smartphones as $product)
            <div class="grid grid-cols-12 mx-auto bg-gray-300 rounded-md py-2 my-4 items-center">
                <div class="col-span-12 md:col-span-5 text-center ml-2 md:text-left">
                    <div class="col-span-12 md:col-span-5 xl:col-span-7 text-center">
                        <p class="inline text-lg font-semibold">{{ $product->name }}</p>
                    </div>
                </div>

                <div class="col-span-12 mt-2 md:col-span-3 md:mt-0 text-center">
                    <p class="inline text-lg font-semibold md:hidden">Cena za kus:</p>
                    <p class="inline text-lg font-semibold">{{ formattedPrice($product->price) }}</p>
                </div>

                <div class="col-span-12 mt-2 md:col-span-2 md:mt-0 text-center">
                    <p class="inline text-lg font-semibold md:hidden">Množstvo na sklade:</p>
                    <p class="inline text-lg font-semibold">{{ $product->quantity }}</p>
                </div>

                <div class="col-span-12 mt-2 md:col-span-2 md:mt-0 text-center">
                    <div class="grid grid-cols-12 ">
                        <div class="col-span-6 text-right mr-1" >
                            @can('delete', $product)
                            <form action="{{ route('smartphones.delete', [$product->id]) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-3 py-1 h-8 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="submit">
                                    <img src="{{ url('wtech/images/delete.png')}}" alt="edit" class="w-5"/>
                                </button>
                            </form>
                            @endcan
                        </div>
                        <div class="col-span-6 text-left ml-1">
                            @can('update', $product)
                            <form action="{{ route('smartphones.edit', [$product->id]) }}" method="GET">
                                <button class="bg-yellow-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-3 py-1 h-8 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="submit">
                                    <img src="{{ url('wtech/images/edit.png')}}" alt="edit" class="w-5"/>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="text-right mr-5">
                @can('update', $product)
                <form action="{{ route('smartphones.add') }}" method="GET">
                    <button type="submit" class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                        Pridať produkt
                    </button>
                </form>
                @endcan
            </div>

            <!-- page numbers -->
            <nav class="my-12 text-center flex justify-center">
                {{ $smartphones->onEachSide(1)->links('layout.partials.pagination') }}
            </nav>
        </div>
    </main>
</body>
</html>
