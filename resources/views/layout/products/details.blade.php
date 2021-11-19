<!doctype html>
<html lang="sk">
<head>
    @include('layout.partials.head', ['title' => "Detaily produktu" ])
</head>

<body>
@include('layout.partials.header')

<main class="flex justify-center">
    <div class="container px-5 py-24 mx-auto">
        <div class="grid md:grid-cols-2 grid-cols-1 gap-12">
            <!-- product image -->
            <section class="col-span-1">
                <div class="flex justify-evenly">
                @if($smartphone->images)
                    <div class="flex justify-center max-w-max-sm max-h-screen max-w-2xl overflow-hidden shadow-lg">
                        <img alt="{{ url($smartphone->images->first()->name) }}" src="{{ url($smartphone->images->first()->source) }}"
                             id="mainImage" class="rounded border-2 shadow-lg border-gray-300 object-cover h-96 w-full" />
                    </div>
                    <div hidden>
                        @foreach($smartphone->images as $image)
                            <img src="{{ $image->source }}" alt="{{ $image->name }}" class="productImage">
                        @endforeach
                    </div>
                @endif
                </div>
                <div class="flex justify-evenly">
                    <button id="prev-img-btn" class="rounded-full h-12 w-12 flex items-center justify-center bg-blue-500 hover:bg-blue-800 text-gray-100 mt-4">
                        <span class="text-xl font-bold"><</span>
                    </button>
                    <button id="next-img-btn" class="rounded-full h-12 w-12 flex items-center justify-center bg-blue-500 hover:bg-blue-800 text-gray-100 mt-4">
                        <span class="text-xl font-bold">></span>
                    </button>
                </div>
            </section>

            <!-- product name, quantity, add to cart button, ... -->
            <section class="col-span-1">
                <div class="grid">
                    <div class="row order-1 sm:order-1">
                        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{$smartphone->name}}</h1>
                    </div>
                    <div class="row order-3 sm:order-2">
                        <h2 class="mt-2 pb-4 font-medium text-2xl border-b text-gray-900 border-gray-30" id="single-price">
                            {{number_format((float) $smartphone->price, 2, ',', ' ')}} €
                        </h2>
                    </div>
                    <!-- pocitadlo pre mnozstvo produktu je prevzate z https://tailwindcomponents.com/component/number-input-counter -->
                    <div class="row order-4 sm:order-3">
                        <div class="flex flex-wrap justify-evenly lg:mt-16 mt-8 h-32">
                            <div class="custom-number-input h-10 w-32 rounded-lg">
                                <label for="product-quantity" class="m-6 w-full text-gray-700 text-lg font-semibold">Množstvo</label>
                                <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent overflow-hidden">
                                    <button data-action="decrement" class="bg-blue-500 text-gray-100 hover:text-gray-100 hover:bg-blue-800 h-full w-20 rounded-l cursor-pointer outline-none">
                                        <span class="text-2xl font-bold">−</span>
                                    </button>
                                    <input type="number" class="outline-none text-center w-full bg-blue-500 font-bold text-lg flex items-center text-gray-100" id="product-quantity" value="1" min="1" />
                                    <button data-action="increment" class="bg-blue-500 text-gray-100 hover:text-gray-100 hover:bg-blue-800 h-full w-20 rounded-r cursor-pointer">
                                        <span class="text-2xl font-bold">+</span>
                                    </button>
                                </div>
                            </div>
                            <div class="h-10 w-32 rounded-lg">
                                <label for="total-price" class="m-8 text-gray-700 text-lg font-semibold">Suma</label>
                                <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent overflow-hidden">
                                    <span id="total-price" class="text-center w-full text-xl font-medium text-base bg-blue-500 text-white rounded-lg py-1.5">
                                        {{number_format((float) $smartphone->price, 2, ',', ' ')}} €
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row order-2 relative sm:order-4">
                        <div class="flex absolute right-0 -top-3 sm:relative justify-center mt-4">
                            <button class="flex text-white bg-blue-500 border-0 py-1 sm:py-2 px-4 sm:px-6 focus:outline-none hover:bg-blue-800 rounded-lg">
                                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF">
                                    <path d="M0 0h24v24H0zm18.31 6l-2.76 5z" fill="none" />
                                    <path d="M11 9h2V6h3V4h-3V1h-2v3H8v2h3v3zm-4 9c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-9.83-3.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4h-.01l-1.1 2-2.76 5H8.53l-.13-.27L6.16 6l-.95-2-.94-2H1v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.13 0-.25-.11-.25-.25z" />
                                </svg>
                                <span class="text-2xl text-gray-100 px-4 mx-2 hidden sm:inline">Pridať do košíka</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="flex flex-wrap justify-evenly">
            <!-- product specifications -->
            <section class="w-full lg:w-1/2 mt-12 bg-white shadow overflow-hidden">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Špecifikácia</h3>
                </div>
                <div class="border-t border-gray-200 text-sm font-medium">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-gray-500">Výrobca</dt>
                            <dd class="mt-1 text-gray-900 sm:mt-0 xl:ml-32 lg:ml-16 sm:ml-24">{{$smartphone->brand->name}}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-gray-500">Pamäť RAM</dt>
                            <dd class="mt-1 text-gray-900 sm:mt-0 xl:ml-32 lg:ml-16 sm:ml-24">{{$smartphone->ram}} MB</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-gray-500">Operačný systém</dt>
                            <dd class="mt-1 text-gray-900 sm:mt-0 xl:ml-32 lg:ml-16 sm:ml-24">{{$smartphone->operating_system}}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-gray-500">Verzia operačného systému</dt>
                            <dd class="mt-1 text-gray-900 sm:mt-0 xl:ml-32 lg:ml-16 sm:ml-24">{{$smartphone->os_version}}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-gray-500">Veľkosť displeja</dt>
                            <dd class="mt-1 text-gray-900 sm:mt-0 xl:ml-32 lg:ml-16 sm:ml-24">{{$smartphone->display_size}}"</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-gray-500">Rozlíšenie displeja</dt>
                            <dd class="mt-1 text-gray-900 sm:mt-0 xl:ml-32 lg:ml-16 sm:ml-24">{{$smartphone->resolution}}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-gray-500">Výška</dt>
                            <dd class="mt-1 text-gray-900 sm:mt-0 xl:ml-32 lg:ml-16 sm:ml-24">{{$smartphone->height}} mm</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-gray-500">Šírka</dt>
                            <dd class="mt-1 text-gray-900 sm:mt-0 xl:ml-32 lg:ml-16 sm:ml-24">{{$smartphone->width}} mm</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-gray-500">Hĺbka</dt>
                            <dd class="mt-1 text-gray-900 sm:mt-0 xl:ml-32 lg:ml-16 sm:ml-24">{{$smartphone->thickness}} mm</dd>
                        </div>
                    </dl>
                </div>
            </section>

            <!-- product description -->
            <section class="lg:w-1/2 p-16">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Popis produktu</h3>
                </div>
                <p class="leading-relaxed">{{$smartphone->description}}</p>
            </section>
        </div>
    </div>
</main>

<script src="{{ asset('js/details.js') }}" type="text/javascript"></script>

@include('layout.partials.footer')
</body>
</html>
