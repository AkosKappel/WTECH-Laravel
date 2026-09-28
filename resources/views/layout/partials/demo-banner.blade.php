{{-- Demo Notice: can be closed; the choice is kept for a year in the demo_notice_dismissed cookie --}}
@unless (request()->cookie('demo_notice_dismissed'))
    <div id="demo-notice" class="bg-yellow-100 border-b border-yellow-200 text-yellow-900 transition-all duration-300 overflow-hidden" role="note">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex items-center gap-3">
            <p class="grow text-center text-xs sm:text-sm">
                <span class="font-semibold">{{ __('Demo shop') }}</span>
                <span class="mx-1" aria-hidden="true">·</span>
                {{ __('A portfolio project – no real orders, payments or deliveries. Please don\'t enter real personal data.') }}
                <a href="{{ route('about') }}" class="font-semibold underline hover:text-yellow-700 whitespace-nowrap">
                    {{ __('Learn more') }}
                </a>
            </p>
            <form method="POST" action="{{ route('demo-notice.dismiss') }}" id="demo-notice-form" class="shrink-0">
                @csrf
                <button type="submit" class="p-1 rounded-md text-yellow-800 hover:bg-yellow-200 hover:text-yellow-900 focus:outline-hidden focus:ring-2 focus:ring-yellow-500 transition-colors" aria-label="{{ __('Close demo notice') }}" title="{{ __('Close') }}">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('demo-notice-form').addEventListener('submit', function (event) {
            event.preventDefault();
            document.cookie = 'demo_notice_dismissed=1; max-age=31536000; path=/; SameSite=Lax' + (location.protocol === 'https:' ? '; Secure' : '');
            var notice = document.getElementById('demo-notice');
            notice.style.maxHeight = notice.offsetHeight + 'px';
            requestAnimationFrame(function () {
                notice.style.maxHeight = '0';
                notice.style.opacity = '0';
                notice.style.borderBottomWidth = '0';
            });
            setTimeout(function () { notice.remove(); }, 300);
        });
    </script>
@endunless
