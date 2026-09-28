@extends('layout.pages.page', [
    'title' => __('About this project'),
    'lead' => __('SmartTech is a demo online shop for smartphones. It is a portfolio project, not a real business.'),
])

@section('content')
    <section class="bg-white rounded-xl shadow-xs p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('A sample shop') }}</h2>
        <div class="space-y-3 text-gray-700 leading-relaxed">
            <p>
                {{ __('Everything here works like a real e-shop: you can browse and filter the catalog, fill a cart, check out with or without an account, and manage products in the admin zone. But nothing is real:') }}
            </p>
            <ul class="list-disc pl-5 space-y-1">
                <li>{{ __('orders are never shipped and no payment is ever taken,') }}</li>
                <li>{{ __('products, prices and stock are sample data,') }}</li>
                <li>@include('layout.partials.reset-notice')</li>
            </ul>
            <p class="font-medium text-gray-900">
                {{ __('Please use made-up names, addresses and e-mails when you try it out.') }}
                <a href="{{ route('privacy') }}" class="text-indigo-600 hover:text-indigo-800 underline">{{ __('Privacy notice') }}</a>
            </p>
        </div>
    </section>

    <section class="bg-white rounded-xl shadow-xs p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Where it comes from') }}</h2>
        <div class="space-y-3 text-gray-700 leading-relaxed">
            <p>
                {{ __('SmartTech started as the semester project for the Web Technologies (WTECH) course in the 2nd year of my Bachelor\'s studies at the') }}
                <a href="https://www.fiit.stuba.sk/" target="_blank" rel="noopener" class="text-indigo-600 hover:text-indigo-800 underline">{{ __('Faculty of Informatics and Information Technologies, Slovak University of Technology in Bratislava') }}</a>
                {{ __('(winter semester 2021/2022). It was my first project with Laravel.') }}
            </p>
            <p>
                {{ __('The assignment was to build a server-side rendered e-shop with product filtering, pagination, search, a persistent shopping cart, guest checkout, customer accounts and an admin zone for managing products and images.') }}
            </p>
            <p>
                {{ __('In 2025 and 2026 I returned to it to prepare it for my portfolio: I containerised it with Docker, redesigned every page, fixed bugs and security issues, and deployed it on my own home server.') }}
            </p>
        </div>
    </section>

    <section class="bg-white rounded-xl shadow-xs p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Things to try') }}</h2>
        <ul class="list-disc pl-5 space-y-1 text-gray-700 leading-relaxed">
            <li>
                <a href="{{ route('smartphones') }}" class="text-indigo-600 hover:text-indigo-800 underline">{{ __('Browse the catalog') }}</a>
                {{ __('and combine the price, brand and colour filters with sorting and search.') }}
            </li>
            <li>{{ __('Add a phone to the cart, change the quantity and go through the three-step checkout as a guest.') }}</li>
            <li>{{ __('Tick "Create an account" at the end of the checkout, then log out and back in: your cart is kept between sessions.') }}</li>
        </ul>
    </section>

    <section class="bg-white rounded-xl shadow-xs p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Built with') }}</h2>
        <div class="flex flex-wrap gap-2">
            @foreach (['Laravel 8', 'PHP 8.1', 'PostgreSQL', 'Blade', 'Tailwind CSS', 'Alpine.js', 'Docker', 'Nginx'] as $technology)
                <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-sm font-medium">{{ $technology }}</span>
            @endforeach
        </div>
    </section>

    <section class="bg-white rounded-xl shadow-xs p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Author') }}</h2>
        <p class="text-gray-700 leading-relaxed mb-4">
            {{ __('Designed and developed by') }} <span class="font-semibold text-gray-900">{{ config('demo.author') }}</span>.
        </p>
        @include('layout.partials.author-links')
    </section>
@endsection
