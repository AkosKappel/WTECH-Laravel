@if ($rows)
    <dl class="mt-2 grid grid-cols-1 sm:grid-cols-4 gap-x-4 gap-y-1 text-xs">
        @foreach ($rows as $name => $value)
            <dt class="font-medium text-gray-500 break-all">{{ $name }}</dt>
            <dd class="sm:col-span-3 font-mono text-gray-800 break-all">{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $value }}</dd>
        @endforeach
    </dl>
@else
    <p class="mt-2 text-xs text-gray-500">{{ $empty ?? '' }}</p>
@endif
