{{-- Exception details on the 500 page, rendered only for admins (see App\Exceptions\Handler) --}}
@php
    $groups = function (array $frames) {
        // consecutive vendor frames collapse into one group
        $groups = [];
        foreach ($frames as $index => $frame) {
            $last = count($groups) - 1;
            if ($frame['vendor'] && $last >= 0 && $groups[$last]['vendor']) {
                $groups[$last]['frames'][$index] = $frame;
            } else {
                $groups[] = ['vendor' => $frame['vendor'], 'frames' => [$index => $frame]];
            }
        }

        return $groups;
    };
    $firstAppFrameShown = [];
@endphp

<section class="max-w-6xl mx-auto mt-14 text-left" aria-labelledby="diagnostics-title">
    <div class="rounded-xl bg-white shadow-xs ring-1 ring-gray-200 overflow-hidden">
        <div class="border-t-4 border-red-500 px-6 py-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 id="diagnostics-title" class="text-lg font-semibold text-gray-900">{{ __('Error details') }}</h2>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                        {{ __('Visible to admins only') }}
                    </span>
                    <button type="button" data-copy="#diagnostics-report" data-copied="{{ __('Copied') }}"
                            class="rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-medium text-white hover:bg-gray-700">{{ __('Copy details') }}</button>
                </div>
            </div>
            <textarea id="diagnostics-report" class="sr-only" readonly tabindex="-1" aria-hidden="true">{{ $diagnostics['report'] }}</textarea>

            @foreach ($diagnostics['exceptions'] as $i => $exception)
                <div class="{{ $i > 0 ? 'mt-6 pt-6 border-t border-gray-100' : 'mt-4' }}">
                    @if ($i > 0)
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Caused by') }}</p>
                    @endif
                    <p class="font-mono text-sm text-red-600 break-all">{{ $exception['class'] }}@if ($exception['code']) <span class="text-gray-400">({{ $exception['code'] }})</span>@endif</p>
                    <p class="mt-1 text-lg font-medium text-gray-900 break-words">{{ $exception['message'] !== '' ? $exception['message'] : __('(no message)') }}</p>
                    <p class="mt-1 font-mono text-sm text-gray-500 break-all">{{ $exception['path'] }}:{{ $exception['line'] }}</p>

                    {{-- Stack trace --}}
                    <details class="diag-block mt-4" {{ $i === 0 ? 'open' : '' }}>
                        <summary>{{ __('Stack trace') }} <span class="text-gray-400 font-normal">({{ count($exception['frames']) }})</span></summary>
                        <ol class="mt-2 space-y-1">
                            @foreach ($groups($exception['frames']) as $group)
                                @if ($group['vendor'] && count($group['frames']) > 1)
                                    <li>
                                        <details class="diag-vendor">
                                            <summary>{{ trans_choice(':count framework frame|:count framework frames', count($group['frames']), ['count' => count($group['frames'])]) }}</summary>
                                            <ol class="mt-1 space-y-1">
                                                @foreach ($group['frames'] as $index => $frame)
                                                    @include('errors.partials.frame')
                                                @endforeach
                                            </ol>
                                        </details>
                                    </li>
                                @else
                                    @foreach ($group['frames'] as $index => $frame)
                                        @include('errors.partials.frame', ['open' => !isset($firstAppFrameShown[$i]) && !$frame['vendor']])
                                        @php if (!$frame['vendor']) { $firstAppFrameShown[$i] = true; } @endphp
                                    @endforeach
                                @endif
                            @endforeach
                        </ol>
                    </details>
                </div>
            @endforeach
        </div>

        {{-- Request and environment --}}
        <div class="border-t border-gray-100 bg-gray-50 px-6 py-5 space-y-3">
            <details class="diag-block" open>
                <summary>{{ __('Request') }}</summary>
                @include('errors.partials.table', ['rows' => $diagnostics['request']['summary']])
            </details>
            <details class="diag-block">
                <summary>{{ __('Input') }} <span class="text-gray-400 font-normal">({{ count($diagnostics['request']['input']) }})</span></summary>
                @include('errors.partials.table', ['rows' => $diagnostics['request']['input'], 'empty' => __('No input.')])
            </details>
            <details class="diag-block">
                <summary>{{ __('Headers') }} <span class="text-gray-400 font-normal">({{ count($diagnostics['request']['headers']) }})</span></summary>
                @include('errors.partials.table', ['rows' => $diagnostics['request']['headers']])
            </details>
            <details class="diag-block">
                <summary>{{ __('Session keys') }} <span class="text-gray-400 font-normal">({{ count($diagnostics['request']['session']) }})</span></summary>
                <p class="mt-2 font-mono text-xs text-gray-700 break-all">{{ $diagnostics['request']['session'] ? implode(', ', $diagnostics['request']['session']) : __('No session.') }}</p>
            </details>
            <details class="diag-block">
                <summary>{{ __('Environment') }}</summary>
                @include('errors.partials.table', ['rows' => $diagnostics['environment'] + [__('Time') => $diagnostics['time'], __('Reference') => $diagnostics['reference']]])
            </details>
            <p class="text-xs text-gray-500">
                {{ __('Passwords, tokens and cookies are hidden. The full error, with this reference, is in storage/logs/laravel.log.') }}
            </p>
        </div>
    </div>
</section>
@include('errors.partials.copy-script')
