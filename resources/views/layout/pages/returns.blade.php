@extends('layout.pages.page', [
    'title' => __('Returns & Claims'),
    'lead' => __('Changed your mind or something is wrong with your phone? Here is how we handle it.'),
    'fictional' => true,
])

@section('content')
    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Returns within 14 days') }}</h2>
        <div class="space-y-3 text-gray-700 leading-relaxed">
            <p>{{ __('You can return any product within 14 days of receiving it, without giving a reason. The product should be complete, undamaged and, if possible, in its original packaging.') }}</p>
            <ol class="list-decimal pl-5 space-y-1">
                <li>{{ __('Let us know through the contact page, including your order number.') }}</li>
                <li>{{ __('Send the product back or bring it to our store.') }}</li>
                <li>{{ __('We refund the full price, including delivery costs, within 14 days of receiving it.') }}</li>
            </ol>
        </div>
    </section>

    <section class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('2-year warranty') }}</h2>
        <div class="space-y-3 text-gray-700 leading-relaxed">
            <p>{{ __('Every phone comes with a 2-year warranty. If a defect appears, file a claim and we will repair or replace the device, or refund it if neither is possible.') }}</p>
            <p>{{ __('Claims are resolved within 30 days. The warranty does not cover damage caused by falls, water or unauthorised repairs.') }}</p>
        </div>
    </section>
@endsection
