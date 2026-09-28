@extends('layout.pages.page', [
    'title' => __('Shipping'),
    'lead' => __('Delivery is free on all orders. Choose the option that suits you best at checkout.'),
    'fictional' => true,
])

@section('content')
    <section class="bg-white rounded-xl shadow-xs divide-y divide-gray-100">
        @foreach ([
            __('Courier Delivery') => __('Delivered to your door within 1–2 working days. The courier contacts you by phone before arriving.'),
            __('Personal Pickup') => __('Pick up your order at our store in Bratislava, usually on the same day. We send you an e-mail when it is ready.'),
            __('Post Office Delivery') => __('Collect your parcel at the post office of your choice within 2–3 working days. It is stored there for 7 days.'),
            __('Parcel Locker') => __('Delivered to a parcel locker near you within 1–2 working days and available there around the clock for 3 days.'),
        ] as $method => $description)
            <div class="p-6 flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ $method }}</h2>
                    <p class="mt-1 text-gray-700 leading-relaxed">{{ $description }}</p>
                </div>
                <span class="shrink-0 px-3 py-1 rounded-full bg-green-50 text-green-700 text-sm font-medium">{{ __('Free') }}</span>
            </div>
        @endforeach
    </section>

    <section class="bg-white rounded-xl shadow-xs p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Good to know') }}</h2>
        <ul class="list-disc pl-5 space-y-1 text-gray-700 leading-relaxed">
            <li>{{ __('Orders placed on working days before 14:00 are dispatched the same day.') }}</li>
            <li>{{ __('We currently deliver within Slovakia and the Czech Republic.') }}</li>
            <li>{{ __('Every parcel is insured for its full value.') }}</li>
        </ul>
    </section>
@endsection
