<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Shopping Cart')])
</head>

<body class="font-sans bg-gray-50 min-h-screen flex flex-col">
    @include('layout.partials.header')

    <main class="flex-1 container mx-auto px-4 py-8 sm:px-6 lg:px-8">
        {{-- Notifications --}}
        @if (session()->has('success_message'))
            <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-700" role="alert">
                <p class="font-medium">{{ session()->get('success_message') }}</p>
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-700" role="alert">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Cart Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">{{ __('Your Shopping Cart') }}</h1>
        </div>

        @if(Cart::count() > 0)
            {{-- Desktop Headers --}}
            <div class="hidden md:grid grid-cols-12 gap-4 mb-4 text-sm font-medium text-gray-500 uppercase tracking-wider">
                <div class="col-span-5">{{ __('Product') }}</div>
                <div class="col-span-2 text-center">{{ __('Unit Price') }}</div>
                <div class="col-span-2 text-center">{{ __('Quantity') }}</div>
                <div class="col-span-3 text-center">{{ __('Total') }}</div>
            </div>

            {{-- Cart Items --}}
            <div class="space-y-4">
                @foreach(Cart::content() as $product)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="grid grid-cols-12 gap-4 p-4 items-center">
                            {{-- Product Info --}}
                            <div class="col-span-12 md:col-span-5 flex flex-col sm:flex-row items-center gap-4">
                                <div class="w-24 h-24 flex-shrink-0">
                                    <img src="{{ url('wtech/' . $product->options->image_source) }}" 
                                         alt="{{ $product->options->image_name }}"
                                         class="w-full h-full object-contain"/>
                                </div>
                                <div class="flex-1 text-center sm:text-left">
                                    <a href="{{ route('details', $product->id) }}" 
                                       class="text-gray-900 font-medium hover:text-indigo-600 transition-colors">
                                        {{ $product->name }}
                                    </a>
                                </div>
                            </div>

                            {{-- Unit Price --}}
                            <div class="col-span-12 md:col-span-2 text-center">
                                <span class="md:hidden font-medium text-gray-500">{{ __('Unit Price') }}: </span>
                                <span class="font-medium text-gray-900">{{ formattedPrice($product->price) }}</span>
                            </div>

                            {{-- Quantity Selector --}}
                            <div class="col-span-12 md:col-span-2">
                                <form action="{{ route('cart.update', [$product->rowId]) }}" 
                                      id="quantity-{{ $loop->index }}-form" 
                                      method="POST"
                                      class="flex justify-center">
                                    @method('PUT')
                                    @csrf
                                    <div class="flex items-center border border-gray-200 rounded-lg">
                                        <button type="button" 
                                                onclick="decrement({{$loop->index}})"
                                                class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75">
                                            −
                                        </button>
                                        <input type="number"
                                               id="product-{{ $loop->index }}-quantity"
                                               name="product_quantity"
                                               max="{{ $product->options->max_quantity }}"
                                               value="{{ $product->qty }}"
                                               min="1"
                                               class="h-10 w-16 border-transparent text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none" />
                                        <button type="button"
                                                onclick="increment({{$loop->index}})"
                                                class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75">
                                            +
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Total Price & Actions --}}
                            <div class="col-span-12 md:col-span-3 flex flex-col gap-2">
                                <div class="text-center">
                                    <span class="md:hidden font-medium text-gray-500">{{ __('Total') }}: </span>
                                    <span class="font-medium text-gray-900">{{ formattedPrice($product->total) }}</span>
                                </div>
                                <div class="text-center">
                                    <form action="{{ route('cart.destroy', $product->rowId) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" 
                                                class="text-sm font-medium text-red-600 hover:text-red-500 transition-colors">
                                            {{ __('Remove') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Cart Summary --}}
            <div class="mt-8">
                <div class="rounded-lg bg-gray-50 p-6">
                    <div class="flex items-center justify-end">
                        <span class="text-xl font-medium text-gray-900 mr-6">{{ __('Total') }}</span>
                        <span class="text-2xl font-bold text-gray-900">{{ Cart::total() . ' €'}}</span>
                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-end items-center">
                        <a href="{{ route('smartphones') }}" 
                           class="text-indigo-600 hover:text-indigo-500 font-medium transition-colors">
                            {{ __('Continue Shopping') }}
                        </a>

                        @if(Cart::count() > 0)
                            <a href="{{ route('address') }}" 
                               class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                {{ __('Proceed to Checkout') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @else
            {{-- Empty Cart --}}
            <div class="text-center py-12">
                <div class="rounded-lg bg-yellow-50 p-4 text-sm text-yellow-700" role="alert">
                    <p class="font-medium">{{ __('Your cart is empty.') }}</p>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('smartphones') }}" 
                       class="text-indigo-600 hover:text-indigo-500 font-medium transition-colors">
                        {{ __('Start Shopping') }}
                    </a>
                </div>
            </div>
        @endif
    </main>

    @include('layout.partials.footer')

    <script src="{{ url('wtech/js/cart.js') }}" type="text/javascript"></script>
</body>
</html>
