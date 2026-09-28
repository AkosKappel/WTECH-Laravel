@extends('layout.pages.page', [
    'title' => __('Payment Methods'),
    'lead' => __('Pay the way you prefer. There are no extra fees for any payment method.'),
    'fictional' => true,
])

@section('content')
    <section class="bg-white rounded-xl shadow-sm divide-y divide-gray-100">
        @foreach ([
            __('Cash on Delivery') => __('Pay in cash or by card when the courier hands you the parcel, or when you collect it.'),
            __('Bank Transfer') => __('You receive our bank details and a payment reference by e-mail. We dispatch the order once the payment arrives.'),
            __('Credit Card') => __('Pay securely with Visa or Mastercard. The amount is charged when the order is dispatched.'),
            __('Apple Pay') => __('Pay with a single touch on your iPhone, iPad or Mac.'),
            __('Google Pay') => __('Pay quickly with the card saved in your Google account.'),
        ] as $method => $description)
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900">{{ $method }}</h2>
                <p class="mt-1 text-gray-700 leading-relaxed">{{ $description }}</p>
            </div>
        @endforeach
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('In this demo') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            {{ __('Choosing a payment method only records your choice with the order. No payment is ever requested or processed, and the checkout never asks for card details.') }}
        </p>
    </section>
@endsection
