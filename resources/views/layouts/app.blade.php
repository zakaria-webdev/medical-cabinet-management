<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- [Houcine] csrf-token meta → used by JS for AJAX requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cabinet Médical</title>

    {{-- [Houcine] Bootstrap 5 CDN → shared design for all pages --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- [Houcine] @stack('styles') → allows child views to inject CSS via @push('styles') --}}
    {{-- Example: calendar.blade.php pushes FullCalendar CSS here --}}
    @stack('styles')
</head>
<body class="bg-light">

    {{-- [Zakaria & Houcine] Navbar Professionnelle --}}
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #0f2c4c;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-stethoscope text-info"></i> Cabinet Médical
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">

                    @auth
                        {{-- [Houcine] @auth = shown only if user is logged in --}}

                        <li class="nav-item">
                            @include('partials.notification-bell')
                        </li>

                        <li class="nav-item">
                            <span class="text-white fw-bold">
                                <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                            </span>
                        </li>

                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    @else
                        {{-- [Houcine] @else = shown only if NOT logged in --}}
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-info text-white fw-bold btn-sm px-3">Inscription</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        {{-- [Houcine] @yield('content') = placeholder
             Each view that extends this layout fills this section
             with its own content using @section('content') --}}
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- [Houcine] @stack('scripts') → allows child views to inject JS via @push('scripts') --}}
    {{-- Example: calendar.blade.php pushes FullCalendar JS here, AFTER Bootstrap --}}
    @stack('scripts')
</body>
</html>
