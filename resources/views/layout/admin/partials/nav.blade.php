{{-- Tabs between the admin pages --}}
<nav class="flex gap-2 mx-auto w-11/12 2xl:w-4/5 mb-6" aria-label="{{ __('Admin') }}">
    @foreach (['admin' => __('Products'), 'admin.orders' => __('Orders')] as $route => $label)
        <a href="{{ route($route) }}"
           @if (request()->routeIs($route)) aria-current="page" @endif
           class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ request()->routeIs($route) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-indigo-50' }}">
            {{ $label }}
        </a>
    @endforeach
</nav>
