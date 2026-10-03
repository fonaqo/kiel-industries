@props([
    'src',
    'alt' => '',
    'loading' => 'lazy',
    'decoding' => 'async',
    'fetchpriority' => null,
    'class' => '',
])

@php
    $path = is_string($src) ? $src : '';
    $relative = \App\Support\KielImage::relativePublicPath($path);
    $webp = $relative ? preg_replace('/\.(jpe?g|png)$/i', '.webp', $relative) : null;
    $hasWebp = $webp && is_file(public_path($webp));
    $fallback = $relative ? asset($relative) : \App\Support\KielImage::url($path);
@endphp

@if($relative && $hasWebp)
<picture {{ $attributes->class($class) }}>
<source srcset="{{ asset($webp) }}" type="image/webp"/>
<img src="{{ $fallback }}" alt="{{ $alt }}" loading="{{ $loading }}" decoding="{{ $decoding }}" @if($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif class="{{ $class }}"/>
</picture>
@else
<img src="{{ $fallback }}" alt="{{ $alt }}" loading="{{ $loading }}" decoding="{{ $decoding }}" @if($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif {{ $attributes->class($class) }}/>
@endif
