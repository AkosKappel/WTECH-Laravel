{{-- Success messages (session "success_message") as a toast in the corner. It hides itself after 6 s;
     without JavaScript it simply stays. Screen readers announce it through role="status". --}}
@if (session()->has('success_message'))
    <div class="toast fixed bottom-4 right-4 left-4 sm:left-auto sm:max-w-sm z-[60] flex items-start gap-3 rounded-lg bg-white p-4 shadow-xl ring-1 ring-black/5"
         role="status" data-toast>
        <svg class="h-6 w-6 shrink-0 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="grow text-sm font-medium text-gray-900">{{ session('success_message') }}</p>
        <button type="button" class="shrink-0 rounded-md text-gray-400 hover:text-gray-600" aria-label="{{ __('Close') }}" data-toast-close>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
            </svg>
        </button>
    </div>
    <script>
        (function () {
            const toast = document.querySelector('[data-toast]');
            const hide = () => { toast.classList.add('is-hidden'); setTimeout(() => toast.remove(), 300); };
            toast.querySelector('[data-toast-close]').addEventListener('click', hide);
            setTimeout(hide, 6000);
        })();
    </script>
@endif
