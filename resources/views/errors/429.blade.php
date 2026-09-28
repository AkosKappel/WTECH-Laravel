@php $retryAfter = (int) (optional($exception ?? null)->getHeaders()['Retry-After'] ?? 0); @endphp
@extends('errors.layout', [
    'code' => 429,
    'heading' => __('Too many requests'),
    'message' => $retryAfter > 0
        ? trans_choice('You sent a lot of requests in a short time. Please try again in :count second.|You sent a lot of requests in a short time. Please try again in :count seconds.', $retryAfter, ['count' => $retryAfter])
        : __('You sent a lot of requests in a short time. Please wait a moment and try again.'),
    'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
    'hideSearch' => true,
])
