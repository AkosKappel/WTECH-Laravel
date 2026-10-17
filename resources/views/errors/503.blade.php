@php
    // `php artisan down --retry=<seconds>` sends Retry-After; show it as an estimate
    $retryAfter = (int) ($exception->getHeaders()['Retry-After'] ?? 0);
    $minutes = (int) ceil($retryAfter / 60);
    // a plan from the admin zone or `php artisan shop:maintenance`: its message and expected end
    $plan = \App\Support\Maintenance::plan();
    $endsAt = $plan['ends_at'] ?? null;
@endphp
@extends('errors.layout', [
    'minimal' => true,
    'code' => 503,
    'heading' => __('Back in a moment'),
    'message' => $endsAt && $endsAt->isFuture()
        ? __('The shop is briefly unavailable for maintenance. We expect to be back at :time.', ['time' => $endsAt->timezone(config('demo.reset.timezone'))->format('H:i')]) . ($plan['message'] ? ' ' . $plan['message'] : '')
        : ($minutes > 0
        ? trans_choice('The shop is briefly unavailable for maintenance. Please try again in about :count minute.|The shop is briefly unavailable for maintenance. Please try again in about :count minutes.', $minutes, ['count' => $minutes])
        : __('The shop is briefly unavailable for maintenance. Please try again in a few minutes.')),
    'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
    'hideSearch' => true,
])

@section('actions')
    <a href="{{ url()->current() }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-indigo-600 text-sm font-medium text-white shadow-xs hover:bg-indigo-700 transition-colors">{{ __('Try again') }}</a>
@endsection
