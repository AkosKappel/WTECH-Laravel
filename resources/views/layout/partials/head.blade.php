<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
@php
    $description ??= __('A demo smartphone e-shop built with Laravel, PostgreSQL and Tailwind CSS.');
    $image ??= asset('images/og-default.png');
@endphp
<meta name="description" content="{{ $description }}" />
<meta name="keywords" content="Smartphone, Android, iPhone" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="author" content="Ákos Kappel" />

{{-- Favicons, versioned because browsers cache them aggressively --}}
<link rel="icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}" sizes="48x48" />
<link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}?v={{ filemtime(public_path('favicon-32x32.png')) }}" sizes="32x32" />
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v={{ filemtime(public_path('apple-touch-icon.png')) }}" />
<meta name="theme-color" content="#4f46e5" />

{{-- Tailwind CSS 4, built from resources/css/app.css (npm run build:css) --}}
<link href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}" rel="stylesheet" />
<link href="{{ asset('css/nav.css') }}" rel="stylesheet" />
<link href="{{ asset('css/components.css') }}?v={{ filemtime(public_path('css/components.css')) }}" rel="stylesheet" />

<title>{{ $title }}</title>

{{-- Link previews on LinkedIn, Slack, X etc. --}}
<meta property="og:type" content="website" />
<meta property="og:site_name" content="SmartTech" />
<meta property="og:title" content="{{ $title }}" />
<meta property="og:description" content="{{ $description }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ $image }}" />
<meta name="twitter:card" content="summary_large_image" />
