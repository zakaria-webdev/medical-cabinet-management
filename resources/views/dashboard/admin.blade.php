@extends('layouts.app')

@section('content')

<h2>Tableau de bord Admin</h2>
<p class="text-muted">Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>

<hr>

{{-- [Houcine] Bouton temporaire — sera remplacé par un vrai dashboard en Sprint 2 --}}
<div class="d-flex gap-2 mt-3">
    <a href="{{ route('admin.users') }}" class="btn btn-primary">
        👥 Gérer les rôles des utilisateurs
    </a>
    <a href="/patients" class="btn btn-outline-primary">
        🏥 Voir les patients
    </a>
</div>

@endsection
