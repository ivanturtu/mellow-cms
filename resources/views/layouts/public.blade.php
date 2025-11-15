<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="format-detection" content="telephone=no">
  
  <!-- SEO Meta Tags -->
  <x-seo-meta :page="$page ?? 'home'" :data="$seoData ?? []" />
  
  <!-- Tracking Scripts -->
  <x-tracking-scripts position="head" />
  
  <!-- PWA Manifest -->
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#1a365d">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Hotel Mellow">
  <link rel="apple-touch-icon" href="{{ asset('mellow/images/icon-192x192.png') }}">

  <!--Bootstrap ================================================== -->
  <link rel="stylesheet" type="text/css" href="{{ asset('mellow/css/bootstrap.min.css') }}">

  <!--vendor css ================================================== -->
  <link rel="stylesheet" type="text/css" href="{{ asset('mellow/css/vendor.css') }}">

  <!--Link Swiper's CSS ================================================== -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

  <!--Link AOS's CSS ================================================== -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Style Sheet ================================================== -->
  <link rel="stylesheet" type="text/css" href="{{ asset('mellow/style.css') }}">
  
  <!-- SEO Optimizations CSS -->
  <link rel="stylesheet" type="text/css" href="{{ asset('css/seo.css') }}">

  <!-- Google Fonts ================================================== -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Upright:wght@300;400;500;600;700&family=Sora:wght@100..800&display=swap"
    rel="stylesheet">
  
</head>

<body>

  <!-- Tracking Scripts (Body) -->
  <x-tracking-scripts position="body" />

  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="wifi" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M6.55 12.192c3.017-3.256 7.883-3.256 10.9 0a.75.75 0 1 0 1.1-1.02c-3.61-3.896-9.49-3.896-13.1 0a.75.75 0 1 0 1.1 1.02" />
      <path fill="currentColor"
        d="M8.55 14.35c1.912-2.064 4.987-2.064 6.9 0a.75.75 0 1 0 1.1-1.019c-2.506-2.705-6.594-2.705-9.1 0a.75.75 0 1 0 1.1 1.02" />
      <path fill="currentColor"
        d="M10.55 16.51c.808-.872 2.092-.872 2.9 0a.75.75 0 1 0 1.1-1.02c-1.401-1.513-3.699-1.513-5.1 0a.75.75 0 1 0 1.1 1.02" />
      <path fill="currentColor" fill-rule="evenodd"
        d="M12 1.25c-.708 0-1.351.203-2.05.542c-.674.328-1.454.812-2.427 1.416L5.456 4.491c-.92.572-1.659 1.03-2.227 1.465c-.589.45-1.041.91-1.368 1.507c-.326.595-.472 1.229-.543 1.978c-.068.725-.068 1.613-.068 2.726v1.613c0 1.904 0 3.407.153 4.582c.156 1.205.486 2.178 1.23 2.947c.747.773 1.697 1.119 2.875 1.282c1.14.159 2.598.159 4.434.159h4.116c1.836 0 3.294 0 4.434-.159c1.177-.163 2.128-.509 2.876-1.282c.743-.769 1.073-1.742 1.23-2.947c.152-1.175.152-2.678.152-4.582v-1.613c0-1.113 0-2-.068-2.726c-.07-.75-.217-1.383-.543-1.978c-.327-.597-.78-1.056-1.368-1.507c-.568-.436-1.306-.893-2.227-1.465l-2.067-1.283c-.973-.604-1.753-1.088-2.428-1.416c-.697-.34-1.34-.542-2.049-.542M8.28 4.504c1.015-.63 1.73-1.072 2.327-1.363c.581-.283.993-.391 1.393-.391s.812.108 1.393.391c.598.29 1.312.733 2.327 1.363l2 1.241c.961.597 1.636 1.016 2.14 1.402c.489.375.77.684.963 1.036c.193.353.306.766.365 1.398c.061.648.062 1.465.062 2.623v1.521c0 1.97-.002 3.376-.14 4.443c-.136 1.048-.393 1.656-.82 2.099c-.425.439-1.003.7-2.004.839c-1.026.142-2.379.144-4.286.144h-4c-1.908 0-3.26-.002-4.286-.144c-1.001-.14-1.579-.4-2.003-.84c-.428-.442-.685-1.05-.82-2.098c-.14-1.067-.141-2.472-.141-4.443v-1.521c0-1.158 0-1.975.062-2.623c.059-.632.172-1.045.365-1.398c.193-.352.474-.661.964-1.036c.503-.386 1.178-.805 2.139-1.402z"
        clip-rule="evenodd" />
    </symbol>
    <symbol id="location" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7m0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5s2.5 1.12 2.5 2.5s-1.12 2.5-2.5 2.5" />
    </symbol>
    <symbol id="phone" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24c1.12.37 2.33.57 3.57.57c.55 0 1 .45 1 1V20c0 .55-.45 1-1 1c-9.39 0-17-7.61-17-17c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1c0 1.25.2 2.45.57 3.57c.11.35.03.74-.25 1.02l-2.2 2.2z" />
    </symbol>
    <symbol id="email" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5l-8-5V6l8 5l8-5v2z" />
    </symbol>
    <symbol id="calendar" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z" />
    </symbol>
    <symbol id="arrow-right" viewBox="0 0 24 24">
      <path fill="currentColor" d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6l-6 6l-1.41-1.41z" />
    </symbol>
    <symbol id="arrow-left" viewBox="0 0 24 24">
      <path fill="currentColor" d="M15.41 7.41L14 6l-6 6l6 6l1.41-1.41L10.83 12z" />
    </symbol>
    <symbol id="clock" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z" />
    </symbol>
    <symbol id="meditation" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5l1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
    </symbol>
    <symbol id="chef-hat" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2M21 9V7L15 1H9L3 7V9H1V11H3V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V11H23V9H21M19 19H5V11H19V19Z" />
    </symbol>
    <symbol id="swimming" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M2 18C4 22 8 22 12 22S20 22 22 18C20 14 16 14 12 14S4 14 2 18M6 18C7 16 9 16 12 16S17 16 18 18C17 20 15 20 12 20S7 20 6 18M9 18C9.5 17 10.5 17 12 17S14.5 17 15 18C14.5 19 13.5 19 12 19S9.5 19 9 18M12 18C12.2 17.8 12.5 17.8 12.8 18C12.5 18.2 12.2 18.2 12 18Z" />
    </symbol>
    <symbol id="spa" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M15.5 6.5C15.5 5.66 17 4 17 4S18.5 5.66 18.5 6.5C18.5 7.33 17.83 8 17 8S15.5 7.33 15.5 6.5M19.5 15.5C20.88 15.5 22 14.38 22 13S20.88 10.5 19.5 10.5S17 11.62 17 13S18.12 15.5 19.5 15.5M13 12.5C13 11.67 12.33 11 11.5 11S10 11.67 10 12.5S10.67 14 11.5 14S13 13.33 13 12.5M6.5 15.5C7.88 15.5 9 14.38 9 13S7.88 10.5 6.5 10.5S4 11.62 4 13S5.12 15.5 6.5 15.5M12 18C13.38 18 14.5 16.88 14.5 15.5S13.38 13 12 13S9.5 14.12 9.5 15.5S10.62 18 12 18M12 22C13.38 22 14.5 20.88 14.5 19.5S13.38 17 12 17S9.5 18.12 9.5 19.5S10.62 22 12 22M6.5 22C7.88 22 9 20.88 9 19.5S7.88 17 6.5 17S4 18.12 4 19.5S5.12 22 6.5 22M19.5 22C20.88 22 22 20.88 22 19.5S20.88 17 19.5 17S17 18.12 17 19.5S18.12 22 19.5 22Z" />
    </symbol>
    <symbol id="concierge" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5l1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
    </symbol>
    <symbol id="business" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
    </symbol>
  </svg>

  <header id="header">
    <nav class="header-top bg-secondary py-1">
      <div class="container-fluid padding-side">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
          <ul class="info d-flex flex-wrap list-unstyled m-0">
            <li class="location text-capitalize d-flex align-items-center me-4 small">
              @php
                $address = \App\Models\Setting::where('group', 'general')->where('key', 'contact_address')->first();
                $addressValue = $address ? $address->value : 'Via della Serenità, 123 - 00100 Roma';
                $googleMapsUrl = 'https://www.google.com/maps/search/' . urlencode($addressValue);
              @endphp
              <a href="{{ $googleMapsUrl }}" target="_blank" class="text-decoration-none text-body d-flex align-items-center">
                <svg class="color me-1" width="15" height="15">
                  <use xlink:href="#location"></use>
                </svg>
                <span class="header-top-text">Google Maps</span>
              </a>
            </li>
            <li class="text-capitalize ms-4 small">
              @php
                $phone = \App\Models\Setting::where('group', 'general')->where('key', 'contact_phone')->first();
                $phoneValue = $phone ? $phone->value : '+39 123 456 7890';
                $phoneUrl = 'tel:' . str_replace(' ', '', $phoneValue);
              @endphp
              <a href="{{ $phoneUrl }}" class="text-decoration-none text-body d-flex align-items-center">
                <svg class="color me-1" width="15" height="15">
                  <use xlink:href="#phone"></use>
                </svg>
                <span class="header-top-text">{{ $phoneValue }}</span>
              </a>
            </li>
            <li class="text-capitalize ms-4 small">
              @php
                $email = \App\Models\Setting::where('group', 'general')->where('key', 'contact_email')->first();
                $emailValue = $email ? $email->value : 'info@hotelmellow.com';
                $emailUrl = 'mailto:' . $emailValue;
              @endphp
              <a href="{{ $emailUrl }}" class="text-decoration-none text-body d-flex align-items-center">
                <svg class="color me-1" width="15" height="15">
                  <use xlink:href="#email"></use>
                </svg>
                <span class="header-top-text">{{ $emailValue }}</span>
              </a>
            </li>
          </ul>
          <ul class="social d-flex flex-wrap list-unstyled m-0">
            @php
              $socialSettings = \App\Models\Setting::where('group', 'social')->get()->pluck('value', 'key');
              $showSocialHeader = $socialSettings['show_social_header'] ?? true;
            @endphp
            
            @if($showSocialHeader)
            
            @if($socialSettings['facebook_url'] ?? false)
            <li class="ms-3">
              <a href="{{ $socialSettings['facebook_url'] }}" class="text-body" title="Facebook" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#333">
                  <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
              </a>
            </li>
            @endif
            
            @if($socialSettings['instagram_url'] ?? false)
            <li class="ms-3">
              <a href="{{ $socialSettings['instagram_url'] }}" class="text-body" title="Instagram" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#333">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.209-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
              </a>
            </li>
            @endif
            
            @if($socialSettings['tiktok_url'] ?? false)
            <li class="ms-3">
              <a href="{{ $socialSettings['tiktok_url'] }}" class="text-body" title="TikTok" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#333">
                  <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                </svg>
              </a>
            </li>
            @endif
            
            @if($socialSettings['whatsapp_url'] ?? false)
            <li class="ms-3">
              <a href="{{ $socialSettings['whatsapp_url'] }}" class="text-body" title="WhatsApp" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#333">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                </svg>
              </a>
            </li>
            @endif
            
            @if($socialSettings['linkedin_url'] ?? false)
            <li class="ms-3">
              <a href="{{ $socialSettings['linkedin_url'] }}" class="text-body" title="LinkedIn" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#333">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
              </a>
            </li>
            @endif
            
            @endif
          </ul>
        </div>
      </div>
    </nav>
    <nav id="primary-header" class="navbar navbar-expand-lg py-4">
      <div class="container-fluid padding-side">
        <div class="d-flex justify-content-between align-items-center w-100">
          <a class="navbar-brand" href="{{ route('home') }}">
            @php
                $logo = \App\Models\Setting::where('group', 'general')->where('key', 'logo')->first();
                if ($logo && $logo->value) {
                    $logoPath = str_starts_with($logo->value, 'mellow/') 
                        ? asset($logo->value) 
                        : asset('storage/' . $logo->value);
                } else {
                    $logoPath = asset('mellow/images/main-logo.png');
                }
            @endphp
            @php
                $siteName = \App\Models\Setting::where('group', 'general')->where('key', 'hotel_name')->first();
                $siteNameValue = $siteName ? $siteName->value : 'Hotel Mellow';
            @endphp
            <img src="{{ $logoPath }}" class="logo img-fluid" alt="{{ $siteNameValue }}">
          </a>
          <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar" aria-labelledby="bdNavbarOffcanvasLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="bdNavbarOffcanvasLabel">Menu</h5>
              <button type="button" class="btn-close btn-close-black mt-2" data-bs-dismiss="offcanvas"
                aria-label="Close" data-bs-target="#bdNavbar"></button>
            </div>
            <div class="offcanvas-body align-items-center justify-content-end">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('home') }}#rooms">Camere</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('home') }}#services">Servizi</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('home') }}#gallery">Gallery</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('blog.index') }}">Blog</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('contact.index') }}">Contatti</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>

  @yield('content')

  <!-- Footer Section -->
  <footer id="footer" class="bg-secondary pt-4">
    <div class="container-fluid padding-side">
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="footer-widget">
            @php
              $logo = \App\Models\Setting::where('group', 'general')->where('key', 'logo')->first();
              if ($logo && $logo->value) {
                  $footerLogoPath = str_starts_with($logo->value, 'mellow/') 
                      ? asset($logo->value) 
                      : asset('storage/' . $logo->value);
              } else {
                  $footerLogoPath = asset('mellow/images/main-logo.png');
              }
            @endphp
            <img src="{{ $footerLogoPath }}" alt="Logo" class="img-fluid mb-3" style="max-height: 60px;">
            <p class="text-dark">
              @php
                $hotelDescription = \App\Models\Setting::where('group', 'general')->where('key', 'hotel_description')->first();
                echo $hotelDescription ? $hotelDescription->value : 'Il vostro gateway alla serenità nel cuore della città.';
              @endphp
            </p>
            <div class="social-links mt-3">
              @php
                $footerSocialSettings = \App\Models\Setting::where('group', 'social')->get()->pluck('value', 'key');
                $showSocialFooter = $footerSocialSettings['show_social_footer'] ?? true;
              @endphp
              
              @if($showSocialFooter)
              
              @if($footerSocialSettings['facebook_url'] ?? false)
              <a href="{{ $footerSocialSettings['facebook_url'] }}" class="text-white me-3" title="Facebook" target="_blank">
                <i class="fab fa-facebook-f" style="font-size: 18px; color: #333;"></i>
              </a>
              @endif
              
              @if($footerSocialSettings['instagram_url'] ?? false)
              <a href="{{ $footerSocialSettings['instagram_url'] }}" class="text-white me-3" title="Instagram" target="_blank">
                <i class="fab fa-instagram" style="font-size: 18px; color: #333;"></i>
              </a>
              @endif
              
              @if($footerSocialSettings['tiktok_url'] ?? false)
              <a href="{{ $footerSocialSettings['tiktok_url'] }}" class="text-white me-3" title="TikTok" target="_blank">
                <i class="fab fa-tiktok" style="font-size: 18px; color: #333;"></i>
              </a>
              @endif
              
              @if($footerSocialSettings['whatsapp_url'] ?? false)
              <a href="{{ $footerSocialSettings['whatsapp_url'] }}" class="text-white me-3" title="WhatsApp" target="_blank">
                <i class="fab fa-whatsapp" style="font-size: 18px; color: #333;"></i>
              </a>
              @endif
              
              @if($footerSocialSettings['linkedin_url'] ?? false)
              <a href="{{ $footerSocialSettings['linkedin_url'] }}" class="text-white me-3" title="LinkedIn" target="_blank">
                <i class="fab fa-linkedin" style="font-size: 18px; color: #333;"></i>
              </a>
              @endif
              
              @if($footerSocialSettings['social_email'] ?? false)
              <a href="mailto:{{ $footerSocialSettings['social_email'] }}" class="text-white" title="Email">
                <i class="fas fa-envelope" style="font-size: 18px; color: #333;"></i>
              </a>
              @endif
              
              @endif
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 mb-4">
          <div class="footer-widget">
            <h5 class="text-white mb-3">Link Utili</h5>
            <ul class="list-unstyled">
              <li><a href="#rooms" class="text-dark text-decoration-none">Camere</a></li>
              <li><a href="#services" class="text-dark text-decoration-none">Servizi</a></li>
              <li><a href="#gallery" class="text-dark text-decoration-none">Gallery</a></li>
              <li><a href="#blog" class="text-dark text-decoration-none">Blog</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="footer-widget">
            <h5 class="text-white mb-3">Contatti</h5>
            <ul class="list-unstyled">
              <li class="text-dark mb-2">
                <i class="fas fa-map-marker-alt me-2"></i>
                @php
                  $address = \App\Models\Setting::where('group', 'general')->where('key', 'contact_address')->first();
                  $addressValue = $address ? $address->value : 'Via della Serenità, 123 - 00100 Roma';
                  $googleMapsUrl = 'https://www.google.com/maps/search/' . urlencode($addressValue);
                @endphp
                <a href="{{ $googleMapsUrl }}" target="_blank" class="text-dark text-decoration-none">{{ $addressValue }}</a>
              </li>
              <li class="text-dark mb-2">
                <i class="fas fa-phone me-2"></i>
                @php
                  $phone = \App\Models\Setting::where('group', 'general')->where('key', 'contact_phone')->first();
                  $phoneValue = $phone ? $phone->value : '+39 123 456 7890';
                  $phoneUrl = 'tel:' . str_replace(' ', '', $phoneValue);
                @endphp
                <a href="{{ $phoneUrl }}" class="text-dark text-decoration-none">{{ $phoneValue }}</a>
              </li>
              <li class="text-dark">
                <i class="fas fa-envelope me-2"></i>
                @php
                  $email = \App\Models\Setting::where('group', 'general')->where('key', 'contact_email')->first();
                  $emailValue = $email ? $email->value : 'info@hotelmellow.com';
                  $emailUrl = 'mailto:' . $emailValue;
                @endphp
                <a href="{{ $emailUrl }}" class="text-dark text-decoration-none">{{ $emailValue }}</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="footer-widget">
            @php
              $newsletterSettings = \App\Models\Setting::where('group', 'mailchimp')->get()->pluck('value', 'key');
              $newsletterEnabled = $newsletterSettings['newsletter_enabled'] ?? '1';
              $newsletterTitle = $newsletterSettings['newsletter_title'] ?? 'Newsletter';
              $newsletterDescription = $newsletterSettings['newsletter_description'] ?? 'Iscriviti per ricevere le nostre offerte speciali';
            @endphp
            
            @if($newsletterEnabled == '1')
            <h5 class="text-white mb-3">{{ $newsletterTitle }}</h5>
            <p class="text-dark">{{ $newsletterDescription }}</p>
            <livewire:newsletter-subscription />
            @endif
          </div>
        </div>
      </div>
      <hr class="text-white-50 my-4">
      <div class="row align-items-center">
        <div class="col-md-6">
          <p class="text-dark mb-0">&copy; 2024 
            @php
              $siteName = \App\Models\Setting::where('group', 'general')->where('key', 'hotel_name')->first();
              echo $siteName ? $siteName->value : 'Hotel Mellow';
            @endphp
            . Tutti i diritti riservati.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <a href="#" class="text-dark text-decoration-none me-3">Privacy Policy</a>
          <a href="#" class="text-dark text-decoration-none">Termini di Servizio</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="{{ asset('mellow/js/jquery-1.11.0.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('mellow/js/bootstrap.bundle.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('mellow/js/plugins.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script type="text/javascript" src="{{ asset('mellow/js/script.js') }}"></script>
  
  <!-- SEO Optimizations JavaScript -->
  <script type="text/javascript" src="{{ asset('js/seo.js') }}"></script>

  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
  
  <!-- Font Awesome ================================================== -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous">
  
  <!-- Force FontAwesome to load -->
  <style>
    /* Force FontAwesome to load properly */
    .fa, .fas, .far, .fab, .fal, .fa-solid, .fa-regular, .fa-brands {
      font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
      font-weight: 900 !important;
      display: inline-block !important;
      font-style: normal !important;
      font-variant: normal !important;
      text-rendering: auto !important;
      line-height: 1 !important;
    }
    
    .fab, .fa-brands {
      font-family: "Font Awesome 6 Brands", "Font Awesome 5 Brands", "FontAwesome" !important;
      font-weight: 400 !important;
    }
    
    .far, .fa-regular {
      font-weight: 400 !important;
    }
    
    /* Ensure social icons are visible */
    .social i, .social-links i {
      font-size: 16px !important;
      color: inherit;
      transition: color 0.3s ease !important;
    }
    
    .social a:hover i, .social-links a:hover i {
      color: var(--primary-color, #667eea) !important;
    }
    
    /* Hide header-top text on mobile, show only icons */
    @media (max-width: 767.98px) {
      .header-top .header-top-text {
        display: none !important;
      }
      
      .header-top .info li {
        margin-right: 0.5rem !important;
        margin-left: 0.5rem !important;
      }
      
      .header-top .info li a {
        margin-right: 0 !important;
      }
      
      .header-top .info li a svg {
        margin-right: 0 !important;
        width: 20px !important;
        height: 20px !important;
      }
      
      .header-top .social li svg {
        width: 20px !important;
        height: 20px !important;
      }
      
      .header-top .social li {
        margin-left: 0.75rem !important;
      }
    }
  </style>
  


  <!-- Custom Modal for Booking Response -->
  <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-4">
          <div id="modalIcon" class="mb-3">
            <!-- Icon will be set dynamically -->
          </div>
          <h5 id="modalTitle" class="mb-3"></h5>
          <p id="modalMessage" class="text-muted mb-4"></p>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Chiudi</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Booking Form JavaScript -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Gestione del form di prenotazione
      const bookingForm = document.getElementById('check_available');
      if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
          e.preventDefault();
          
          const formData = new FormData(bookingForm);
          const submitButton = bookingForm.querySelector('button[type="submit"]');
          const originalText = submitButton.innerHTML;
          
          // Disabilita il pulsante e mostra loading
          submitButton.disabled = true;
          submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Invio in corso...';
          
          // Invia i dati al server
          fetch('{{ route("booking.request") }}', {
            method: 'POST',
            body: formData,
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              showModal('success', 'Richiesta Inviata!', data.message);
              bookingForm.reset();
            } else {
              showModal('error', 'Errore', data.message || 'Errore durante l\'invio della richiesta');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            showModal('error', 'Errore', 'Errore durante l\'invio della richiesta. Riprova più tardi.');
          })
          .finally(() => {
            // Riabilita il pulsante
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
          });
        });
      }

      // Funzione per mostrare il modal personalizzato
      function showModal(type, title, message) {
        const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
        const modalIcon = document.getElementById('modalIcon');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        
        if (type === 'success') {
          modalIcon.innerHTML = '<i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>';
          modalTitle.textContent = title;
          modalTitle.className = 'mb-3 text-success';
        } else {
          modalIcon.innerHTML = '<i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>';
          modalTitle.textContent = title;
          modalTitle.className = 'mb-3 text-danger';
        }
        
        modalMessage.textContent = message;
        modal.show();
        
        // Force FontAwesome icons to render
        setTimeout(() => {
          const icons = modalIcon.querySelectorAll('i');
          icons.forEach(icon => {
            icon.style.fontFamily = '"Font Awesome 6 Free"';
            icon.style.fontWeight = '900';
            icon.style.display = 'inline-block';
            icon.style.fontStyle = 'normal';
            icon.style.fontVariant = 'normal';
            icon.style.textRendering = 'auto';
            icon.style.lineHeight = '1';
          });
        }, 100);
      }
    });
  </script>
</body>

</html>