{{-- Product search with live suggestions (public/js/search-suggest.js). Works as a plain form without JavaScript. --}}
<form action="{{ route('smartphones') }}" method="GET" role="search" class="search-box relative"
      data-suggest-url="{{ route('search.suggest') }}">
    <input type="search"
           id="{{ $id }}"
           name="q"
           value="{{ request()->routeIs('smartphones') ? request('q') : '' }}"
           placeholder="{{ __('Search smartphone...') }}"
           aria-label="{{ __('Search') }}"
           role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="{{ $id }}-results"
           class="w-full sm:w-48 xl:w-64 pl-4 pr-10 py-2 rounded-full text-sm bg-white text-gray-900 placeholder:text-gray-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-300 transition"
           autocomplete="off" maxlength="100"/>
    <button type="submit" class="absolute right-0 top-0 mt-2 mr-3" aria-label="{{ __('Search') }}">
        <svg class="h-5 w-5 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </button>
    <div id="{{ $id }}-results" role="listbox" aria-label="{{ __('Search suggestions') }}"
         class="search-results hidden absolute left-0 right-0 sm:left-auto sm:w-96 mt-2 bg-white rounded-xl shadow-xl ring-1 ring-black/5 overflow-hidden z-50"
         data-empty="{{ __('No phones found') }}" data-all="{{ __('Show all :count results') }}" data-out="{{ __('Out of stock') }}"></div>
</form>
