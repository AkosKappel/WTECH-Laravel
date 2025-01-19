<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Product Details')])
    <link href="{{ url('wtech/css/quantity-selector.css') }}" rel="stylesheet" type="text/css">
</head>

<body class="bg-gray-50">
    @include('layout.partials.header')

    <main class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Product Overview Section --}}
            <div class="grid lg:grid-cols-2 gap-12 mb-16">
                {{-- Image Gallery --}}
                <section class="space-y-4">
                    <div class="relative aspect-square bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-200">
                        @if($smartphone->images->first())
                            <img 
                                id="mainImage" 
                                src="{{ url('wtech/' . $smartphone->images->first()->source) }}"
                                alt="{{ $smartphone->images->first()->name }}"
                                class="w-full h-full object-cover"
                            />
                        @else
                            <img 
                                src="{{ url('wtech/images/no_img_available.jpg') }}"
                                alt="{{ __('No image available') }}"
                                class="w-full h-full object-cover"
                            />
                        @endif
                    </div>

                    @if($smartphone->images->count() > 1)
                        <div class="flex justify-center space-x-4">
                            <button 
                                id="prev-img-btn"
                                class="p-3 rounded-full bg-indigo-600 text-white hover:bg-indigo-700 transition-colors shadow-lg"
                                aria-label="{{ __('Previous image') }}"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button 
                                id="next-img-btn"
                                class="p-3 rounded-full bg-indigo-600 text-white hover:bg-indigo-700 transition-colors shadow-lg"
                                aria-label="{{ __('Next image') }}"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>

                        <div class="hidden">
                            @foreach($smartphone->images as $image)
                                <img src="{{ url('wtech/' . $image->source) }}" alt="{{ $image->name }}" class="productImage">
                            @endforeach
                        </div>
                    @endif
                </section>

                {{-- Product Details --}}
                <section class="space-y-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $smartphone->name }}</h1>
                        <p id="product-price" class="text-2xl font-semibold text-indigo-600">{{ formattedPrice($smartphone->price) }}</p>
                    </div>

                    <form action="{{ route('cart.store') }}" method="POST" class="space-y-8">
                        @csrf
                        {{-- Hidden Fields --}}
                        <input type="hidden" name="smartphone" value="{{ $smartphone }}">
                        <input type="hidden" name="id" value="{{ $smartphone->id }}">
                        <input type="hidden" name="name" value="{{ $smartphone->name }}">
                        <input type="hidden" name="price" value="{{ $smartphone->price }}">
                        <input type="hidden" name="max_quantity" value="{{ $smartphone->quantity }}">
                        @if($smartphone->images->first())
                            <input type="hidden" name="image_source" value="{{ $smartphone->images->first()->source }}">
                            <input type="hidden" name="image_name" value="{{ $smartphone->images->first()->name }}">
                        @else
                            <input type="hidden" name="image_source" value="images/no_img_available.jpg">
                            <input type="hidden" name="image_name" value="{{ __('No image available') }}">
                        @endif

                        @if($smartphone->quantity > 0)
                            <div class="grid sm:grid-cols-2 gap-6">
                                {{-- Quantity Selector --}}
                                <div class="space-y-2">
                                    <label for="product-quantity" class="block text-sm font-medium text-gray-700">
                                        {{ __('Quantity') }}
                                    </label>
                                    <div class="flex rounded-lg shadow-sm w-40">
                                        <button 
                                            type="button" 
                                            data-action="decrement"
                                            class="px-4 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-l-lg transition-colors"
                                        >−</button>
                                        <input 
                                            type="number"
                                            id="product-quantity"
                                            name="quantity"
                                            value="1"
                                            min="1"
                                            max="{{ $smartphone->quantity }}"
                                            class="w-20 text-center border-y border-gray-200 focus:ring-indigo-500 focus:border-indigo-500"
                                        />
                                        <button 
                                            type="button"
                                            data-action="increment"
                                            class="px-4 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-r-lg transition-colors"
                                        >+</button>
                                    </div>
                                </div>

                                {{-- Total Price --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">
                                        {{ __('Total') }}
                                    </label>
                                    <div class="rounded-lg bg-gray-100 p-3">
                                        <span id="total-price" class="text-lg font-semibold text-gray-900">
                                            {{ formattedPrice($smartphone->price) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Add to Cart Button --}}
                            <button 
                                type="submit"
                                class="w-full flex items-center justify-center px-8 py-4 bg-indigo-600 text-white text-lg font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                            >
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ __('Add to Cart') }}
                            </button>
                        @else
                            {{-- Out of Stock Alert --}}
                            <div class="rounded-lg bg-red-50 p-4 border border-red-200">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">{{ __('Out of Stock') }}</h3>
                                        <p class="mt-2 text-sm text-red-700">{{ __('This product is currently unavailable.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </section>
            </div>

            {{-- Specifications and Description --}}
            <div class="grid lg:grid-cols-2 gap-12">
                {{-- Specifications --}}
                <section class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">{{ __('Specifications') }}</h2>
                    </div>
                    <dl class="divide-y divide-gray-200">
                        <div class="px-6 py-4 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">{{ __('Brand') }}</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{$smartphone->brand ? $smartphone->brand->name : __('Unknown manufacturer')}}</dd>
                        </div>
                        <div class="px-6 py-4 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">{{ __('Color') }}</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{$smartphone->color ? $smartphone->color->name_sk : ''}}</dd>
                        </div>
                        <div class="px-6 py-4 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">{{ __('RAM Memory') }}</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{$smartphone->ram ? $smartphone->ram . ' MB' : ''}}</dd>
                        </div>
                        <div class="px-6 py-4 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">{{ __('Operating System') }}</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{$smartphone->operating_system}}</dd>
                        </div>
                        <div class="px-6 py-4 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">{{ __('OS Version') }}</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{$smartphone->os_version}}</dd>
                        </div>
                        <div class="px-6 py-4 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">{{ __('Display Size') }}</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{$smartphone->display_size ? $smartphone->display_size . ' "' : ''}}</dd>
                        </div>
                        <div class="px-6 py-4 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">{{ __('Display Resolution') }}</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{$smartphone->resolution}}</dd>
                        </div>
                        <div class="px-6 py-4 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">{{ __('Height') }}</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{$smartphone->height ? $smartphone->height . ' mm' : ''}}</dd>
                        </div>
                        <div class="px-6 py-4 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">{{ __('Width') }}</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{$smartphone->width ? $smartphone->width . ' mm' : ''}}</dd>
                        </div>
                        <div class="px-6 py-4 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">{{ __('Depth') }}</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{$smartphone->thickness ? $smartphone->thickness . ' mm' : ''}}</dd>
                        </div>
                    </dl>
                </section>

                {{-- Description --}}
                <section class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">{{ __('Product Description') }}</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 leading-relaxed">{{$smartphone->description}}</p>
                    </div>
                </section>
            </div>
        </div>
    </main>

    @include('layout.partials.footer')
    <script src="{{ url('wtech/js/details.js') }}" type="text/javascript"></script>
</body>
</html>
