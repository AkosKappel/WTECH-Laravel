@use('App\Facades\Cart')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Shopping Cart')])
</head>

<body class="font-sans bg-gray-50 min-h-screen flex flex-col">
    @include('layout.partials.header')

    <main class="flex-1 container mx-auto px-4 py-8 sm:px-6 lg:px-8">
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
                    <div class="bg-white rounded-lg shadow-xs overflow-hidden" data-cart-row>
                        <div class="grid grid-cols-12 gap-4 p-4 items-center">
                            {{-- Product Info --}}
                            <div class="col-span-12 md:col-span-5 flex flex-col sm:flex-row items-center gap-4">
                                <div class="w-24 h-24 shrink-0">
                                    <img src="{{ asset(ltrim($product->imageSource, '/')) }}" 
                                         alt="{{ $product->imageName }}"
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
                                      data-quantity-form
                                      class="flex flex-col items-center">
                                    @method('PUT')
                                    @csrf
                                    <div class="flex items-center border border-gray-200 rounded-lg">
                                        <button type="button"
                                                onclick="decrement({{$loop->index}})"
                                                data-decrement
                                                aria-label="{{ __('Decrease quantity') }}"
                                                @disabled($product->qty <= 1)
                                                class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75 disabled:opacity-30 disabled:cursor-not-allowed">
                                            −
                                        </button>
                                        <input type="number"
                                               id="product-{{ $loop->index }}-quantity"
                                               name="product_quantity"
                                               max="{{ $product->maxQuantity }}"
                                               value="{{ $product->qty }}"
                                               min="1"
                                               class="h-10 w-16 border-transparent text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none" />
                                        <button type="button"
                                                onclick="increment({{$loop->index}})"
                                                data-increment
                                                aria-label="{{ __('Increase quantity') }}"
                                                @disabled($product->qty >= $product->maxQuantity)
                                                class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75 disabled:opacity-30 disabled:cursor-not-allowed">
                                            +
                                        </button>
                                    </div>
                                    {{-- shown by cart.js whenever the quantity reaches the stock --}}
                                    <p data-stock-note id="product-{{ $loop->index }}-stock" aria-live="polite"
                                       class="mt-1 text-xs font-medium text-amber-600 {{ $product->qty >= $product->maxQuantity ? '' : 'hidden' }}">
                                        {{ __('Only :count in stock', ['count' => $product->maxQuantity]) }}
                                    </p>
                                </form>
                            </div>

                            {{-- Total Price & Actions --}}
                            <div class="col-span-12 md:col-span-3 flex flex-col gap-2">
                                <div class="text-center">
                                    <span class="md:hidden font-medium text-gray-500">{{ __('Total') }}: </span>
                                    <span class="font-medium text-gray-900" data-item-total>{{ formattedPrice($product->total()) }}</span>
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
                    @php $code = Cart::discountCode(); @endphp
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                        {{-- Discount code --}}
                        <div class="lg:max-w-sm w-full">
                            @if ($code)
                                <div class="flex items-center justify-between gap-3 rounded-lg bg-white border border-gray-200 px-4 py-3">
                                    <span class="flex items-center gap-2 text-sm text-gray-700">
                                        <x-icon name="tag" class="w-5 h-5 text-indigo-600"/>
                                        <span><span class="font-semibold">{{ $code->code }}</span> · {{ $code->label }}</span>
                                    </span>
                                    <form method="POST" action="{{ route('cart.code.remove') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-600">{{ __('Remove') }}</button>
                                    </form>
                                </div>
                                @if ($problem = $code->problem(Cart::total(), auth()->user()))
                                    <p class="mt-2 text-sm text-yellow-800">{{ $problem }}</p>
                                @endif
                            @else
                                <form method="POST" action="{{ route('cart.code') }}" class="space-y-1">
                                    @csrf
                                    <label for="code" class="block text-sm font-medium text-gray-700">{{ __('Discount code') }}</label>
                                    <div class="flex gap-2">
                                        <input id="code" name="code" value="{{ old('code') }}" autocomplete="off" placeholder="DEMO10"
                                               class="grow min-w-0 px-3 py-2 rounded-lg border uppercase focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('code') border-red-500 @else border-gray-300 @enderror"/>
                                        <button type="submit" class="px-4 py-2 rounded-lg bg-white border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-100">{{ __('Apply') }}</button>
                                    </div>
                                    @error('code')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                                    <p class="text-xs text-gray-500">{{ __('Demo: try the code DEMO10 for 10 % off.') }}</p>
                                </form>
                            @endif
                        </div>

                        {{-- Totals --}}
                        <dl class="space-y-1 lg:min-w-64">
                            @if ($code)
                                <div class="flex justify-between gap-6 text-gray-600">
                                    <dt>{{ __('Subtotal') }}</dt>
                                    <dd data-cart-subtotal>{{ formattedPrice(Cart::total()) }}</dd>
                                </div>
                                <div class="flex justify-between gap-6 text-green-700">
                                    <dt>{{ __('Discount') }}</dt>
                                    <dd data-cart-discount>−{{ formattedPrice(Cart::discount()) }}</dd>
                                </div>
                            @endif
                            <div class="flex items-baseline justify-between gap-6">
                                <dt class="text-xl font-medium text-gray-900">{{ __('Total') }}</dt>
                                <dd class="text-2xl font-bold text-gray-900" data-cart-total>{{ formattedPrice(Cart::grandTotal()) }}</dd>
                            </div>
                        </dl>
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

    <script src="{{ asset('js/cart.js') }}?v={{ filemtime(public_path('js/cart.js')) }}"></script>
</body>
</html>
