@extends('errors.layout', [
    'code' => 403,
    'heading' => __('Access denied'),
    'message' => auth()->check()
        ? __('Your account doesn\'t have permission to open this page.')
        : __('This page is only available after signing in, to accounts with permission to open it.'),
    'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
])

@section('actions')
    @guest
        <a href="{{ route('login') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-indigo-600 text-sm font-medium text-white shadow-xs hover:bg-indigo-700 transition-colors">{{ __('Sign In') }}</a>
    @endguest
    <a href="{{ route('home') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg {{ auth()->check() ? 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-xs' : 'bg-white text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50' }} text-sm font-medium transition-colors">{{ __('Go to homepage') }}</a>
@endsection
