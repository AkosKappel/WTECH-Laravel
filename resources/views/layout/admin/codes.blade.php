<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Discount codes') . ' | SmartTech'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow py-12">
        @include('layout.admin.partials.nav')

        @php
            $field = 'w-full px-3 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500';
            $value = fn ($name) => old($name, $code?->$name);
        @endphp

        <div class="mx-auto w-11/12 2xl:w-4/5 grid grid-cols-1 xl:grid-cols-3 gap-6 items-start">
            {{-- List --}}
            <section class="xl:col-span-2 space-y-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Discount codes') }}</h1>
                <div class="bg-white rounded-lg shadow-xs overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th scope="col" class="px-4 py-3 font-medium">{{ __('Code') }}</th>
                                <th scope="col" class="px-4 py-3 font-medium">{{ __('Discount') }}</th>
                                <th scope="col" class="px-4 py-3 font-medium">{{ __('Conditions') }}</th>
                                <th scope="col" class="px-4 py-3 font-medium text-right">{{ __('Used') }}</th>
                                <th scope="col" class="px-4 py-3"><span class="sr-only">{{ __('Actions') }}</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($codes as $row)
                                <tr class="{{ $code?->is($row) ? 'bg-indigo-50' : 'hover:bg-gray-50' }}">
                                    <td class="px-4 py-3">
                                        <span class="font-semibold text-gray-900">{{ $row->code }}</span>
                                        @if (!$row->active || ($row->expires_at && $row->expires_at->isPast()))
                                            <span class="ml-2 px-2 py-0.5 rounded-full bg-gray-100 text-xs text-gray-600">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">{{ $row->label }}</td>
                                    <td class="px-4 py-3 text-gray-500">
                                        @php
                                            $conditions = array_filter([
                                                $row->min_order > 0 ? __('from :amount', ['amount' => formattedPrice($row->min_order)]) : null,
                                                $row->expires_at ? __('until :date', ['date' => $row->expires_at->timezone(config('demo.reset.timezone'))->format('j. n. Y')]) : null,
                                                $row->per_customer_limit ? __(':count× per customer', ['count' => $row->per_customer_limit]) : null,
                                            ]);
                                        @endphp
                                        {{ $conditions ? implode(' · ', $conditions) : '–' }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-gray-700 whitespace-nowrap">{{ $row->used_count }}{{ $row->usage_limit ? ' / ' . $row->usage_limit : '' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-1">
                                            <a href="{{ route('admin.codes.edit', $row) }}" class="p-2 rounded-md text-gray-500 hover:bg-indigo-50 hover:text-indigo-700" aria-label="{{ __('Edit :name', ['name' => $row->code]) }}"><x-icon name="pencil"/></a>
                                            <form method="POST" action="{{ route('admin.codes.destroy', $row) }}" data-confirm="{{ __('Delete :name? This cannot be undone.', ['name' => $row->code]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-md text-gray-500 hover:bg-red-50 hover:text-red-700" aria-label="{{ __('Delete :name', ['name' => $row->code]) }}"><x-icon name="trash"/></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-10 text-center text-gray-500">{{ __('No codes yet.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Create / edit --}}
            <form method="POST" action="{{ $code ? route('admin.codes.update', $code) : route('admin.codes.store') }}" class="bg-white rounded-lg shadow-xs p-6 space-y-4">
                @csrf
                @if ($code) @method('PUT') @endif
                <h2 class="text-lg font-semibold text-gray-900">{{ $code ? __('Edit code') : __('New code') }}</h2>

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Code') }}</label>
                    <input id="code" name="code" value="{{ $value('code') }}" required maxlength="40" class="{{ $field }} uppercase @error('code') border-red-500 @else border-gray-300 @enderror"/>
                    @error('code')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Type') }}</label>
                        <select id="type" name="type" class="{{ $field }} border-gray-300">
                            <option value="percent" @selected($value('type') === 'percent')>{{ __('Percent') }}</option>
                            <option value="fixed" @selected($value('type') === 'fixed')>{{ __('Fixed amount (€)') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="value" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Value') }}</label>
                        <input type="number" id="value" name="value" value="{{ $value('value') }}" step=".01" min="0" required class="{{ $field }} @error('value') border-red-500 @else border-gray-300 @enderror"/>
                        @error('value')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="min_order" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Minimum order (€)') }}</label>
                        <input type="number" id="min_order" name="min_order" value="{{ $value('min_order') }}" step=".01" min="0" class="{{ $field }} border-gray-300"/>
                    </div>
                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Expires') }}</label>
                        <input type="datetime-local" id="expires_at" name="expires_at" value="{{ old('expires_at', $code?->expires_at?->timezone(config('demo.reset.timezone'))->format('Y-m-d\TH:i')) }}" class="{{ $field }} border-gray-300"/>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Uses in total') }}</label>
                        <input type="number" id="usage_limit" name="usage_limit" value="{{ $value('usage_limit') }}" min="1" placeholder="∞" class="{{ $field }} border-gray-300"/>
                    </div>
                    <div>
                        <label for="per_customer_limit" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Uses per customer') }}</label>
                        <input type="number" id="per_customer_limit" name="per_customer_limit" value="{{ $value('per_customer_limit') }}" min="1" placeholder="∞" class="{{ $field }} border-gray-300"/>
                    </div>
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="active" value="1" class="h-4 w-4 rounded accent-indigo-600" @checked(old('active', $code?->active ?? true))>
                    {{ __('Active') }}
                </label>
                <div class="flex justify-end gap-3">
                    @if ($code)
                        <a href="{{ route('admin.codes') }}" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('Cancel') }}</a>
                    @endif
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700"><x-icon name="check"/>{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </main>

    @include('layout.partials.footer')
    <script>
        document.querySelectorAll('form[data-confirm]').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!window.confirm(form.dataset.confirm)) event.preventDefault();
            });
        });
    </script>
</body>
</html>
