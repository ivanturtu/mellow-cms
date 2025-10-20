@props(['page' => 'home', 'data' => []])

@php
    $seoData = \App\Http\Controllers\SeoController::getSeoData($page, $data);
@endphp

<!-- Primary Meta Tags -->
<title>{{ $seoData['title'] }}</title>
<meta name="title" content="{{ $seoData['title'] }}">
<meta name="description" content="{{ $seoData['description'] }}">
<meta name="keywords" content="{{ $seoData['keywords'] }}">
<meta name="author" content="{{ $seoData['author'] }}">
<meta name="robots" content="{{ $seoData['robots'] }}">

<!-- Canonical URL -->
<link rel="canonical" href="{{ $seoData['canonical'] }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $seoData['og_type'] }}">
<meta property="og:url" content="{{ $seoData['canonical'] }}">
<meta property="og:title" content="{{ $seoData['title'] }}">
<meta property="og:description" content="{{ $seoData['description'] }}">
<meta property="og:site_name" content="{{ $seoData['og_site_name'] }}">
@if(isset($data['image']))
<meta property="og:image" content="{{ $data['image'] }}">
@elseif($seoData['og_image'])
<meta property="og:image" content="{{ $seoData['og_image'] }}">
@else
<meta property="og:image" content="{{ asset('mellow/images/og-image.jpg') }}">
@endif

<!-- Twitter -->
<meta property="twitter:card" content="{{ $seoData['twitter_card'] }}">
<meta property="twitter:url" content="{{ $seoData['canonical'] }}">
<meta property="twitter:title" content="{{ $seoData['title'] }}">
<meta property="twitter:description" content="{{ $seoData['description'] }}">
@if(isset($data['image']))
<meta property="twitter:image" content="{{ $data['image'] }}">
@elseif($seoData['og_image'])
<meta property="twitter:image" content="{{ $seoData['og_image'] }}">
@else
<meta property="twitter:image" content="{{ asset('mellow/images/og-image.jpg') }}">
@endif

@if($seoData['twitter_handle'])
<meta property="twitter:site" content="{{ $seoData['twitter_handle'] }}">
<meta property="twitter:creator" content="{{ $seoData['twitter_handle'] }}">
@endif

<!-- Additional SEO Meta Tags -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#1a365d">
<meta name="msapplication-TileColor" content="#1a365d">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

<!-- Language and Geo Tags -->
<meta name="language" content="it">
<meta name="geo.region" content="IT">
<meta name="geo.placename" content="Italia">

<!-- Structured Data -->
@if($page === 'home')
<script type="application/ld+json">
{!! json_encode(\App\Http\Controllers\SeoController::getHotelStructuredData(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endif

<!-- Preconnect to external domains for performance -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://cdn.jsdelivr.net">

<!-- DNS Prefetch for performance -->
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
