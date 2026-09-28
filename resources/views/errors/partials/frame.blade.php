<li class="rounded-md {{ $frame['vendor'] ? '' : 'bg-indigo-50 ring-1 ring-indigo-100' }}">
    @if ($frame['code'])
        <details class="diag-frame" {{ ($open ?? false) ? 'open' : '' }}>
            <summary class="px-3 py-1.5">
                <span class="font-mono text-xs text-gray-400 w-6 inline-block">#{{ $index }}</span>
                <span class="font-mono text-xs text-gray-900 break-all">{{ $frame['call'] ?? __('thrown here') }}</span>
                <span class="block sm:inline font-mono text-xs text-indigo-700 break-all sm:ml-2">{{ $frame['path'] }}:{{ $frame['line'] }}</span>
            </summary>
            <pre class="diag-code"><code>@foreach ($frame['code'] as $number => $line)<span class="{{ $number === $frame['line'] ? 'is-current' : '' }}"><span class="diag-line">{{ $number }}</span>{{ $line }}
</span>@endforeach</code></pre>
        </details>
    @else
        <div class="px-3 py-1.5">
            <span class="font-mono text-xs text-gray-400 w-6 inline-block">#{{ $index }}</span>
            <span class="font-mono text-xs {{ $frame['vendor'] ? 'text-gray-600' : 'text-gray-900' }} break-all">{{ $frame['call'] ?? __('thrown here') }}</span>
            <span class="block sm:inline font-mono text-xs text-gray-400 break-all sm:ml-2">{{ $frame['path'] }}{{ $frame['line'] ? ':' . $frame['line'] : '' }}</span>
        </div>
    @endif
</li>
