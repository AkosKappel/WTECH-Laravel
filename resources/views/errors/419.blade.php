@extends('errors.layout', [
    'code' => 419,
    'heading' => __('Page expired'),
    'message' => __('The page was open for too long, so the form expired for your security. Go back, reload the page and try again.'),
    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
    'hideSearch' => true,
])

@section('actions')
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-indigo-600 text-sm font-medium text-white shadow-xs hover:bg-indigo-700 transition-colors">{{ __('Go back and try again') }}</a>
    <a href="{{ route('home') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-white text-sm font-medium text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50 transition-colors">{{ __('Go to homepage') }}</a>
@endsection
