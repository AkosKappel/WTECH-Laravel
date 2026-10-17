@use('App\Facades\Cart')
@php
    // current section for the navigation; product pages count as Products
    $navActive = [
        'products' => request()->routeIs('smartphones', 'details'),
        'about' => request()->routeIs('about'),
        'admin' => request()->routeIs('admin', 'admin.*', 'smartphones.add', 'smartphones.edit'),
    ];
@endphp
<a href="#content" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[70] focus:px-4 focus:py-2 focus:rounded-lg focus:bg-white focus:text-indigo-700 focus:shadow-lg">{{ __('Skip to content') }}</a>
@include('layout.partials.demo-banner')
@include('layout.partials.maintenance-notice')
<header class="bg-linear-to-r from-indigo-600 to-purple-600 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo & Primary Navigation --}}
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center" aria-label="{{ __('Home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ __('Logo') }}" class="h-8 w-auto hover:opacity-90 transition-opacity"/>
                        <span class="ml-3 text-3xl font-bold italic text-white tracking-tight hidden md:block lg:hidden xl:block">
                            SmartTech
                        </span>
                    </a>
                </div>
                
                {{-- Desktop Navigation --}}
                <nav class="hidden lg:ml-6 lg:flex lg:space-x-1 xl:ml-8 xl:space-x-8 items-center">
                    <a href="{{ route('smartphones') }}" @if ($navActive['products']) aria-current="page" @endif
                       class="text-white hover:text-indigo-100 px-3 py-2 text-sm font-medium whitespace-nowrap transition-colors {{ $navActive['products'] ? 'underline decoration-2 underline-offset-8' : '' }}">
                        {{ __('Products') }}
                    </a>
                    <a href="{{ route('about') }}" @if ($navActive['about']) aria-current="page" @endif
                       class="text-white hover:text-indigo-100 px-3 py-2 text-sm font-medium whitespace-nowrap transition-colors {{ $navActive['about'] ? 'underline decoration-2 underline-offset-8' : '' }}">
                        {{ __('About') }}
                    </a>
                    @can('adminZone')
                        <a href="{{ route('admin') }}" @if ($navActive['admin']) aria-current="page" @endif
                           class="text-white hover:text-indigo-100 px-3 py-2 text-sm font-medium whitespace-nowrap transition-colors {{ $navActive['admin'] ? 'underline decoration-2 underline-offset-8' : '' }}">
                            {{ __('Admin') }}
                        </a>
                    @endcan
                </nav>
            </div>

            {{-- Right Side Actions --}}
            <div class="flex items-center space-x-4">
                {{-- Search Bar --}}
                <div class="hidden sm:block">
                    @include('layout.partials.search-box', ['id' => 'header-search'])
                </div>

                {{-- Language and theme --}}
                <div class="hidden lg:flex items-center gap-1">
                    @include('layout.partials.locale-switcher', ['variant' => 'dropdown'])
                    @include('layout.partials.theme-toggle')
                </div>

                {{-- User Menu --}}
                @if (Auth::check())
                    <div class="relative group">
                        <button id="user-menu-button" aria-label="{{ __('Profile') }}" aria-haspopup="true" aria-expanded="false" aria-controls="user-menu" class="flex items-center bg-indigo-500/50 hover:bg-indigo-500/70 rounded-full py-2 px-4 transition-colors">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>
                        
                        <div id="user-menu" class="absolute right-0 w-56 mt-2 py-2 bg-white rounded-lg shadow-xl hidden group-hover:block group-focus-within:block">
                            <p class="px-4 pb-2 mb-1 border-b border-gray-100 text-xs text-gray-500 truncate" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</p>
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">{{ __('Profile') }}</a>
                            <a href="{{ route('orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">{{ __('My orders') }}</a>
                            <a href="{{ route('wishlist') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">{{ __('Wishlist') }}</a>
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
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-pink-500 rounded-full" data-cart-count>
                            {{ Cart::count() }}
                        </span>
                    @endif
                </a>

                {{-- Mobile menu button --}}
                <div class="flex lg:hidden">
                    <button type="button" aria-expanded="false" aria-controls="mobile-menu" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-white hover:text-indigo-100 hover:bg-indigo-500/70 transition-colors" aria-label="{{ __('Toggle menu') }}">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden mobile-menu lg:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <div class="sm:hidden px-1 pb-2">
                @include('layout.partials.search-box', ['id' => 'mobile-search'])
            </div>
            <a href="{{ route('smartphones') }}" @if ($navActive['products']) aria-current="page" @endif
               class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-indigo-100 hover:bg-indigo-500/70 transition-colors {{ $navActive['products'] ? 'bg-indigo-500/70' : '' }}">
                {{ __('Products') }}
            </a>
            <a href="{{ route('about') }}" @if ($navActive['about']) aria-current="page" @endif
               class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-indigo-100 hover:bg-indigo-500/70 transition-colors {{ $navActive['about'] ? 'bg-indigo-500/70' : '' }}">
                {{ __('About') }}
            </a>
            @can('adminZone')
                <a href="{{ route('admin') }}" @if ($navActive['admin']) aria-current="page" @endif
                   class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-indigo-100 hover:bg-indigo-500/70 transition-colors {{ $navActive['admin'] ? 'bg-indigo-500/70' : '' }}">
                    {{ __('Admin') }}
                </a>
            @endcan
            <div class="pt-2 mt-2 border-t border-white/20 flex items-center justify-between gap-2">
                @include('layout.partials.locale-switcher', ['variant' => 'list'])
                @include('layout.partials.theme-toggle', ['class' => 'mr-2'])
            </div>
        </div>
    </div>
</header>
{{-- target of the skip link: the page content starts here --}}
<div id="content" tabindex="-1" class="outline-hidden"></div>
@include('layout.partials.toast')
@php $compareCount = count(session(\App\Http\Controllers\CompareController::SESSION_KEY, [])); @endphp
@if ($compareCount > 0 && !request()->routeIs('compare'))
    {{-- phones picked for comparison, on every page until the comparison is cleared --}}
    <a href="{{ route('compare') }}" class="fixed bottom-4 left-4 z-40 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-600 text-sm font-medium text-white shadow-lg hover:bg-indigo-700">
        <x-icon name="scale"/>{{ __('Compare (:count)', ['count' => $compareCount]) }}
    </a>
@endif

<script src="{{ asset('js/search-suggest.js') }}?v={{ filemtime(public_path('js/search-suggest.js')) }}" defer></script>
<script src="{{ asset('js/theme.js') }}?v={{ filemtime(public_path('js/theme.js')) }}" defer></script>
<script>
// close the language dropdown when clicking outside it or pressing Escape
document.addEventListener('click', function (event) {
    document.querySelectorAll('details.locale-switcher[open]').forEach(function (details) {
        if (!details.contains(event.target)) details.removeAttribute('open');
    });
});
document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') document.querySelectorAll('details.locale-switcher[open]').forEach(function (d) { d.removeAttribute('open'); });
});
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const btn = document.querySelector('.mobile-menu-button');
    const menu = document.querySelector('.mobile-menu');

    btn.addEventListener('click', () => {
        btn.setAttribute('aria-expanded', String(!menu.classList.toggle('hidden')));
    });

    // User menu dropdown (only rendered for signed-in users)
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');

    userMenuButton?.addEventListener('click', () => {
        userMenuButton.setAttribute('aria-expanded', String(!userMenu.classList.toggle('hidden')));
    });
});
</script>

