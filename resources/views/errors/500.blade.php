@extends('errors.layout', [
    'minimal' => true,
    'code' => 500,
    'heading' => __('Something went wrong'),
    'message' => __('An unexpected error happened on our side. It has been logged, so we can look into it. Please try again in a moment.'),
    'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
])

@section('details')
    @include('errors.partials.reference')
@endsection

@section('below')
    @if ($diagnostics ?? null)
        @include('errors.partials.diagnostics', ['diagnostics' => $diagnostics])
    @endif
@endsection
