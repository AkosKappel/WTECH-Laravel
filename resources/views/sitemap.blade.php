{{-- concatenated, so PHP doesn't read it as an opening tag --}}
{!! '<' . '?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach ($urls as $url)
@foreach (array_keys(config('app.locales')) as $code)
    <url>
        <loc>{{ localizedUrl($code, $url['loc']) }}</loc>
@foreach (array_keys(config('app.locales')) as $alternate)
        <xhtml:link rel="alternate" hreflang="{{ $alternate }}" href="{{ localizedUrl($alternate, $url['loc']) }}"/>
@endforeach
@if ($url['lastmod'])
        <lastmod>{{ $url['lastmod']->toDateString() }}</lastmod>
@endif
    </url>
@endforeach
@endforeach
</urlset>
