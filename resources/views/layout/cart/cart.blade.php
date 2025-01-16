<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Nákupný košík" ])
    <link href="{{ asset('css/quantity-selector.css') }}" rel="stylesheet" type="text/css">
</head>

<body class="font-body text-gray-600 bg-gray-100 flex flex-col h-screen justify-between">
@include('layout.partials.header')

<main class="lg:mx-16 my-12 ">
    @if (session()->has('success_message'))
        <div class="flex justify-center bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
            <p class="font-bold">{{ session()->get('success_message') }}</p>
        </div>
    @endif

    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1 class="text-center font-bold text-3xl lg:text-4xl px-2 mt-4">Váš nákupný košík</h1>
    @if(Cart::count() > 0)
    <div class="hidden md:grid grid-cols-12 mx-auto w-11/12 2xl:w-4/5 rounded-md mt-5 -mb-2 items-center">
        <div class="col-span-5"></div>
        <div class="col-span-2 text-center text-xl">Cena za kus</div>
        <div class="col-span-2 text-center text-xl">Množstvo</div>
        <div class="col-span-3 text-center text-xl">Cena za množstvo</div>
    </div>

    <div class="text-center mx-auto w-11/12 2xl:w-4/5">
        @foreach(Cart::content() as $product)
        <div class="grid grid-cols-12 mx-auto bg-gray-300 rounded-md p-2 my-4 items-center">
            <div class="col-span-12 md:col-span-5 text-center md:text-left">
                <div class="grid grid-cols-12 items-center">
                    <div class="col-span-12 md:col-span-7 xl:col-span-5 text-center">
                        <img src="{{ $product->options->image_source }}" alt="{{ $product->options->image_name }}" class="h-36 inline-block" />
                    </div>
                    <div class="col-span-12 md:col-span-5 xl:col-span-7">
                        <p class="inline text-lg font-semibold">{{ $product->name }}</p>
                    </div>
                </div>
            </div>

            <div class="col-span-12 mt-2 md:col-span-2 md:mt-0 text-center">
                <p class="inline text-lg font-semibold md:hidden">Cena za kus:</p>
                <p class="inline text-lg font-semibold">{{ formattedPrice($product->price) }}</p>
            </div>

            <form class="col-span-12 mt-2 md:col-span-2 md:mt-0 items-center content-center" action="{{ route('cart.update', [$product->rowId]) }}" id="{{ 'quantity-' . $loop->index . '-form' }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="inline-flex h-10 w-32 rounded-lg relative bg-transparent overflow-hidden">
                    <button type="button" data-action="decrement" onClick="decrement({{$loop->index}})" class="bg-blue-500 text-gray-100 hover:text-gray-100 hover:bg-blue-800 h-full w-20 rounded-l cursor-pointer outline-none">
                        <span class="text-2xl font-bold">−</span>
                    </button>
                    <input type="number" id={{ 'product-' . $loop->index . '-quantity' }} name="product_quantity" max="{{ $product->options->max_quantity }}" value="{{ $product->qty }}" min="1"
                           class="pl-1 md:pl-2 outline-none text-center w-full bg-blue-500 font-bold text-lg flex items-center text-gray-100" />
                    <button type="button" data-action="increment" onClick="increment({{$loop->index}})" class="bg-blue-500 text-gray-100 hover:text-gray-100 hover:bg-blue-800 h-full w-20 rounded-r cursor-pointer">
                        <span class="text-2xl font-bold">+</span>
                    </button>
                </div>
            </form>

            <div class="col-span-12 mt-2 h-full w-full md:col-span-3 md:mt-2 md:text-right relative">
                <div class="grid grid-rows-12 h-full">
                    <div class="row-span-6 md:mt-4 self-end text-center">
                        <p class="inline-block text-lg font-semibold md:hidden">Cena za množstvo:</p>
                        <p class="inline-block text-lg font-semibold">{{ formattedPrice($product->total) }}</p>
                    </div>

                    <div class="row-span-6 self-end text-right">
                        <form action="{{ route('cart.destroy', $product->rowId) }}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="underline" type="submit">Odstrániť</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="flex justify-center bg-yellow-100 border-t border-b border-yellow-500 text-yellow-700 px-4 py-3 mt-4" role="alert">
        <p class="font-bold">Nemáte žiadne položky v košíku.</p>
    </div>
    @endif

    <div class="flex w-11/12 2xl:w-4/5 mx-auto mt-2 sm:mt-10 sm:pr-2 text-right justify-self-center justify-center md:justify-end">
        <p class="text-2xl font-bold">Celková cena: {{ Cart::total() . ' €'}}</p>
    </div>

    <div class="flex w-11/12 2xl:w-4/5 mx-auto mt-5 md:mt-10 pr-2 text-center md:text-right justify-self-center justify-center items-center md:justify-end">
        <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-6">
                <a href="{{ route('smartphones') }}" title="Pokračovať v nákupe" class="text-xl font-bold underline md:mr-10">Pokračovať v nákupe</a>
            </div>
            @if(Cart::count() > 0)
            <div class="col-span-12 md:col-span-6">
                <a href="{{ route('address') }}" title="Pokračovať v objednávke" class="w-full mt-2 md:mt-0 block md:inline bg-gray-300 rounded-md py-3 px-5 text-center text-xl font-bold">
                    Pokračovať v objednávke
                </a>
            </div>
            @endif
        </div>
    </div>
</main>

<script src="{{ asset('js/cart.js') }}" type="text/javascript"></script>
@include('layout.partials.footer')
</body>
</html>

