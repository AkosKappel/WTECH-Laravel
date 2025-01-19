<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('User Profile')])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')
    
    <main class="flex-grow container mx-auto px-4 py-8 my-24">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
                <form method="POST" action="{{ route('profile') }}">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Personal Information Section --}}
                        <section>
                            <div class="flex items-center justify-center md:justify-start mb-6">
                                <div class="bg-indigo-100 p-2 rounded-full">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-semibold text-gray-800 ml-3">{{ __('Personal Information') }}</h2>
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="name" class="text-sm font-medium text-gray-700">{{ __('First Name') }}:</label>
                                    <input value="{{ Auth()->user()->first_name }}" 
                                           id="name" 
                                           type="text" 
                                           name="first_name"
                                           class="col-span-2 w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" 
                                           placeholder="{{ __('Enter your first name') }}" />
                                </div>

                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="surname" class="text-sm font-medium text-gray-700">{{ __('Last Name') }}:</label>
                                    <input value="{{ Auth()->user()->last_name }}" 
                                           id="surname" 
                                           type="text" 
                                           name="last_name"
                                           class="col-span-2 w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" 
                                           placeholder="{{ __('Enter your last name') }}" />
                                </div>

                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="phone" class="text-sm font-medium text-gray-700">{{ __('Phone') }}:</label>
                                    <input value="{{ Auth()->user()->phone_number }}" 
                                           id="phone" 
                                           type="tel" 
                                           name="phone_number"
                                           class="col-span-2 w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" 
                                           placeholder="{{ __('Enter your phone number') }}" />
                                </div>

                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="email" class="text-sm font-medium text-gray-700">{{ __('Email') }}:</label>
                                    <input value="{{ Auth()->user()->email }}" 
                                           id="email" 
                                           type="email" 
                                           name="email"
                                           class="col-span-2 w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" 
                                           placeholder="{{ __('Enter your email') }}" />
                                </div>
                            </div>
                        </section>

                        {{-- Delivery Information Section --}}
                        <section>
                            <div class="flex items-center justify-center md:justify-start mb-6">
                                <div class="bg-indigo-100 p-2 rounded-full">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-semibold text-gray-800 ml-3">{{ __('Delivery Information') }}</h2>
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="street" class="text-sm font-medium text-gray-700">{{ __('Street') }}:</label>
                                    <input value="{{ Auth()->user()->street }}" 
                                           id="street" 
                                           type="text" 
                                           name="street"
                                           class="col-span-2 w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" 
                                           placeholder="{{ __('Enter street name') }}" />
                                </div>

                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="streetNumber" class="text-sm font-medium text-gray-700">{{ __('Street Number') }}:</label>
                                    <input value="{{ Auth()->user()->descriptive_number }}" 
                                           id="streetNumber" 
                                           type="text" 
                                           name="descriptive_number"
                                           class="col-span-2 w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" 
                                           placeholder="{{ __('Enter street number') }}" />
                                </div>

                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="town" class="text-sm font-medium text-gray-700">{{ __('City') }}:</label>
                                    <input value="{{ Auth()->user()->city }}" 
                                           id="town" 
                                           type="text" 
                                           name="city"
                                           class="col-span-2 w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" 
                                           placeholder="{{ __('Enter city') }}" />
                                </div>

                                <div class="grid grid-cols-3 items-center gap-4">
                                    <label for="country" class="text-sm font-medium text-gray-700">{{ __('Country') }}:</label>
                                    <input value="{{ Auth()->user()->country }}" 
                                           id="country" 
                                           type="text" 
                                           name="country"
                                           class="col-span-2 w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" 
                                           placeholder="{{ __('Enter country') }}" />
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- Messages and Errors --}}
                    @if (Session::has('message'))
                        <div class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                        <button type="submit" class="inline-flex justify-center items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Save Changes') }}
                        </button>
                        
                        <a href="{{ route('passwordChange') }}" class="inline-flex justify-center items-center px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            {{ __('Change Password') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
