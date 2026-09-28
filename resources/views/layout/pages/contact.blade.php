@extends('layout.pages.page', [
    'title' => __('Contact'),
    'lead' => __('SmartTech is a demo shop, so there is no customer support, but you are welcome to get in touch with the author.'),
])

@section('content')
    <section class="bg-white rounded-xl shadow-xs p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('Get in touch') }}</h2>
        <p class="text-gray-700 leading-relaxed mb-4">
            {{ __('Questions about the project, feedback, a bug you found, or a request to delete data you entered: reach') }}
            <span class="font-semibold text-gray-900">{{ config('demo.author') }}</span>
            {{ __('through one of these profiles.') }}
        </p>
        @include('layout.partials.author-links')
    </section>

    <section class="bg-white rounded-xl shadow-xs p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ __('About orders') }}</h2>
        <p class="text-gray-700 leading-relaxed">
            {{ __('Orders placed in this shop are never processed or shipped, so there is nothing to track, cancel or return.') }}
            <a href="{{ route('about') }}" class="text-indigo-600 hover:text-indigo-800 underline">{{ __('About this project') }}</a>
        </p>
    </section>
@endsection
