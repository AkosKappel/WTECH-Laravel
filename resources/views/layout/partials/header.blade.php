<header class="bg-blue-500 sticky top-0 z-10 shadow-lg">
    <div class="mx-auto px-4">
        <div class="flex flex-row">
            <nav class="flex flex-auto space-x-2 lg:space-x-7 items-center">
                <div>
                    <a href="/" class="flex items-center py-2 px-2">
                        <!-- https://pixabay.com/illustrations/smartphone-phone-android-ios-1818253/ -->
                        <img src="{{ url('/images/logo.png') }}" alt="logo" class="w-8 sm:w-12 mr-10 text-white"/>
                    </a>
                </div>
                <div class="hidden md:flex items-center divide-x-2 divide-white space-x-2">
                    <div>
                        <a href="#" class="text-white mr-2 font-semibold">Kontakt</a>
                    </div>
                    <div class="pl-3">
                        <a href="#" class="text-white mr-2 font-semibold">Obchodné podmienky</a>
                    </div>
                </div>
            </nav>
            <div class="flex space-x-2 lg:space-x-4 items-center mr-2 md:mr-0">
                <div class="hidden sm:inline">
                    <div class="relative text-gray-600 focus-within:text-gray-400">
                        <input type="search" name="search"
                               class="w-64 pl-5 pr-10 py-2 bg-white text-black placeholder-gray-600 focus:outline-none rounded-full"
                               placeholder="Tvoj vysnívaný smartfón" autocomplete="off"/>
                        <span class="absolute inset-y-0 right-0 flex items-center">
                            <img src="{{ url('/images/search.png')}}" alt="Vyhľadávanie" class="w-8 mr-2"/>
                        </span>
                    </div>
                </div>

                @if (Auth::check())
                    <div class="bg-white text-white font-bold py-1 px-2 focus:outline-none focus:shadow-outline rounded-full space-between inline-flex items-center">
                        <form method="GET" action="{{ route('profile') }}">
                            @csrf
                            <button type="submit" class="inline-flex">
                                <img src="{{ url('/images/person.png') }}" alt="Profil" class="w-8 mx-4"/>
                                <span class="hidden lg:inline text-black mt-1.5">
                                    {{ Auth::user()->email }}
                                </span>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">
                                <img src="{{ url('/images/logout-icon.png') }}" alt="Odhlásenie" class="w-8 mx-4"/>
                            </button>
                        </form>
                    </div>
                @else
                    <form method="GET" action="{{ route('login') }}">
                        @csrf
                        <button type="submit" class="bg-white text-white font-bold py-1 pl-2 lg:pr-10 focus:outline-none focus:shadow-outline rounded-full inline-flex items-center">
                            <img src="{{ url('/images/person.png') }}" alt="Prihlásenie" class="w-8 mr-2 lg:mr-6"/>
                            <span class="hidden lg:inline text-black">Prihlásiť sa</span>
                        </button>
                    </form>
                @endif

                <a href="{{ route('cart') }}">
                    <div class="w-14 py-1 bg-white text-white font-bold rounded focus:outline-none focus:shadow-outline rounded-full inline-flex items-center">
                        <img src="{{ url('/images/cart.png') }}" alt="Nákupný košík" class="w-8 ml-3"/>
                        <div class="relative ml-2">
                            <span class="absolute right-1 inline-flex items-center justify-center px-1 w-5 h-5 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full bottom-0">2</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="flex flex-end md:hidden items-center">
                <button class="outline-none mobile-menu-button">
                    <img src="{{ url('/images/menu.png') }}" alt="Navigácia" class="w-6 inline mx-1 md:mx-4"/>
                </button>
            </div>
        </div>
    </div>
    <nav class="hidden mobile-menu text-center">
        <ul>
            <li class="py-3">
                <a href="#" class="p-3 text-white font-semibold">Kontakt</a>
            </li>
            <li class="py-3">
                <a href="#" class="p-3 text-white font-semibold">Obchodné podmienky</a>
            </li>
        </ul>
    </nav>
</header>
