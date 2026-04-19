{{-- [Houcine] Cette vue étend le layout principal (layouts/app.blade.php) --}}
{{-- Tout ce qui est dans @section('content') remplace @yield('content') du layout --}}
@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card shadow-lg border-0 rounded-4 mt-4">
            <div class="card-body p-5">

                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                        <i class="fas fa-user-lock fa-2x text-primary"></i>
                    </div>
                    <h3 class="fw-bold" style="color: #0f2c4c;">Connexion</h3>
                    <p class="text-muted">Accédez à votre espace personnel</p>
                </div>

                {{-- [Houcine] @if($errors->any()) → affiche les erreurs de validation
                     withErrors() dans AuthController remplit $errors automatiquement --}}
                @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- [Houcine] method POST → envoie les données au serveur
                     action route('login') → pointe vers AuthController@login --}}
                <form method="POST" action="{{ route('login') }}">

                    {{-- [Houcine] @csrf → génère un token caché dans le formulaire
                         Laravel vérifie ce token à la réception
                         Si absent → erreur 419 (protection contre les attaques CSRF) --}}
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control form-control-lg bg-light @error('email') is-invalid @enderror"
                            {{-- [Houcine] old('email') → remet la valeur tapée si le formulaire
                                 est renvoyé après une erreur (withInput() dans le controller) --}}
                            value="{{ old('email') }}"
                            placeholder="exemple@email.com"
                            required
                            autofocus
                        >
                        {{-- [Houcine] @error('email') → affiche le message d'erreur
                             uniquement si le champ 'email' a une erreur de validation --}}
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold">Mot de passe</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control form-control-lg bg-light @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- [Houcine] remember → cochée = Laravel crée un cookie longue durée
                         l'utilisateur reste connecté même après fermeture du navigateur --}}
                    <div class="mb-4 form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label text-muted">Se souvenir de moi</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-3">
                            Se connecter
                        </button>
                    </div>

                </form>

                <div class="text-center mt-4 pt-3 border-top">
                    <p class="text-muted mb-0">
                        Pas encore de compte ?
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">S'inscrire</a>
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
