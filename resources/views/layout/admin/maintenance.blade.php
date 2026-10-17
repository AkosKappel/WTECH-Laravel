<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.partials.head', ['title' => __('Maintenance') . ' | SmartTech'])
</head>

<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    @include('layout.partials.header')

    <main class="grow py-12">
        @include('layout.admin.partials.nav')

        @php
            $field = 'w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500';
            $local = fn ($date) => $date?->timezone(config('demo.reset.timezone'))->format('Y-m-d\TH:i');
        @endphp

        <div class="mx-auto w-11/12 2xl:w-4/5 max-w-3xl space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Maintenance') }}</h1>
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $down ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700' }}">
                    {{ $down ? __('Shop is down') : __('Shop is open') }}
                </span>
            </div>

            @if ($down)
                <form method="POST" action="{{ route('admin.maintenance.destroy') }}" class="rounded-lg bg-red-50 border border-red-200 p-5 flex flex-wrap items-center justify-between gap-4">
                    @csrf
                    @method('DELETE')
                    <p class="text-sm text-red-800">{{ __('Visitors see the maintenance page. You can still browse the shop.') }}</p>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-sm font-medium text-white hover:bg-red-700">{{ __('End maintenance') }}</button>
                </form>
            @endif

            <form method="POST" action="{{ route('admin.maintenance.update') }}" class="bg-white rounded-lg shadow-xs p-6 space-y-4">
                @csrf
                @method('PUT')
                <p class="text-sm text-gray-600">{{ __('A planned window is announced in a banner up to :hours hours before it starts. The message and the end time also appear on the maintenance page.', ['hours' => \App\Support\Maintenance::NOTICE_HOURS]) }}</p>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Message for visitors') }}</label>
                    <input id="message" name="message" value="{{ old('message', $plan['message'] ?? '') }}" maxlength="300" class="{{ $field }}"/>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Starts') }}</label>
                        <input type="datetime-local" id="starts_at" name="starts_at" value="{{ old('starts_at', $local($plan['starts_at'] ?? null)) }}" class="{{ $field }}"/>
                    </div>
                    <div>
                        <label for="ends_at" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Expected end') }}</label>
                        <input type="datetime-local" id="ends_at" name="ends_at" value="{{ old('ends_at', $local($plan['ends_at'] ?? null)) }}" class="{{ $field }}"/>
                        @error('ends_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex flex-wrap justify-end gap-3">
                    <button type="submit" name="action" value="plan" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('Save plan') }}</button>
                    @unless ($down)
                        <button type="submit" name="action" value="start" class="px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">{{ __('Start maintenance now') }}</button>
                    @endunless
                </div>
            </form>
        </div>
    </main>

    @include('layout.partials.footer')
</body>
</html>
