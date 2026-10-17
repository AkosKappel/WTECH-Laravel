<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Translations') . ' | SmartTech'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow py-12">
        @include('layout.admin.partials.nav')

        @php
            $localeNames = config('app.locales');
            $selector = app('translator')->getSelector();
        @endphp

        <div class="mx-auto w-11/12 2xl:w-4/5 space-y-6">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('Translations') }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ __('English is the original. Edits are saved on top of the language files; export them to commit them to the repository.') }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach ($locales as $locale)
                        <a href="{{ route('admin.translations.export', $locale) }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('Export') }} {{ $locale }}.json</a>
                    @endforeach
                </div>
            </div>

            {{-- Progress per language --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($locales as $locale)
                    <div class="bg-white rounded-lg shadow-xs p-4">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-900">{{ $localeNames[$locale]['name'] }}</span>
                            <span class="text-gray-600 tabular-nums">{{ $progress[$locale] }} / {{ $total }}</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-gray-100" role="progressbar" aria-valuemin="0" aria-valuemax="{{ $total }}" aria-valuenow="{{ $progress[$locale] }}" aria-label="{{ $localeNames[$locale]['name'] }}">
                            <div class="h-2 rounded-full bg-indigo-500" style="width: {{ $total ? $progress[$locale] / $total * 100 : 0 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Search, filters, import --}}
            <div class="flex flex-col lg:flex-row gap-3 lg:items-center lg:justify-between">
                <form method="GET" action="{{ route('admin.translations') }}" class="flex flex-col sm:flex-row gap-3 grow">
                    <label class="relative grow">
                        <span class="sr-only">{{ __('Search texts') }}</span>
                        <x-icon name="search" class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"/>
                        <input type="search" name="q" value="{{ $search }}" placeholder="{{ __('Search texts') }}" class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500"/>
                    </label>
                    <select name="filter" class="py-2 pl-3 pr-8 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500" onchange="this.form.submit()" aria-label="{{ __('Filter') }}">
                        @foreach (['all' => __('All texts'), 'missing' => __('Missing'), 'same' => __('Same as English'), 'changed' => __('Edited here'), 'warnings' => __('With warnings')] as $value => $label)
                            <option value="{{ $value }}" @selected($filter === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <noscript><button type="submit" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-sm">{{ __('Apply') }}</button></noscript>
                </form>
                <form method="POST" action="{{ route('admin.translations.import') }}" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2 text-sm">
                    @csrf
                    <select name="locale" class="py-2 pl-3 pr-8 rounded-lg border border-gray-300" aria-label="{{ __('Language') }}">
                        @foreach ($locales as $locale)<option value="{{ $locale }}">{{ $locale }}</option>@endforeach
                    </select>
                    <input type="file" name="file" accept="application/json,.json" required class="text-sm max-w-52" aria-label="{{ __('JSON file') }}"/>
                    <button type="submit" class="px-3 py-2 rounded-lg border border-gray-300 bg-white font-medium text-gray-700 hover:bg-gray-50">{{ __('Import') }}</button>
                    @error('file')<p class="w-full text-red-600">{{ $message }}</p>@enderror
                </form>
            </div>

            <p class="text-sm text-gray-500">{{ trans_choice(':count text|:count texts', $rows->total(), ['count' => $rows->total()]) }}</p>

            {{-- Rows --}}
            <div class="space-y-3">
                @forelse ($rows as $row)
                    <form method="POST" action="{{ route('admin.translations.update') }}" class="bg-white rounded-lg shadow-xs p-4 grid grid-cols-1 lg:grid-cols-[1fr_1fr_1fr_auto] gap-4 items-start">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="key" value="{{ $row['key'] }}">
                        <div class="min-w-0">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">English</p>
                            <p class="mt-1 text-sm text-gray-900 break-words">{{ $row['key'] }}</p>
                            @if ($row['locations'])
                                <details class="mt-1 text-xs text-gray-500">
                                    <summary class="cursor-pointer">{{ trans_choice('Used in :count place|Used in :count places', count($row['locations']), ['count' => count($row['locations'])]) }}</summary>
                                    <ul class="mt-1 font-mono break-all">@foreach (array_slice($row['locations'], 0, 5) as $location)<li>{{ $location }}</li>@endforeach</ul>
                                </details>
                            @endif
                        </div>
                        @foreach ($locales as $locale)
                            @php $entry = $row['values'][$locale]; @endphp
                            <div class="min-w-0">
                                <label for="t-{{ $loop->parent->index }}-{{ $locale }}" class="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-gray-500">
                                    {{ $localeNames[$locale]['name'] }}
                                    @if ($entry['override'] !== null)<span class="normal-case tracking-normal px-1.5 rounded bg-indigo-50 text-indigo-700">{{ __('edited') }}</span>@endif
                                    @if (blank($entry['value']))<span class="normal-case tracking-normal px-1.5 rounded bg-red-50 text-red-700">{{ __('missing') }}</span>@endif
                                </label>
                                <textarea id="t-{{ $loop->parent->index }}-{{ $locale }}" name="values[{{ $locale }}]" lang="{{ $locale }}" rows="2"
                                          class="mt-1 w-full px-3 py-2 text-sm rounded-lg border {{ $entry['warnings'] ? 'border-yellow-400' : 'border-gray-300' }} focus:ring-2 focus:ring-indigo-500">{{ $entry['value'] }}</textarea>
                                @foreach ($entry['warnings'] as $warning)
                                    <p class="text-xs text-yellow-800">⚠ {{ $warning }}</p>
                                @endforeach
                                @if (str_contains($row['key'], '|') && filled($entry['value']) && !$entry['warnings'])
                                    <p class="mt-1 text-xs text-gray-500">
                                        @foreach ([1, 3, 5] as $n){{ $n }}: {{ str_replace(':count', $n, $selector->choose($entry['value'], $n, $locale)) }}@if (!$loop->last) · @endif @endforeach
                                    </p>
                                @endif
                            </div>
                        @endforeach
                        <button type="submit" class="self-center px-3 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">{{ __('Save') }}</button>
                    </form>
                @empty
                    <p class="bg-white rounded-lg shadow-xs p-8 text-center text-gray-500">{{ __('No results found') }}</p>
                @endforelse
            </div>

            {{ $rows->onEachSide(1)->links('layout.partials.pagination') }}
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
