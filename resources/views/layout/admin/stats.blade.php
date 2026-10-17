<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Visitors') . ' | SmartTech'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow py-12">
        @include('layout.admin.partials.nav')

        @php $maxVisitors = max(1, $days->max('visitors')); @endphp

        <div class="mx-auto w-11/12 2xl:w-4/5 space-y-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Visitors') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('Last :count days. No cookies and no IP addresses are stored; bots and admins are not counted.', ['count' => \App\Http\Controllers\Admin\StatsController::DAYS]) }}</p>
            </div>

            {{-- Headline figures --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach ([__('Visitors') => $totals['visitors'], __('Page views') => $totals['views'], __('Visitors today') => $totals['today']] as $label => $value)
                    <div class="bg-white rounded-lg shadow-xs p-5">
                        <p class="text-sm text-gray-500">{{ $label }}</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ number_format($value) }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Visitors per day: one series, so the heading names it and no legend is needed --}}
            <section class="bg-white rounded-lg shadow-xs p-5">
                <h2 class="font-semibold text-gray-900">{{ __('Visitors per day') }}</h2>
                <div class="relative mt-4">
                    <div class="flex items-end gap-0.5 h-48 border-b border-gray-200" role="img"
                         aria-label="{{ __('Visitors per day, bar chart; the table below has the numbers') }}">
                        @foreach ($days as $day)
                            <div class="stats-bar group relative flex-1 h-full flex items-end" tabindex="0">
                                <div class="w-full rounded-t bg-indigo-500 group-hover:bg-indigo-700 group-focus:bg-indigo-700" style="height: {{ $day['visitors'] / $maxVisitors * 100 }}%; min-height: {{ $day['visitors'] ? '2px' : '0' }}"></div>
                                <div class="stats-tip pointer-events-none absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block group-focus:block whitespace-nowrap rounded-md bg-gray-900 px-2 py-1 text-xs text-white shadow-lg z-10">
                                    <span class="font-medium">{{ $day['date']->format('j. n.') }}</span>:
                                    {{ trans_choice(':count visitor|:count visitors', $day['visitors'], ['count' => $day['visitors']]) }},
                                    {{ trans_choice(':count page view|:count page views', $day['views'], ['count' => $day['views']]) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between mt-1 text-xs text-gray-500">
                        <span>{{ $days->first()['date']->format('j. n.') }}</span>
                        <span>{{ $days->last()['date']->format('j. n.') }}</span>
                    </div>
                </div>
                <details class="mt-4 text-sm">
                    <summary class="cursor-pointer text-indigo-600 hover:text-indigo-800">{{ __('Show as table') }}</summary>
                    <table class="mt-2 w-full max-w-md text-left">
                        <thead class="text-gray-500"><tr><th scope="col" class="py-1">{{ __('Date') }}</th><th scope="col" class="py-1 text-right">{{ __('Visitors') }}</th><th scope="col" class="py-1 text-right">{{ __('Page views') }}</th></tr></thead>
                        <tbody>
                            @foreach ($days->reverse() as $day)
                                <tr class="border-t border-gray-100"><td class="py-1">{{ $day['date']->format('j. n. Y') }}</td><td class="py-1 text-right">{{ $day['visitors'] }}</td><td class="py-1 text-right">{{ $day['views'] }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </details>
            </section>

            {{-- Rankings --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach ([
                    __('Top pages') => $pages,
                    __('Top products') => $products,
                    __('Referrers') => $referrers,
                    __('Devices') => $devices->map(fn ($row) => (object) ['label' => __(ucfirst($row->label)), 'count' => $row->count]),
                    __('Browsers') => $browsers,
                ] as $title => $rows)
                    <section class="bg-white rounded-lg shadow-xs p-5">
                        <h2 class="font-semibold text-gray-900 mb-3">{{ $title }}</h2>
                        @php $max = max(1, $rows->max('count')); @endphp
                        <ol class="space-y-2 text-sm">
                            @forelse ($rows as $row)
                                <li>
                                    <div class="flex justify-between gap-4">
                                        <span class="truncate text-gray-700" title="{{ $row->label }}">{{ $row->label }}</span>
                                        <span class="text-gray-900 font-medium tabular-nums">{{ number_format($row->count) }}</span>
                                    </div>
                                    <div class="mt-1 h-1 rounded-full bg-gray-100"><div class="h-1 rounded-full bg-indigo-500" style="width: {{ $row->count / $max * 100 }}%"></div></div>
                                </li>
                            @empty
                                <li class="text-gray-500">{{ __('No data yet.') }}</li>
                            @endforelse
                        </ol>
                    </section>
                @endforeach
            </div>
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
