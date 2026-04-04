{{-- [Houcine] Hérite du layout principal → navbar + Bootstrap inclus automatiquement --}}
@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h4 class="card-title text-center mb-4">Inscription</h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- [Houcine] POST /register → AuthController@register --}}
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    {{-- [Houcine] @csrf obligatoire dans tout formulaire POST
                         génère: <input type="hidden" name="_token" value="...">
                         Laravel rejette le formulaire si ce token est absent ou invalide --}}

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input
                            type="text"
                            name="nom"
                            id="nom"
                            class="form-control @error('nom') is-invalid @enderror"
                            value="{{ old('nom') }}"
                            required
                            autofocus
                        >
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input
                            type="text"
                            name="prenom"
                            id="prenom"
                            class="form-control @error('prenom') is-invalid @enderror"
                            value="{{ old('prenom') }}"
                            required
                        >
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                        >
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

                    {{-- [Houcine] password_confirmation → requis par la règle 'confirmed'
                         dans AuthController@register validation
                         Laravel compare automatiquement password == password_confirmation --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">
                            Confirmer le mot de passe
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>

                </form>

                <hr>
                <p class="text-center mb-0">
                    Déjà un compte ?
                    <a href="{{ route('login') }}">Se connecter</a>
                </p>

            </div>
        </div>

    </div>
</div>

@endsection
