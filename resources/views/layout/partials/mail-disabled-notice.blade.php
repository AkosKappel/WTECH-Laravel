{{-- The demo only writes e-mails to the log, so links that would arrive by e-mail never do. --}}
@if (in_array(config('mail.default'), ['log', 'array']))
    <p class="rounded-lg bg-yellow-50 border border-yellow-200 px-4 py-3 text-center text-sm text-yellow-800" role="note">
        {{ __('E-mails are turned off in this demo, so no e-mail will arrive.') }}
    </p>
@endif
