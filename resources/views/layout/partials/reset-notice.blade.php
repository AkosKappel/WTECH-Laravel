{{-- One sentence about when visitor data is deleted, matching config/demo.php --}}
@if (config('demo.reset.enabled'))
    {{ __('The demo is reset every night at :time (:timezone time), which deletes all accounts, orders, carts and uploaded images.', [
        'time' => config('demo.reset.time'),
        'timezone' => str_replace('_', ' ', \Illuminate\Support\Str::afterLast(config('demo.reset.timezone'), '/')),
    ]) }}
@else
    {{ __('The demo can be reset at any time, which deletes all accounts, orders, carts and uploaded images.') }}
@endif
