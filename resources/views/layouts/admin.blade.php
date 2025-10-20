<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>
    <!-- Updated: {{ now() }} -->

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Modal Fix CSS -->
    <link rel="stylesheet" href="{{ asset('css/modal-fix.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Admin Styles -->
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .admin-header {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .content-wrapper {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar p-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Mellow CMS</h4>
                        <small class="text-white-50">Admin Panel</small>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.sliders') ? 'active' : '' }}" href="{{ route('admin.sliders') }}">
                            <i class="fas fa-images me-2"></i> Slider
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.rooms') ? 'active' : '' }}" href="{{ route('admin.rooms') }}">
                            <i class="fas fa-bed me-2"></i> Camere
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.gallery') ? 'active' : '' }}" href="{{ route('admin.gallery') }}">
                            <i class="fas fa-camera me-2"></i> Gallery
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.services') ? 'active' : '' }}" href="{{ route('admin.services') }}">
                            <i class="fas fa-concierge-bell me-2"></i> Servizi
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.blogs') ? 'active' : '' }}" href="{{ route('admin.blogs') }}">
                            <i class="fas fa-blog me-2"></i> Blog
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.statistics') ? 'active' : '' }}" href="{{ route('admin.statistics') }}">
                            <i class="fas fa-chart-bar me-2"></i> Statistiche
                        </a>
            <a class="nav-link {{ request()->routeIs('admin.about') ? 'active' : '' }}" href="{{ route('admin.about') }}">
                <i class="fas fa-info-circle me-2"></i> About Us
            </a>
            <a class="nav-link {{ request()->routeIs('admin.booking-requests') ? 'active' : '' }}" href="{{ route('admin.booking-requests') }}">
                <i class="fas fa-calendar-check me-2"></i> Prenotazioni
            </a>
            <a class="nav-link {{ request()->routeIs('admin.contact-messages') ? 'active' : '' }}" href="{{ route('admin.contact-messages') }}">
                <i class="fas fa-envelope me-2"></i> Messaggi
            </a>
            <a class="nav-link {{ request()->routeIs('admin.seo') ? 'active' : '' }}" href="{{ route('admin.seo') }}">
                <i class="fas fa-search me-2"></i> SEO
            </a>
            <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                <i class="fas fa-cog me-2"></i> Impostazioni
            </a>
                        <hr class="text-white-50">
                        <a class="nav-link" href="{{ route('home') }}" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i> Vedi Sito
                        </a>
                        <a class="nav-link" href="{{ route('profile') }}">
                            <i class="fas fa-user me-2"></i> Profilo
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-0">
                <div class="content-wrapper">
                    <!-- Header -->
                    <header class="admin-header p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h4 mb-0">{{ $title }}</h1>
                            <div class="d-flex align-items-center">
                                <span class="text-muted me-3">Benvenuto, {{ Auth::user()->name }}</span>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('profile') }}">Profilo</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main class="p-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Modal Fix Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for Livewire events
            document.addEventListener('livewire:init', () => {
                // Close modal when clicking outside
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('modal') && e.target.classList.contains('show')) {
                        // Find the close method for this modal
                        const modal = e.target;
                        const closeButton = modal.querySelector('[wire\\:click*="cancel"], [wire\\:click*="hide"], [wire\\:click*="close"]');
                        if (closeButton) {
                            closeButton.click();
                        }
                    }
                });

                // Handle ESC key to close modals
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        const openModal = document.querySelector('.modal.show');
                        if (openModal) {
                            const closeButton = openModal.querySelector('[wire\\:click*="cancel"], [wire\\:click*="hide"], [wire\\:click*="close"]');
                            if (closeButton) {
                                closeButton.click();
                            }
                        }
                    }
                });

                // Force close modal when Livewire resets
                Livewire.on('close-modal', () => {
                    const openModal = document.querySelector('.modal.show');
                    if (openModal) {
                        openModal.classList.remove('show');
                        openModal.style.display = 'none';
                        document.body.classList.remove('modal-open');
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.remove();
                        }
                    }
                });
            });
        });

        // Additional modal cleanup
        function cleanupModal() {
            // Remove modal backdrop
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            
            // Remove modal-open class from body
            document.body.classList.remove('modal-open');
            
            // Hide any visible modals
            const modals = document.querySelectorAll('.modal.show');
            modals.forEach(modal => {
                modal.classList.remove('show');
                modal.style.display = 'none';
            });
        }

        // Call cleanup on page unload
        window.addEventListener('beforeunload', cleanupModal);
    </script>
</body>
</html>

