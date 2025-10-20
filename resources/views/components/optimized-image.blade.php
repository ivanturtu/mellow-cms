@props([
    'src' => '',
    'alt' => '',
    'class' => '',
    'width' => null,
    'height' => null,
    'lazy' => true,
    'placeholder' => true
])

@php
    $lazyClass = $lazy ? 'lazy' : '';
    $placeholderSrc = $placeholder ? 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="' . ($width ?? 400) . '" height="' . ($height ?? 300) . '" viewBox="0 0 ' . ($width ?? 400) . ' ' . ($height ?? 300) . '"><rect width="100%" height="100%" fill="#f0f0f0"/><text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="#999" font-family="Arial, sans-serif" font-size="14">Loading...</text></svg>') : '';
@endphp

<img 
    @if($lazy)
        data-src="{{ $src }}" 
        src="{{ $placeholderSrc }}"
        loading="lazy"
    @else
        src="{{ $src }}"
    @endif
    alt="{{ $alt }}"
    class="{{ $class }} {{ $lazyClass }}"
    @if($width) width="{{ $width }}" @endif
    @if($height) height="{{ $height }}" @endif
    @if($lazy)
        onload="this.classList.add('loaded')"
        onerror="this.src='{{ asset('mellow/images/placeholder.jpg') }}'"
    @endif
>
