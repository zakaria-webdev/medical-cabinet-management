@extends('layouts.app')

@section('content')

<h2>Tableau de bord Admin</h2>
<p class="text-muted">Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>

<hr>

{{-- [Houcine] Boutons dashboard Admin - Sprint 2 --}}
<div class="d-flex flex-wrap gap-2 mt-3">
    <a href="{{ route('admin.users') }}" class="btn btn-primary">
        👥 Gérer les rôles des utilisateurs
    </a>
    <a href="/patients" class="btn btn-outline-primary">
        🏥 Voir les patients
    </a>
    <a href="{{ route('rendezvous.index') }}" class="btn btn-success">
        📅 Gérer les Rendez-Vous
    </a>
    <a href="{{ route('rendezvous.create') }}" class="btn btn-outline-success">
        ➕ Nouveau RDV
    </a>
    <a href="{{ route('rendezvous.calendar') }}" class="btn btn-outline-secondary">
        🗓️ Calendrier
    </a>
</div>

@endsection