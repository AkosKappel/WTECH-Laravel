<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Delivery Address')])
</head>

<body class="font-sans bg-gray-50">
    @include('layout.partials.header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-5xl mx-auto mb-16">
            {{-- Checkout Steps --}}
            <div class="mb-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Your Order') }}</h1>
                <div class="flex items-center justify-start space-x-4 sm:hidden">
                    <span class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">1</span>
                    <span class="ml-2 font-semibold text-indigo-600">{{ __('Address') }}</span>
                </div>
                <div class="flex items-center justify-start space-x-4 hidden sm:flex">
                    <div class="flex items-center">
                        <span class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">1</span>
                        <span class="ml-2 font-semibold text-indigo-600">{{ __('Address') }}</span>
                    </div>
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex items-center">
                        <span class="h-8 w-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-semibold">2</span>
                        <span class="ml-2 text-gray-600">{{ __('Shipping') }}</span>
                    </div>
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex items-center">
                        <span class="h-8 w-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-semibold">3</span>
                        <span class="ml-2 text-gray-600">{{ __('Payment') }}</span>
                    </div>
                </div>
            </div>

            {{-- Address Form --}}
            <form action="{{ route('address.store') }}" method="POST" class="bg-white shadow-sm rounded-lg overflow-hidden">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        {{-- Personal Information --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Personal Information') }}</h3>
                            <div class="space-y-6">
                                {{-- First Name --}}
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('First Name') }}</label>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="first_name" 
                                        value="{{ old('first_name', Auth::check() ? Auth::user()->first_name : Session::get('first_name')) }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('first_name') border-red-500 @enderror"
                                    >
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Last Name --}}
                                <div>
                                    <label for="surname" class="block text-sm font-medium text-gray-700">{{ __('Last Name') }}</label>
                                    <input 
                                        type="text" 
                                        id="surname" 
                                        name="last_name"
                                        value="{{ old('last_name', Auth::check() ? Auth::user()->last_name : Session::get('last_name')) }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('last_name') border-red-500 @enderror"
                                    >
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Phone --}}
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('Phone') }}</label>
                                    <input 
                                        type="tel" 
                                        id="phone" 
                                        name="phone_number"
                                        value="{{ old('phone_number', Auth::check() ? Auth::user()->phone_number : Session::get('phone_number')) }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('phone_number') border-red-500 @enderror"
                                    >
                                    @error('phone_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email"
                                        value="{{ old('email', Auth::check() ? Auth::user()->email : Session::get('email')) }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                                    >
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Shipping Information --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Shipping Information') }}</h3>
                            <div class="space-y-6">
                                {{-- Street --}}
                                <div>
                                    <label for="street" class="block text-sm font-medium text-gray-700">{{ __('Street') }}</label>
                                    <input 
                                        type="text" 
                                        id="street" 
                                        name="street"
                                        value="{{ old('street', Auth::check() ? Auth::user()->street : Session::get('street')) }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('street') border-red-500 @enderror"
                                    >
                                    @error('street')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Street Number --}}
                                <div>
                                    <label for="streetNumber" class="block text-sm font-medium text-gray-700">{{ __('Street Number') }}</label>
                                    <input 
                                        type="text" 
                                        id="streetNumber" 
                                        name="descriptive_number"
                                        value="{{ old('descriptive_number', Auth::check() ? Auth::user()->descriptive_number : Session::get('descriptive_number')) }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('descriptive_number') border-red-500 @enderror"
                                    >
                                    @error('descriptive_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- City --}}
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">{{ __('City') }}</label>
                                    <input 
                                        type="text" 
                                        id="city" 
                                        name="city"
                                        value="{{ old('city', Auth::check() ? Auth::user()->city : Session::get('city')) }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('city') border-red-500 @enderror"
                                    >
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Country --}}
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700">{{ __('Country') }}</label>
                                    <input 
                                        type="text" 
                                        id="country" 
                                        name="country"
                                        value="{{ old('country', Auth::check() ? Auth::user()->country : Session::get('country')) }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('country') border-red-500 @enderror"
                                    >
                                    @error('country')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
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
                        href="{{ route('cart') }}" 
                        class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Back to Cart') }}
                    </a>
                    <button 
                        type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        {{ __('Continue to Shipping') }}
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
