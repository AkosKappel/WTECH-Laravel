<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Payment Method') ])
</head>

<body class="font-sans bg-gray-50">
    @include('layout.partials.header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-5xl mx-auto mb-16">
            {{-- Progress Steps --}}
            <div class="mb-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Your Order') }}</h1>
                <div class="flex items-center justify-start space-x-4 sm:hidden">
                    <span class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">3</span>
                    <span class="ml-2 font-semibold text-indigo-600">{{ __('Payment') }}</span>
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
                        <span class="h-8 w-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-semibold">2</span>
                        <span class="ml-2 text-gray-600">{{ __('Shipping') }}</span>
                    </div>
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex items-center">
                        <span class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">3</span>
                        <span class="ml-2 font-semibold text-indigo-600">{{ __('Payment') }}</span>
                    </div>
                </div>
            </div>

            {{-- Payment Options Form --}}
            <form action="{{ route('payment.store') }}" method="POST" class="bg-white shadow-sm rounded-lg overflow-hidden">
                @csrf
                <div class="bg-white rounded-lg shadow divide-y divide-gray-200">
                    {{-- Cash on Delivery --}}
                    <label class="relative flex items-center p-4 cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="radio" 
                               name="payment" 
                               value="Cash on Delivery"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                               {{ Session::get('payment') === "Cash on Delivery" ? 'checked' : '' }}/>
                        <div class="ml-4 flex-grow">
                            <p class="text-sm font-medium text-gray-900">{{ __('Cash on Delivery') }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Pay when you receive your order') }}</p>
                        </div>
                    </label>

                    {{-- Bank Transfer --}}
                    <label class="relative flex items-center p-4 cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="radio" 
                               name="payment" 
                               value="Bank Transfer"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                               {{ Session::get('payment') === "Bank Transfer" ? 'checked' : '' }}/>
                        <div class="ml-4 flex-grow">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">{{ __('Bank Transfer') }}</p>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Pay directly from your bank account') }}</p>
                        </div>
                    </label>

                    {{-- Credit Card --}}
                    <label class="relative flex items-center p-4 cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="radio" 
                               name="payment" 
                               value="Credit Card"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                               {{ Session::get('payment') === "Credit Card" ? 'checked' : '' }}/>
                        <div class="ml-4 flex-grow">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">{{ __('Credit Card') }}</p>
                                <span class="ml-auto flex space-x-2">
                                    <svg class="h-8" viewBox="0 0 36 24" fill="none"><rect width="36" height="24" rx="4" fill="#1434CB"/><path d="M15.48 15.6h-2.16l1.35-8.16h2.16l-1.35 8.16Zm-4.13-8.16-2.07 5.6-.24-1.23-.72-3.68a.8.8 0 0 0-.9-.69H4.32l-.05.17c.53.11 1.13.29 1.5.48.45.24.57.45.72 1.02l2.42 5.49h2.04l3.78-8.16h-2.01Zm16.76 8.16h1.98l-1.72-8.16h-1.71c-.39 0-.72.23-.86.58l-3.03 7.58h2.01l.42-1.16h2.58l.33 1.16Zm-2.23-2.92.36-1 .69-1.89.39 1.89.21 1h-1.65Zm-3.24-2.83c.009-.674-.504-1.24-1.17-1.3h-2.13l-1.35 8.16h2.01l.54-3.27h.15c.39 0 .9 0 1.38-.3.48-.3.78-.75.57-1.53v.003Zm-1.29.27c-.24.69-1.17.63-1.5.63l.27-1.59c.84.015 1.47-.12 1.23.96Z" fill="#fff"/></svg>
                                    <svg class="h-8" viewBox="0 0 36 24" fill="none"><rect width="36" height="24" rx="4" fill="#FF5F00"/><path d="M22.53 12a5.73 5.73 0 0 1-2.19 4.5c-1.35 1.05-3.06 1.62-4.84 1.62-1.78 0-3.49-.57-4.84-1.62A5.73 5.73 0 0 1 8.47 12c0-1.76.79-3.45 2.19-4.5 1.35-1.05 3.06-1.62 4.84-1.62 1.78 0 3.49.57 4.84 1.62a5.73 5.73 0 0 1 2.19 4.5Z" fill="#EB001B"/><path d="M27.53 12c0 3.31-2.69 6-6 6-1.78 0-3.49-.57-4.84-1.62a5.73 5.73 0 0 0 2.19-4.5c0-1.76-.79-3.45-2.19-4.5 1.35-1.05 3.06-1.62 4.84-1.62 3.31 0 6 2.69 6 6Z" fill="#F79E1B"/></svg>
                                </span>
                            </div>
                        </div>
                    </label>

                    {{-- Apple Pay --}}
                    <label class="relative flex items-center p-4 cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="radio" 
                               name="payment" 
                               value="Apple Pay"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                               {{ Session::get('payment') === "Apple Pay" ? 'checked' : '' }}/>
                        <div class="ml-4 flex-grow">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">{{ __('Apple Pay') }}</p>
                                <svg class="ml-auto h-8" viewBox="0 0 36 24" fill="none">
                                    <rect width="36" height="24" rx="4" fill="#000"/>
                                    <path d="M12.43 8.72c.235-.374.41-.8.51-1.25.06-.27.09-.54.09-.81-.03-.09-.09-.12-.15-.09-.33.15-.63.36-.87.63-.3.36-.48.81-.51 1.29 0 .09.06.15.15.12.27-.12.51-.27.75-.48.087-.121.165-.249.233-.383l.007-.017Z" fill="#fff"/>
                                    <path d="M13.09 7.47c.54.03 1.05.24 1.44.6.15.12.27.27.39.42.06.09.12.09.21.03.45-.3.93-.48 1.47-.54.84-.09 1.56.15 2.16.75.09.09.09.12-.03.18-.51.27-.87.69-1.05 1.23-.27.84-.12 1.59.45 2.25.09.12.21.21.33.3.06.06.09.09 0 .15-.39.27-.75.57-1.08.9-.21.21-.42.39-.66.54-.15.09-.27.09-.42 0-.36-.24-.75-.42-1.17-.51-.48-.09-.93-.06-1.38.09-.15.06-.27.06-.42-.03-.54-.3-1.02-.69-1.47-1.11-.66-.63-1.2-1.35-1.56-2.19-.27-.63-.42-1.29-.36-1.98.09-.93.45-1.71 1.17-2.31.42-.36.9-.6 1.44-.69.15-.03.33-.06.48-.06h.06Z" fill="#fff"/>
                                </svg>
                            </div>
                        </div>
                    </label>

                    {{-- Google Pay --}}
                    <label class="relative flex items-center p-4 cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="radio" 
                               name="payment" 
                               value="Google Pay"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                               {{ Session::get('payment') === "Google Pay" ? 'checked' : '' }}/>
                        <div class="ml-4 flex-grow">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">{{ __('Google Pay') }}</p>
                                <svg class="ml-auto h-8" viewBox="0 0 36 24" fill="none">
                                    <rect width="36" height="24" rx="4" fill="#fff"/>
                                    <path d="M18.5 11.55v2.4h3.45c-.15.9-.975 2.7-3.45 2.7-2.1 0-3.75-1.725-3.75-3.9s1.65-3.9 3.75-3.9c1.2 0 1.95.525 2.4.975l1.65-1.575C21.45 7.2 20.1 6.6 18.5 6.6c-3.3 0-6 2.7-6 6s2.7 6 6 6c3.45 0 5.775-2.4 5.775-5.775 0-.375-.075-.675-.15-.975h-5.625v.3Z" fill="#4285F4"/>
                                </svg>
                            </div>
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
                        href="{{ route('delivery') }}" 
                        class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Back to Shipping') }}
                    </a>
                    <button 
                        type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        {{ __('Confirm order') }}
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
