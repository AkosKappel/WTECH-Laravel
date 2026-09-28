@extends('layout.pages.page', [
    'title' => __('Terms and Conditions'),
    'lead' => __('The rules for using this website.'),
])

@section('content')
    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('1. This is a demo') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            {{ __('SmartTech is a portfolio project that demonstrates how an online shop works. It is not a business and does not sell anything.') }}
            <a href="{{ route('about') }}" class="text-indigo-600 hover:text-indigo-800 underline">{{ __('About this project') }}</a>
        </p>
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('2. Orders') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            {{ __('Placing an order does not create a purchase contract. Orders are not processed, shipped or charged, and no payment is ever taken.') }}
        </p>
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('3. Products and content') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            {{ __('Products, prices, stock levels and the shipping, payment and returns pages are sample content. Product names, brands and logos belong to their respective owners and are used only for illustration.') }}
        </p>
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('4. Your data and accounts') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            @include('layout.partials.reset-notice')
            {{ __('Please don\'t enter real personal data. See the') }}
            <a href="{{ route('privacy') }}" class="text-indigo-600 hover:text-indigo-800 underline">{{ __('privacy notice') }}</a>
            {{ __('for what is stored.') }}
        </p>
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('5. Fair use') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            {{ __('Feel free to explore every feature. Please don\'t try to overload or attack the site, and don\'t upload anything offensive or illegal. The site is provided as is, without any guarantee of availability.') }}
        </p>
    </section>
@endsection
