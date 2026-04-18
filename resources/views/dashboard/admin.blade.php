@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #0f2c4c;">
                🛡️ Tableau de bord Admin
            </h2>
            <p class="text-muted mt-2 fs-5">Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
        </div>
    </div>

    {{-- [Houcine] Boutons dashboard Admin - Sprint 2 intégrés --}}
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-users-cog fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Utilisateurs & Rôles</h5>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary rounded-pill w-100">Gérer les rôles</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect">
                <div class="card-body p-4 text-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-hospital-user fa-2x text-info"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Patients</h5>
                    <a href="/patients" class="btn btn-sm btn-outline-info rounded-pill w-100">Voir les patients</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect">
                <div class="card-body p-4 text-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-calendar-alt fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Rendez-vous</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('rendezvous.index') }}" class="btn btn-sm btn-success rounded-pill">Gérer les RDV</a>
                        <a href="{{ route('rendezvous.create') }}" class="btn btn-sm btn-outline-success rounded-pill">+ Nouveau RDV</a>
                        <a href="{{ route('rendezvous.calendar') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Calendrier</a>
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
