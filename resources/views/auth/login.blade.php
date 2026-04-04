{{-- [Houcine] Cette vue étend le layout principal (layouts/app.blade.php) --}}
{{-- Tout ce qui est dans @section('content') remplace @yield('content') du layout --}}
@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h4 class="card-title text-center mb-4">Connexion</h4>

                {{-- [Houcine] @if($errors->any()) → affiche les erreurs de validation
                     withErrors() dans AuthController remplit $errors automatiquement --}}
                @if($errors->any())
                    <div class="alert alert-danger">
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
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            {{-- [Houcine] old('email') → remet la valeur tapée si le formulaire
                                 est renvoyé après une erreur (withInput() dans le controller) --}}
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                        {{-- [Houcine] @error('email') → affiche le message d'erreur
                             uniquement si le champ 'email' a une erreur de validation --}}
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- [Houcine] remember → cochée = Laravel crée un cookie longue durée
                         l'utilisateur reste connecté même après fermeture du navigateur --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">Se souvenir de moi</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>

                </form>

                <hr>
                <p class="text-center mb-0">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}">S'inscrire</a>
                </p>

            </div>
        </div>

    </div>
</div>

@endsection
