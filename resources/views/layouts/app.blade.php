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
</head>
<body>

    {{-- [Houcine] Navbar → shown on every page that extends this layout --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">Cabinet Médical</a>
            <div class="ms-auto">
                @auth
                    {{-- [Houcine] @auth = shown only if user is logged in --}}
                    <span class="text-white me-3">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Déconnexion</button>
                    </form>
                @else
                    {{-- [Houcine] @else = shown only if NOT logged in --}}
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Connexion</a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm">Inscription</a>
                @endauth
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
</body>
</html>
