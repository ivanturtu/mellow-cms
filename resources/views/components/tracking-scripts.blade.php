@props(['position' => 'head'])

@php
    $settings = \App\Models\Setting::getGroupedSettings();
@endphp

@if($position === 'head')
    <!-- Google Analytics -->
    @if($settings['seo']['google_analytics'] ?? false)
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['seo']['google_analytics'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $settings['seo']['google_analytics'] }}');
    </script>
    @endif

    <!-- Google Tag Manager -->
    @if($settings['seo']['google_tag_manager'] ?? false)
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $settings['seo']['google_tag_manager'] }}');</script>
    @endif

    <!-- Facebook Pixel -->
    @if($settings['seo']['facebook_pixel'] ?? false)
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $settings['seo']['facebook_pixel'] }}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ $settings['seo']['facebook_pixel'] }}&ev=PageView&noscript=1"
    /></noscript>
    @endif

    <!-- Google Search Console -->
    @if($settings['seo']['google_search_console'] ?? false)
    <meta name="google-site-verification" content="{{ $settings['seo']['google_search_console'] }}">
    @endif

@elseif($position === 'body')
    <!-- Google Tag Manager (noscript) -->
    @if($settings['seo']['google_tag_manager'] ?? false)
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $settings['seo']['google_tag_manager'] }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

@endif
