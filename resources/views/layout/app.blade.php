<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => 'SmartTech | ' . __('Smartphone Eshop')])
    @php
        // the site name and its search box for search results
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'SmartTech',
            'url' => route('home'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => route('smartphones') . '?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    @endphp
    <script type="application/ld+json">@json($structuredData)</script>
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
                            <div class="absolute inset-0 bg-linear-to-r from-indigo-600 to-purple-600 rounded-2xl rotate-6 opacity-10"></div>
                            <img src="{{ asset('images/iphone.png') }}" 
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
                            <div class="flex items-start space-x-4 bg-white p-4 rounded-xl shadow-xs hover:shadow-md transition-shadow">
                                <div class="shrink-0">
                                    <div class="w-10 h-10 bg-linear-to-r from-indigo-600 to-purple-600 rounded-full flex items-center justify-center">
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
                                   class="inline-flex items-center px-8 py-3 text-lg font-medium text-white bg-linear-to-r from-indigo-600 to-purple-600 rounded-full hover:from-indigo-700 hover:to-purple-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform hover:scale-105">
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

                {{-- Carousel: scroll-snap track, swipeable on touch; carousel.js adds the buttons' scrolling and auto-play --}}
                <div class="carousel relative" data-carousel aria-roledescription="carousel" aria-label="{{ __('Best Selling Products') }}">
                    <div class="carousel-track flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth motion-reduce:scroll-auto pb-2" data-carousel-track tabindex="0">
                        @foreach($smartphones as $smartphone)
                            <div class="snap-start shrink-0 w-full sm:w-[calc((100%-1.5rem)/2)] lg:w-[calc((100%-3rem)/3)]"
                                 aria-roledescription="slide" aria-label="{{ $loop->iteration }} / {{ $loop->count }}">
                                @include('layout.partials.product-card', ['smartphone' => $smartphone, 'level' => 3])
                            </div>
                        @endforeach
                    </div>
                    @if ($smartphones->count() > 1)
                        <div class="mt-6 flex justify-center gap-3">
                            <button type="button" data-carousel-prev aria-label="{{ __('Previous') }}"
                                    class="p-3 rounded-full bg-white border border-gray-200 shadow-xs text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button type="button" data-carousel-next aria-label="{{ __('Next') }}"
                                    class="p-3 rounded-full bg-white border border-gray-200 shadow-xs text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Marketing Section --}}
        <section class="py-16 px-4 sm:px-6 lg:px-8 bg-linear-to-r from-blue-50 to-indigo-50">
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
                    <a href="{{ route('smartphones', ['brand' => \Illuminate\Support\Str::slug($brand->name)]) }}" class="group relative bg-gray-100 rounded-lg shadow-lg p-6 hover:scale-105 transition-transform hover:shadow-xl">
                        <div class="flex items-center justify-center">
                            @include('layout.partials.brand-logo', ['brand' => $brand, 'size' => 'w-16 h-16'])
                        </div>
                        <div class="mt-6 text-center">
                            <h3 class="text-xl font-bold italic text-gray-800 transition-colors duration-300 hover:text-indigo-600">
                                {{ $brand->name }}
                            </h3>
                        </div>
                        <div class="absolute inset-0 rounded-lg bg-linear-to-t from-transparent to-gray-100 opacity-50"></div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    @include('layout.partials.footer')
    <script src="{{ asset('js/carousel.js') }}?v={{ filemtime(public_path('js/carousel.js')) }}" defer></script>
</body>
</html>
