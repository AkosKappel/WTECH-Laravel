{{-- Tabs between the admin pages (the header's "Admin" link leads to the products), and the notice for demo admins --}}
<div class="mx-auto w-11/12 2xl:w-4/5 mb-6 space-y-4">
    @if (auth()->user()->isDemoAdmin())
        <div class="rounded-lg bg-yellow-50 border border-yellow-200 p-4 text-sm text-yellow-900" role="note">
            <span class="font-semibold">{{ __('Demo admin.') }}</span>
            {{ __('You can add products and edit or delete the ones you added. They are only visible to demo admins, never in the shop, and are deleted every night.') }}
        </div>
    @endif
    @can('isAdmin')
        <nav class="flex flex-wrap gap-2" aria-label="{{ __('Admin') }}">
            @foreach (\App\Support\AdminPages::all() as $route => [$label, $patterns])
                <a href="{{ route($route) }}"
                   @if (request()->routeIs(...$patterns)) aria-current="page" @endif
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ request()->routeIs(...$patterns) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-indigo-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </nav>
    @endcan
</div>
