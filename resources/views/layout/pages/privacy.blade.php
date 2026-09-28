@extends('layout.pages.page', [
    'title' => __('Privacy Notice'),
    'lead' => __('What this demo site stores about you, and why. In short: only what the shop needs to work, nothing is shared or sold, and everything may be deleted at any time.'),
])

@section('content')
    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Who runs this site') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            {{ __('SmartTech is a personal portfolio project by') }} <span class="font-semibold">{{ config('demo.author') }}</span>,
            {{ __('hosted on a private home server. It is not a business and does not sell anything.') }}
        </p>
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Please use made-up data') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            {{ __('The shop is a demo, so there is no reason to enter your real name, address, phone number or e-mail. Invented details work just as well. The checkout never asks for card or payment details.') }}
        </p>
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('What is stored') }}</h2>
        <ul class="list-disc pl-5 space-y-2 text-gray-700 leading-relaxed">
            <li>
                <span class="font-medium text-gray-900">{{ __('Accounts:') }}</span>
                {{ __('the name, e-mail, phone number and address you enter, and your password, which is stored only as a secure hash.') }}
            </li>
            <li>
                <span class="font-medium text-gray-900">{{ __('Orders:') }}</span>
                {{ __('the delivery details, the ordered products and the chosen delivery and payment method. Guest orders store the same details without a password.') }}
            </li>
            <li>
                <span class="font-medium text-gray-900">{{ __('Shopping cart:') }}</span>
                {{ __('when you log out, your cart is saved to your account so it can be restored the next time you log in.') }}
            </li>
            <li>
                <span class="font-medium text-gray-900">{{ __('Logs:') }}</span>
                {{ __('the server keeps technical logs for troubleshooting, for example page requests, errors and login events. These may include connection data such as your IP address.') }}
            </li>
        </ul>
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Cookies') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            {{ __('The site uses only the cookies it needs to work: a session cookie that keeps you logged in and remembers your cart, and a security cookie that protects forms against forgery. If you tick "Remember me" when logging in, a cookie keeps you logged in for longer. There are no analytics, advertising or tracking cookies.') }}
        </p>
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Third parties') }}</h2>
        <div class="space-y-3 text-gray-700 leading-relaxed">
            <p>{{ __('Your data is never sold or shared. Two outside services are involved in delivering the site:') }}</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>{{ __('Tailscale routes the encrypted connection to the home server. It can see connection details such as your IP address, but not the content of the pages or forms.') }}</li>
                <li>{{ __('The page styles are loaded from the unpkg.com content delivery network, so your browser also connects to it.') }}</li>
            </ul>
        </div>
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('How long data is kept') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            @include('layout.partials.reset-notice')
            {{ __('Server logs are kept separately for troubleshooting. If you entered real data by mistake, or want your data deleted sooner, get in touch and I will remove it.') }}
        </p>
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Contact') }}</h2>
        <p class="text-gray-700 leading-relaxed mb-4">
            {{ __('For any question about this notice or your data, reach me through one of these profiles:') }}
        </p>
        @include('layout.partials.author-links')
    </section>
@endsection
