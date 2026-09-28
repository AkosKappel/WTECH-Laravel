@php
    $suggestions = \App\Support\NotFoundSuggestions::for(request());
    $product = $suggestions['product'] ?? false;
@endphp
@extends('errors.layout', [
    'code' => 404,
    'heading' => $product ? __('This phone isn\'t available') : __('Page not found'),
    'message' => $product
        ? __('The phone you are looking for doesn\'t exist or was removed from the catalog.')
        : __('The page you are looking for doesn\'t exist or was moved. Check the address, or try one of the links below.'),
    'icon' => 'M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    'searchValue' => $suggestions['matched'] ?? false ? $suggestions['query'] : '',
])

@section('below')
    @if ($suggestions && $suggestions['phones']->isNotEmpty())
        <section class="max-w-7xl mx-auto mt-14" aria-labelledby="suggestions-title">
            <h2 id="suggestions-title" class="text-xl font-semibold text-gray-900 mb-6 text-center">
                {{ $suggestions['matched'] ? __('Were you looking for one of these?') : __('Newest phones') }}
            </h2>
            <div class="flex flex-wrap justify-center gap-6">
                @foreach ($suggestions['phones'] as $smartphone)
                    <div class="w-full sm:w-72">
                        @include('layout.partials.product-card', ['smartphone' => $smartphone])
                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endsection
