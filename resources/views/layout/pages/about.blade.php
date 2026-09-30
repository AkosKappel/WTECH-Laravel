@extends('layout.pages.page', [
    'title' => __('About this project'),
    'wide' => true,
])

@section('hero')
    <header class="relative overflow-hidden rounded-2xl bg-linear-to-br from-indigo-600 via-indigo-600 to-purple-600 px-6 py-12 sm:px-12 sm:py-16 mb-12 shadow-lg">
        <div class="absolute -top-24 -right-16 h-64 w-64 rounded-full bg-white/10 blur-2xl" aria-hidden="true"></div>
        <div class="absolute -bottom-28 -left-10 h-72 w-72 rounded-full bg-purple-400/20 blur-3xl" aria-hidden="true"></div>

        <div class="relative max-w-2xl">
            <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white ring-1 ring-white/25">
                {{ __('Portfolio project') }}
            </span>
            <h1 class="mt-4 text-3xl sm:text-5xl font-bold tracking-tight text-white">{{ __('About this project') }}</h1>
            <p class="mt-4 text-lg leading-relaxed text-indigo-100">
                {{ __('SmartTech is a demo online shop for smartphones. It is a portfolio project, not a real business.') }}
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('smartphones') }}"
                   class="inline-flex items-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-indigo-700 shadow-sm hover:bg-indigo-50 focus:outline-hidden focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 transition-colors">
                    {{ __('Browse the catalog') }}
                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                @if (config('demo.links.repository'))
                    <a href="{{ config('demo.links.repository') }}" target="_blank" rel="noopener"
                       class="inline-flex items-center rounded-full px-6 py-3 text-sm font-semibold text-white ring-1 ring-white/40 hover:bg-white/10 focus:outline-hidden focus:ring-2 focus:ring-white transition-colors">
                        {{ __('Source code') }}
                    </a>
                @endif
            </div>
        </div>
    </header>
@endsection

@section('content')
    {{-- What the demo is --}}
    <section aria-labelledby="about-sample">
        <h2 id="about-sample" class="text-2xl font-bold text-gray-900">{{ __('A sample shop') }}</h2>
        <p class="mt-3 max-w-3xl text-gray-700 leading-relaxed">
            {{ __('Everything here works like a real e-shop: you can browse and filter the catalog, fill a cart, check out with or without an account, and manage products in the admin zone. But nothing is real:') }}
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-3">
            @foreach ([
                ['title' => __('No real orders'), 'text' => __('Orders are never shipped and no payment is ever taken.'),
                 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                ['title' => __('Sample data'), 'text' => __('Products, prices and stock are made up.'),
                 'icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4'],
                ['title' => __('Regular resets'), 'text' => null,
                 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
            ] as $fact)
                <div class="rounded-xl bg-white p-5 shadow-xs ring-1 ring-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-linear-to-br from-indigo-600 to-purple-600">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $fact['icon'] }}" />
                        </svg>
                    </div>
                    <h3 class="mt-4 font-semibold text-gray-900">{{ $fact['title'] }}</h3>
                    <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                        @if ($fact['text']) {{ $fact['text'] }} @else @include('layout.partials.reset-notice') @endif
                    </p>
                </div>
            @endforeach
        </div>

        <div class="mt-4 flex items-start gap-3 rounded-xl border border-indigo-100 bg-indigo-50 p-4 text-sm text-indigo-900">
            <svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <p>
                <span class="font-medium">{{ __('Please use made-up names, addresses and e-mails when you try it out.') }}</span>
                <a href="{{ route('privacy') }}" class="font-medium text-indigo-700 underline hover:text-indigo-900">{{ __('Privacy notice') }}</a>
            </p>
        </div>
    </section>

    {{-- History --}}
    <section aria-labelledby="about-history">
        <h2 id="about-history" class="text-2xl font-bold text-gray-900">{{ __('Where it comes from') }}</h2>
        <ol class="mt-6 relative border-l-2 border-indigo-100 ml-3 space-y-8">
            <li class="pl-8 relative">
                <span class="absolute -left-[9px] top-1.5 h-4 w-4 rounded-full bg-indigo-600 ring-4 ring-indigo-100" aria-hidden="true"></span>
                <p class="text-sm font-semibold text-indigo-600">2021/22</p>
                <h3 class="mt-1 text-lg font-semibold text-gray-900">{{ __('Course project') }}</h3>
                <div class="mt-2 space-y-3 text-gray-700 leading-relaxed">
                    <p>
                        {{ __('SmartTech started as the semester project for the Web Technologies (WTECH) course in the 2nd year of my Bachelor\'s studies at the') }}
                        <a href="https://www.fiit.stuba.sk/" target="_blank" rel="noopener" class="text-indigo-600 hover:text-indigo-800 underline">{{ __('Faculty of Informatics and Information Technologies, Slovak University of Technology in Bratislava') }}</a>
                        {{ __('(winter semester 2021/2022). It was my first project with Laravel.') }}
                    </p>
                    <p>
                        {{ __('The assignment was to build a server-side rendered e-shop with product filtering, pagination, search, a persistent shopping cart, guest checkout, customer accounts and an admin zone for managing products and images.') }}
                    </p>
                </div>
            </li>
            <li class="pl-8 relative">
                <span class="absolute -left-[9px] top-1.5 h-4 w-4 rounded-full bg-purple-600 ring-4 ring-purple-100" aria-hidden="true"></span>
                <p class="text-sm font-semibold text-purple-600">2025–2026</p>
                <h3 class="mt-1 text-lg font-semibold text-gray-900">{{ __('Portfolio revamp') }}</h3>
                <p class="mt-2 text-gray-700 leading-relaxed">
                    {{ __('In 2025 and 2026 I returned to it to prepare it for my portfolio: I containerised it with Docker, redesigned every page, fixed bugs and security issues, and deployed it on my own home server.') }}
                </p>
            </li>
        </ol>
    </section>

    {{-- Things to try --}}
    <section aria-labelledby="about-try">
        <h2 id="about-try" class="text-2xl font-bold text-gray-900">{{ __('Things to try') }}</h2>
        <ol class="mt-6 grid gap-4 md:grid-cols-3">
            @foreach ([
                '<a href="' . e(route('smartphones')) . '" class="font-medium text-indigo-600 hover:text-indigo-800 underline">' . e(__('Browse the catalog')) . '</a> ' . e(__('and combine the price, brand and colour filters with sorting and search.')),
                e(__('Add a phone to the cart, change the quantity and go through the three-step checkout as a guest.')),
                e(__('Tick "Create an account" at the end of the checkout, then log out and back in: your cart is kept between sessions.')),
            ] as $step)
                <li class="flex gap-4 rounded-xl bg-white p-5 shadow-xs ring-1 ring-gray-100">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-bold text-indigo-700" aria-hidden="true">{{ $loop->iteration }}</span>
                    <p class="text-sm text-gray-700 leading-relaxed">{!! $step !!}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- Tech stack --}}
    <section aria-labelledby="about-stack">
        <h2 id="about-stack" class="text-2xl font-bold text-gray-900">{{ __('Built with') }}</h2>
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['name' => __('Backend'), 'items' => ['Laravel', 'PHP', 'PHPUnit'],
                 'icon' => 'M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01'],
                ['name' => __('Database'), 'items' => ['PostgreSQL'],
                 'icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4'],
                ['name' => __('Frontend'), 'items' => ['Blade', 'Tailwind CSS', 'JavaScript'],
                 'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'],
                ['name' => __('Hosting'), 'items' => ['Docker', 'Nginx', 'Tailscale'],
                 'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z'],
            ] as $group)
                <div class="rounded-xl bg-white p-5 shadow-xs ring-1 ring-gray-100">
                    <div class="flex items-center gap-2 text-gray-900">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $group['icon'] }}" />
                        </svg>
                        <h3 class="font-semibold">{{ $group['name'] }}</h3>
                    </div>
                    <ul class="mt-4 flex flex-wrap gap-2">
                        @foreach ($group['items'] as $technology)
                            <li class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-medium text-indigo-700">{{ $technology }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Author --}}
    <section aria-labelledby="about-author" class="rounded-2xl bg-white p-6 sm:p-8 shadow-xs ring-1 ring-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center gap-6">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-linear-to-br from-indigo-600 to-purple-600 text-xl font-bold text-white" aria-hidden="true">
                {{ collect(explode(' ', config('demo.author')))->map(fn ($part) => mb_substr($part, 0, 1))->take(2)->implode('') }}
            </div>
            <div class="flex-1">
                <h2 id="about-author" class="text-sm font-semibold uppercase tracking-wider text-gray-500">{{ __('Author') }}</h2>
                <p class="mt-1 text-lg text-gray-700">
                    {{ __('Designed and developed by') }} <span class="font-semibold text-gray-900">{{ config('demo.author') }}</span>.
                </p>
            </div>
        </div>
        <div class="mt-6">
            @include('layout.partials.author-links')
        </div>
    </section>
@endsection
