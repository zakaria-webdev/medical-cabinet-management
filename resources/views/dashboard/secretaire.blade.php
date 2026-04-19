@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #0f2c4c;">
                🖥️ Tableau de bord Secrétaire
            </h2>
            <p class="text-muted mt-2 fs-5">Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
        </div>
        <div>
            <a href="{{ route('rendezvous.create') }}" class="btn btn-primary btn-lg fw-bold shadow-sm rounded-pill px-4">
                <i class="fas fa-calendar-plus me-2"></i> Nouveau RDV
            </a>
        </div>
    </div>

    {{-- [Houcine] Boutons dashboard Secrétaire - Sprint 2 intégrés --}}
    <div class="row g-4 mb-5">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect border-start border-success border-5">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-4">
                        <i class="fas fa-calendar-alt fa-2x text-success"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Gestion des Rendez-vous</h4>
                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('rendezvous.index') }}" class="btn btn-sm btn-success rounded-pill">Gérer les RDV</a>
                            <a href="{{ route('rendezvous.calendar') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Calendrier</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect border-start border-primary border-5">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-4">
                        <i class="fas fa-address-book fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Base de données Patients</h4>
                        <p class="text-muted mb-2 small">Consultez les fiches patients.</p>
                        <a href="/patients" class="btn btn-sm btn-outline-primary rounded-pill">Voir les patients ➔</a>
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
