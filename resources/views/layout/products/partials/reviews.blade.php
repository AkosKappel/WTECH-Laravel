{{-- Reviews on the product page: summary, the signed-in customer's form, and the list --}}
@php
    $reviews = $smartphone->reviews->sortByDesc('created_at');
    $own = auth()->check() ? $reviews->firstWhere('user_id', auth()->id()) : null;
@endphp
<section id="reviews" class="mt-12 scroll-mt-24 bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-900">{{ __('Reviews') }}</h2>
        @if ($reviews->isNotEmpty())
            <p class="flex items-center gap-2 text-sm text-gray-600">
                @include('layout.partials.stars', ['rating' => $reviews->avg('rating'), 'size' => 'w-5 h-5'])
                <span class="font-semibold text-gray-900">{{ localizedNumber(round($reviews->avg('rating'), 1)) }}</span>
                · {{ trans_choice(':count review|:count reviews', $reviews->count(), ['count' => $reviews->count()]) }}
            </p>
        @endif
    </div>

    <div class="p-6 grid lg:grid-cols-3 gap-8">
        {{-- Form --}}
        <div>
            @auth
                <form method="POST" action="{{ route('reviews.store', $smartphone) }}" class="space-y-3">
                    @csrf
                    <h3 class="font-medium text-gray-900">{{ $own ? __('Edit your review') : __('Write a review') }}</h3>
                    <fieldset>
                        <legend class="block text-sm text-gray-700 mb-1">{{ __('Rating') }}</legend>
                        <div class="rating-input flex flex-row-reverse justify-end gap-1">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" class="sr-only" @checked((int) old('rating', $own?->rating) === $i) required>
                                <label for="rating-{{ $i }}" class="cursor-pointer text-gray-300" title="{{ trans_choice(':count star|:count stars', $i, ['count' => $i]) }}">
                                    <svg class="w-7 h-7" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="sr-only">{{ trans_choice(':count star|:count stars', $i, ['count' => $i]) }}</span>
                                </label>
                            @endfor
                        </div>
                        @error('rating')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </fieldset>
                    <div>
                        <label for="review-body" class="block text-sm text-gray-700 mb-1">{{ __('Your review (optional)') }}</label>
                        <textarea id="review-body" name="body" rows="4" maxlength="2000"
                                  class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('body', $own?->body) }}</textarea>
                        @error('body')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">
                        <x-icon name="star"/>{{ $own ? __('Update review') : __('Post review') }}
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-800">{{ __('Sign in') }}</a>
                    {{ __('to review this phone.') }}
                </p>
            @endauth
        </div>

        {{-- List --}}
        <div class="lg:col-span-2">
            @forelse ($reviews as $review)
                <article class="py-4 first:pt-0 border-b border-gray-100 last:border-0">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            @include('layout.partials.stars', ['rating' => $review->rating])
                            <span class="font-medium text-gray-900">{{ $review->user->first_name ?: __('Customer') }}</span>
                            @if ($review->isVerifiedPurchase())
                                <span class="px-2 py-0.5 rounded-full bg-green-50 text-xs font-medium text-green-700">{{ __('Verified purchase') }}</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <time datetime="{{ $review->created_at->toDateString() }}">{{ $review->created_at->timezone(config('demo.reset.timezone'))->format('j. n. Y') }}</time>
                            @if (auth()->id() === $review->user_id || auth()->user()?->isAdmin())
                                <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 rounded-md text-gray-400 hover:text-red-600" aria-label="{{ __('Delete review') }}"><x-icon name="trash" class="w-4 h-4"/></button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if ($review->body)
                        <p class="mt-2 text-gray-700 whitespace-pre-line">{{ $review->body }}</p>
                    @endif
                </article>
            @empty
                <p class="text-gray-500">{{ __('No reviews yet. Be the first!') }}</p>
            @endforelse
        </div>
    </div>
</section>
