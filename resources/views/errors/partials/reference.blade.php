@if ($reference ?? null)
    <div class="mt-6 inline-flex items-center gap-3 rounded-lg bg-white px-4 py-2 text-sm ring-1 ring-gray-200">
        <span class="text-gray-500">{{ __('Reference') }}</span>
        <code class="font-mono font-semibold text-gray-900" id="error-reference">{{ $reference }}</code>
        <button type="button" class="text-indigo-600 hover:text-indigo-800 font-medium" data-copy="#error-reference" data-copied="{{ __('Copied') }}">{{ __('Copy') }}</button>
    </div>
    <p class="mt-2 text-sm text-gray-500">{{ __('If the problem keeps happening, mention this reference when you contact us.') }}</p>
    @include('errors.partials.copy-script')
@endif
