@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #0f2c4c;">
                👨‍⚕️ Tableau de bord Médecin
            </h2>
            <p class="text-muted mt-2 fs-5">Bienvenue, Dr. {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
        </div>
        <div>
            {{-- [Zakaria] Bouton principal pour Nouvelle Consultation --}}
            <a href="{{ route('consultations.create') }}" class="btn btn-warning btn-lg fw-bold shadow-sm rounded-pill px-4 text-dark">
                <i class="fas fa-plus-circle me-2"></i> Nouvelle Consultation
            </a>
        </div>
    </div>

    {{-- [Houcine] & [Zakaria] Boutons dashboard Médecin intégrés dans le nouveau design --}}
    <div class="row g-4 mb-5">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect">
                <div class="card-body p-4 text-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-calendar-check fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold">Rendez-vous</h5>
                    <div class="d-flex gap-2 justify-content-center mt-3">
                        <a href="{{ route('rendezvous.index') }}" class="btn btn-sm btn-success rounded-pill px-3">Mes Rendez-Vous</a>
                        <a href="{{ route('rendezvous.calendar') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Calendrier</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Patients</h5>
                    <a href="/patients" class="btn btn-sm btn-outline-primary w-100 rounded-pill mt-2">Mes Patients</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect">
                <div class="card-body p-4 text-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-folder-open fa-2x text-info"></i>
                    </div>
                    <h5 class="fw-bold">Dossiers & Historique</h5>
                    <div class="d-flex flex-column gap-2 mt-3">
                        <a href="{{ route('dossiers.index') }}" class="btn btn-sm btn-info text-white rounded-pill">Liste des Dossiers</a>
                        <a href="{{ route('consultations.index') }}" class="btn btn-sm btn-outline-dark rounded-pill">Historique Consultations</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
    .hover-effect { transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
    .hover-effect:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
</style>
@endpush
@endsection
