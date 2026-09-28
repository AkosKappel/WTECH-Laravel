{{-- The author's real profile links, from config/demo.php. Empty links are skipped. --}}
<div class="flex flex-wrap gap-3">
    @foreach ([
        'portfolio' => __('Portfolio'),
        'github' => 'GitHub',
        'linkedin' => 'LinkedIn',
        'repository' => __('Source code'),
    ] as $key => $label)
        @if (config("demo.links.$key"))
            <a href="{{ config("demo.links.$key") }}" target="_blank" rel="noopener"
               class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-indigo-300 transition-colors">
                {{ $label }}
                <svg class="ml-2 h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                    <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                </svg>
            </a>
        @endif
    @endforeach
</div>
