<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Smartphone Eshop')])
</head>
<body class="font-sans text-gray-800 bg-gray-50">
    @include('layout.partials.header')
    
    <main class="min-h-screen container mx-auto">
        @if (session()->has('success_message'))
            <div class="flex justify-center bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3 m-6" role="alert">
                <p class="font-bold">{{ session()->get('success_message') }}</p>
            </div>
        @endif

        {{-- Hero Section --}}
        <section class="py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-center font-bold text-3xl lg:text-5xl text-gray-900 mb-8">
                    {{ __('Why Choose Our Smartphone Shop?') }}
                </h1>
                
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-8 items-center max-w-5xl mx-auto">
                    {{-- Image Column --}}
                    <div class="hidden sm:block sm:col-span-5">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl transform rotate-6 opacity-10"></div>
                            <img src="{{ url('wtech/images/iphone.png') }}" 
                                 alt="{{ __('Featured Image') }}" 
                                 class="relative z-10 w-full max-w-md mx-auto"/>
                        </div>
                    </div>
                    
                    {{-- Features Column --}}
                    <div class="sm:col-span-7 space-y-6">
                        <div class="space-y-4">
                            {{-- Feature Items --}}
                            @foreach([
                                'Free Shipping' => 'Enjoy free delivery on all orders',
                                'Best Price Guarantee' => 'We match any competitor\'s price',
                                '2-Year Premium Warranty' => 'Extended protection for your device'
                            ] as $title => $description)
                            <div class="flex items-start space-x-4 bg-white p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ __($title) }}</h3>
                                    <p class="text-gray-600">{{ __($description) }}</p>
                                </div>
                            </div>
                            @endforeach
                            
                            {{-- CTA Button --}}
                            <div class="mt-8 text-center sm:text-left">
                                <a href="{{ route('smartphones') }}" 
                                   class="inline-flex items-center px-8 py-3 text-lg font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-transform hover:scale-105">
                                    {{ __('Buy Your Smartphone Today') }}
                                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Best Sellers Section --}}
        <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-4">
                        {{ __('Best Selling Products') }}
                    </h2>
                    <p class="text-xl text-gray-600">
                        {{ __('Most loved by our customers') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($smartphones as $smartphone)
                    <div class="group">
                        <a href="{{ route('details', $smartphone->id) }}" 
                           class="block bg-gray-50 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                @if($smartphone->images->first())
                                <img src="{{ url('wtech/' . $smartphone->images->first()->source) }}" 
                                     alt="{{ $smartphone->images->first()->name }}"
                                     class="h-64 w-full object-cover object-center group-hover:opacity-75 transition-opacity"/>
                                @else
                                <img src="{{ url('wtech/images/no_img_available.jpg') }}" 
                                     alt="{{ __('No image available') }}"
                                     class="h-64 w-full object-cover object-center"/>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $smartphone->name }}</h3>
                                <p class="text-xl font-bold text-indigo-600">{{ formattedPrice($smartphone->price) }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Marketing Section --}}
        <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-5xl font-extrabold text-indigo-900 mb-4">
                        {{ __('Experience the Future with Our Smartphones') }}
                    </h2>
                    <p class="text-xl text-indigo-700">
                        {{ __('Unlock endless possibilities, where innovation meets elegance.') }}
                    </p>
                    <blockquote class="mt-8 text-lg text-gray-800 italic">
                        "{{ __('Revolutionizing the way you connect with the world.') }}"
                    </blockquote>
                </div>
            </div>
        </section>

        {{-- Featured Brands Section --}}
        <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 mb-16">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-4xl lg:text-6xl font-extrabold text-gray-900 mb-4">
                        {{ __('Featured Brands') }}
                    </h2>
                    <p class="text-2xl text-gray-700">
                        {{ __('Discover the best smartphones from top brands') }}
                    </p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-8">
                    @foreach($brands as $brand)
                    <a href="{{ route('smartphones', [$brand->name => $brand->name]) }}" class="group relative bg-gray-100 rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform hover:shadow-xl">
                        <div class="flex items-center justify-center">
                            <div class="w-16 h-16 bg-indigo-200 rounded-full flex items-center justify-center">
                                <span class="text-4xl font-bold text-gray-800">{{ mb_substr($brand->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="mt-6 text-center">
                            <h3 class="text-xl font-bold italic text-gray-800 transition-colors duration-300 hover:text-indigo-600">
                                {{ $brand->name }}
                            </h3>
                        </div>
                        <div class="absolute inset-0 rounded-lg bg-gradient-to-t from-transparent to-gray-100 opacity-50"></div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    @include('layout.partials.footer')
</body>
</html>
