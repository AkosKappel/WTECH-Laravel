<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Compare phones') . ' | SmartTech', 'robots' => 'noindex'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Compare phones') }}</h1>
            @if ($smartphones->isNotEmpty())
                <form method="POST" action="{{ route('compare.clear') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-600">{{ __('Clear comparison') }}</button>
                </form>
            @endif
        </div>

        @if ($smartphones->isEmpty())
            <div class="bg-white shadow-xs rounded-lg p-10 text-center">
                <x-icon name="scale" class="mx-auto w-10 h-10 text-gray-300"/>
                <p class="mt-3 text-gray-700">{{ __('Nothing to compare yet. Use "Compare" on up to four phones.') }}</p>
                <a href="{{ route('smartphones') }}" class="mt-4 inline-flex px-5 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">{{ __('Browse phones') }}</a>
            </div>
        @else
            @php
                $rows = [
                    __('Price') => fn ($p) => formattedPrice($p->current_price),
                    __('Brand') => fn ($p) => $p->brand?->name,
                    __('Rating') => fn ($p) => $p->reviews_count ? localizedNumber(round($p->reviews_avg_rating, 1)) . ' / 5 (' . $p->reviews_count . ')' : null,
                    __('RAM') => fn ($p) => $p->ram ? $p->ram . ' GB' : null,
                    __('Operating system') => fn ($p) => trim($p->operating_system . ' ' . $p->os_version),
                    __('Display size') => fn ($p) => $p->display_size ? localizedNumber($p->display_size) . '″' : null,
                    __('Display resolution') => fn ($p) => $p->resolution,
                    __('Dimensions') => fn ($p) => $p->height ? localizedNumber($p->height) . ' × ' . localizedNumber($p->width) . ' × ' . localizedNumber($p->thickness) . ' mm' : null,
                    __('Color') => fn ($p) => $p->color ? \Illuminate\Support\Str::ucfirst(__($p->color->name_en)) : null,
                    __('Availability') => fn ($p) => $p->quantity > 0 ? __('In stock') : __('Out of stock'),
                ];
            @endphp
            <div class="bg-white rounded-lg shadow-xs overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <td class="p-4"></td>
                            @foreach ($smartphones as $smartphone)
                                <th scope="col" class="p-4 align-top text-left min-w-48">
                                    @if ($image = $smartphone->images->first())
                                        <img src="{{ $image->thumb_url }}" alt="" class="h-32 w-full object-contain mb-3"/>
                                    @endif
                                    <a href="{{ route('details', $smartphone) }}" class="font-semibold text-gray-900 hover:text-indigo-600">{{ $smartphone->name }}</a>
                                    <form method="POST" action="{{ route('compare.toggle', $smartphone) }}" class="mt-1">
                                        @csrf
                                        <button type="submit" class="text-xs font-normal text-gray-500 hover:text-red-600">{{ __('Remove') }}</button>
                                    </form>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($rows as $label => $value)
                            <tr class="odd:bg-gray-50">
                                <th scope="row" class="p-4 text-left font-medium text-gray-500 whitespace-nowrap">{{ $label }}</th>
                                @foreach ($smartphones as $smartphone)
                                    <td class="p-4 text-gray-900">{{ $value($smartphone) ?: '–' }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>

    @include('layout.partials.footer')
</body>
</html>
