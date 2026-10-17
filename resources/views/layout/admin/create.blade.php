<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Add product') . ' | SmartTech'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow py-12">
        @include('layout.admin.partials.nav')

        <div class="mx-auto w-11/12 2xl:w-4/5">
            <a href="{{ route('admin') }}" class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 hover:text-indigo-800"><x-icon name="arrow-left" class="w-4 h-4"/>{{ __('Products') }}</a>
            <h1 class="mt-2 mb-6 text-3xl font-bold text-gray-900">{{ __('Add product') }}</h1>

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700" role="alert">
                    {{ __('Please correct the highlighted fields.') }}
                </div>
            @endif

            <form action="{{ route('smartphones.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('layout.admin.partials.form', ['smartphone' => $smartphone ?? null])
            </form>
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
