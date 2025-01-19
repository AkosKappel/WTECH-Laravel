<header class="bg-gradient-to-r from-indigo-600 to-purple-600 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo & Primary Navigation --}}
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center" aria-label="{{ __('Home') }}">
                        <img src="{{ url('wtech/images/logo.png') }}" alt="{{ __('Logo') }}" class="h-8 w-auto hover:opacity-90 transition-opacity"/>
                    </a>
                </div>
                
                {{-- Desktop Navigation --}}
                <nav class="hidden md:ml-8 md:flex md:space-x-8 items-center">
                    <a href="{{ route('smartphones') }}" class="text-white hover:text-indigo-100 px-3 py-2 text-sm font-medium transition-colors">
                        {{ __('Products') }}
                    </a>
                    <a href="#" class="text-white hover:text-indigo-100 px-3 py-2 text-sm font-medium transition-colors">
                        {{ __('Terms and Conditions') }}
                    </a>
                    @if(Auth::check() && Auth::user()->role == 'admin')
                        <a href="{{ route('admin') }}" class="text-white hover:text-indigo-100 px-3 py-2 text-sm font-medium transition-colors">
                            {{ __('Admin') }}
                        </a>
                    @endif
                </nav>
            </div>

            {{-- Right Side Actions --}}
            <div class="flex items-center space-x-4">
                {{-- Search Bar --}}
                <div class="hidden sm:block">
                    <form action="{{ route('smartphones') }}" method="GET" class="relative">
                        <input type="search" 
                               name="search" 
                               placeholder="{{ __('Search smartphone...') }}" 
                               class="w-64 pl-4 pr-10 py-2 rounded-full text-sm bg-indigo-500/50 text-black placeholder-indigo-400 focus:outline-none focus:ring-2 focus:ring-white focus:bg-indigo-500/70 transition-colors"
                               autocomplete="off"/>
                        <button type="submit" class="absolute right-0 top-0 mt-2 mr-3" aria-label="{{ __('Search') }}">
                            <svg class="h-5 w-5 text-indigo-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- User Menu --}}
                @if (Auth::check())
                    <div class="relative group">
                        <button id="user-menu-button" class="flex items-center space-x-3 bg-indigo-500/50 hover:bg-indigo-500/70 rounded-full py-2 px-4 transition-colors">
                            <span class="hidden lg:block text-sm text-white">{{ Auth::user()->email }}</span>
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>
                        
                        <div id="user-menu" class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-lg shadow-xl hidden group-hover:block">
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">{{ __('Profile') }}</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">
                                    {{ __('Sign Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-indigo-500/50 hover:bg-indigo-500/70 transition-colors">
                        {{ __('Sign In') }}
                    </a>
                @endif

                {{-- Cart --}}
                <a href="{{ route('cart') }}" class="relative inline-flex items-center p-2 text-white hover:text-indigo-100 transition-colors" aria-label="{{ __('Shopping Cart') }}">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if(Cart::count() > 0)
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-pink-500 rounded-full">
                            {{ Cart::count() }}
                        </span>
                    @endif
                </a>

                {{-- Mobile menu button --}}
                <div class="flex md:hidden">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-white hover:text-indigo-100 hover:bg-indigo-500/70 transition-colors" aria-label="{{ __('Toggle menu') }}">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div class="hidden mobile-menu md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('smartphones') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-indigo-100 hover:bg-indigo-500/70 transition-colors">
                {{ __('Products') }}
            </a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-indigo-100 hover:bg-indigo-500/70 transition-colors">
                {{ __('Terms and Conditions') }}
            </a>
            @if(Auth::check() && Auth::user()->role == 'admin')
                <a href="{{ route('admin') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-indigo-100 hover:bg-indigo-500/70 transition-colors">
                    {{ __('Admin') }}
                </a>
            @endif
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const btn = document.querySelector('.mobile-menu-button');
    const menu = document.querySelector('.mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });

    // User menu dropdown
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');

    userMenuButton.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
    });
});
</script>
