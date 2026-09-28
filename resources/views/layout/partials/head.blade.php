<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="Smartphone eshop" />
<meta name="keywords" content="Smartphone, Android, iPhone" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="author" content="Ákos Kappel" />

{{-- Favicons, versioned because browsers cache them aggressively --}}
<link rel="icon" href="{{ url('wtech/favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}" sizes="48x48" />
<link rel="icon" type="image/png" href="{{ url('wtech/favicon-32x32.png') }}?v={{ filemtime(public_path('favicon-32x32.png')) }}" sizes="32x32" />
<link rel="apple-touch-icon" href="{{ url('wtech/apple-touch-icon.png') }}?v={{ filemtime(public_path('apple-touch-icon.png')) }}" />
<meta name="theme-color" content="#4f46e5" />

{{-- Tailwind CSS 4, built from resources/css/app.css (npm run build:css) --}}
<link href="{{ url('wtech/css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}" rel="stylesheet" />
<link href="{{ url('wtech/css/nav.css') }}" rel="stylesheet" />
<link href="{{ url('wtech/css/components.css') }}?v={{ filemtime(public_path('css/components.css')) }}" rel="stylesheet" />

<title>{{ $title }}</title>
