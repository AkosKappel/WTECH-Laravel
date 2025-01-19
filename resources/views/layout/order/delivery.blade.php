<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Delivery Method') ])
</head>

<body class="font-sans bg-gray-50">
    @include('layout.partials.header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-5xl mx-auto mb-16">
            {{-- Progress Steps --}}
            <div class="mb-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Your Order') }}</h1>
                <div class="flex items-center justify-start space-x-4 sm:hidden">
                    <span class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">2</span>
                    <span class="ml-2 font-semibold text-indigo-600">{{ __('Shipping') }}</span>
                </div>
                <div class="flex items-center justify-start space-x-4 hidden sm:flex">
                    <div class="flex items-center">
                        <span class="h-8 w-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-semibold">1</span>
                        <span class="ml-2 text-gray-600">{{ __('Address') }}</span>
                    </div>
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex items-center">
                        <span class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">2</span>
                        <span class="ml-2 font-semibold text-indigo-600">{{ __('Shipping') }}</span>
                    </div>
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a 1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex items-center">
                        <span class="h-8 w-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-semibold">3</span>
                        <span class="ml-2 text-gray-600">{{ __('Payment') }}</span>
                    </div>
                </div>
            </div>

            {{-- Delivery Options Form --}}
            <form action="{{ route('delivery.store') }}" method="POST" class="bg-white shadow-sm rounded-lg overflow-hidden">
                @csrf
                <div class="bg-white rounded-lg shadow divide-y divide-gray-200">
                    {{-- Courier Delivery --}}
                    <label class="relative flex items-center p-4 cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="radio" 
                               name="transport" 
                               value="Courier Delivery"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                               {{ Session::get('delivery') === "Courier Delivery" ? 'checked' : '' }}/>
                        <div class="ml-4 flex-grow">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">{{ __('Courier Delivery') }}</p>
                                <span class="text-sm font-semibold text-gray-900">0.00 €</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Delivery within 1-2 business days') }}</p>
                        </div>
                    </label>

                    {{-- Personal Pickup --}}
                    <label class="relative flex items-center p-4 cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="radio" 
                               name="transport" 
                               value="Personal Pickup"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                               {{ Session::get('delivery') === "Personal Pickup" ? 'checked' : '' }}/>
                        <div class="ml-4 flex-grow">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">{{ __('Personal Pickup') }}</p>
                                <span class="text-sm font-semibold text-gray-900">0.00 €</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Available immediately at our store') }}</p>
                        </div>
                    </label>

                    {{-- Post Office Delivery --}}
                    <label class="relative flex items-center p-4 cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="radio" 
                               name="transport" 
                               value="Post Office Delivery"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                               {{ Session::get('delivery') === "Post Office Delivery" ? 'checked' : '' }}/>
                        <div class="ml-4 flex-grow">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">{{ __('Post Office Delivery') }}</p>
                                <span class="text-sm font-semibold text-gray-900">0.00 €</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Delivery to your local post office') }}</p>
                        </div>
                    </label>

                    {{-- Parcel Locker --}}
                    <label class="relative flex items-center p-4 cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="radio" 
                               name="transport" 
                               value="Parcel Locker"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                               {{ Session::get('delivery') === "Parcel Locker" ? 'checked' : '' }}/>
                        <div class="ml-4 flex-grow">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">{{ __('Parcel Locker') }}</p>
                                <span class="text-sm font-semibold text-gray-900">0.00 €</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Pick up at your convenient location') }}</p>
                        </div>
                    </label>
                </div>

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    {{ __('There were errors with your submission') }}
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Navigation Buttons --}}
                <div class="bg-gray-50 px-8 py-6 flex items-center justify-between">
                    <a 
                        href="{{ route('address') }}" 
                        class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Back to Address') }}
                    </a>
                    <button 
                        type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        {{ __('Continue to Payment') }}
                        <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
