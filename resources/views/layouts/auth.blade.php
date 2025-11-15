<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title ?? 'Accesso' }} - {{ config('app.name', 'SuperHost CMS') }}</title>

  <!--Bootstrap -->
  <link rel="stylesheet" type="text/css" href="{{ asset('mellow/css/bootstrap.min.css') }}">

  <!--vendor css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('mellow/css/vendor.css') }}">

  <!-- Style Sheet -->
  <link rel="stylesheet" type="text/css" href="{{ asset('mellow/style.css') }}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Vite for Livewire -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <!-- Livewire Styles -->
  @livewireStyles

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Upright:wght@300;400;500;600;700&family=Sora:wght@100..800&display=swap"
    rel="stylesheet">
  
  <style>
    .auth-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #d8cbb8;
      padding: 2rem;
    }
    .auth-card {
      background: white;
      border-radius: 20px;
      padding: 3rem;
      max-width: 450px;
      width: 100%;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }
    .auth-logo {
      text-align: center;
      margin-bottom: 2rem;
    }
    .auth-logo img {
      max-height: 80px;
      max-width: 200px;
    }
    .auth-title {
      font-family: var(--heading-font, 'Cormorant Upright', serif);
      font-size: 2rem;
      color: var(--primary-color, #4379c2);
      margin-bottom: 0.5rem;
      text-align: center;
    }
    .auth-subtitle {
      text-align: center;
      color: var(--gray-color, #777F81);
      margin-bottom: 2rem;
    }
    .form-label {
      font-weight: 600;
      color: var(--dark-color, #353535);
      margin-bottom: 0.5rem;
    }
    .form-control {
      border-radius: 8px;
      border: 1px solid #e0e0e0;
      padding: 0.75rem 1rem;
      font-size: 1rem;
    }
    .form-control:focus {
      border-color: var(--primary-color, #4379c2);
      box-shadow: 0 0 0 0.2rem rgba(67, 121, 194, 0.25);
    }
    .btn-primary {
      background-color: var(--primary-color, #4379c2);
      border-color: var(--primary-color, #4379c2);
      border-radius: 8px;
      padding: 0.75rem 2rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #3568a8;
      border-color: #3568a8;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(67, 121, 194, 0.3);
    }
    .text-danger {
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }
    .alert {
      border-radius: 8px;
      margin-bottom: 1.5rem;
    }
    .form-check-input:checked {
      background-color: var(--primary-color, #4379c2);
      border-color: var(--primary-color, #4379c2);
    }
    a {
      color: var(--primary-color, #4379c2);
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-logo">
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
        <img src="{{ $logoPath }}" alt="Logo" class="img-fluid">
      </div>

      <h1 class="auth-title">{{ $title ?? 'Accesso' }}</h1>
      @if(isset($subtitle))
        <p class="auth-subtitle">{{ $subtitle }}</p>
      @endif

      @if(session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{ $slot }}
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('mellow/js/jquery-1.11.0.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('mellow/js/bootstrap.bundle.min.js') }}"></script>
  
  <!-- Livewire Scripts -->
  @livewireScripts
  
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>

