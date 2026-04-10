@extends('layouts.app')

@section('content')

<h2>Tableau de bord Médecin</h2>
<p class="text-muted">Bienvenue, Dr. {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>

<hr>

{{-- [Houcine] Boutons dashboard Médecin - Sprint 2 --}}
<div class="d-flex flex-wrap gap-2 mt-3">
    <a href="{{ route('rendezvous.index') }}" class="btn btn-success">
        📅 Mes Rendez-Vous
    </a>
    <a href="{{ route('rendezvous.calendar') }}" class="btn btn-outline-secondary">
        🗓️ Calendrier
    </a>
    <a href="/patients" class="btn btn-outline-primary">
        🏥 Mes Patients
    </a>

    {{-- [Zakaria] Boutons ajoutés pour la gestion des Dossiers et Consultations --}}

    <a href="{{ route('dossiers.index') }}" class="btn btn-info text-white shadow-sm">
        📂 Liste des Dossiers
    </a>

    <a href="{{ route('consultations.create') }}" class="btn btn-warning shadow-sm">
        ➕ Nouvelle Consultation
    </a>

    <a href="{{ route('consultations.index') }}" class="btn btn-outline-dark shadow-sm">
        📝 Historique
    </a>
</div>

@endsection