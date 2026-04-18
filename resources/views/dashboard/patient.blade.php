@extends('layouts.app')

@section('content')

{{-- [Houcine] Dashboard Patient - cahier des charges: patient peut prendre RDV en ligne --}}
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #0f2c4c;">
                👋 Bienvenue, <span class="text-primary">{{ auth()->user()->prenom }}</span> !
            </h2>
            <p class="text-muted mt-2 fs-5">Voici le résumé de votre espace santé.</p>
        </div>
        
    </div>

    <div class="row g-4 mb-5">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-4">
                        <i class="fas fa-stethoscope fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Prendre un Rendez-vous</h4>
                        <p class="text-muted mb-2 small">Réservez une consultation avec votre médecin.</p>
                        <a href="{{ route('rendezvous.create') }}" class="text-primary fw-bold text-decoration-none">
                            Réserver maintenant ➔
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-4">
                        <i class="fas fa-calendar-check fa-2x text-success"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Mes Rendez-vous</h4>
                        <p class="text-muted mb-2 small">Consultez vos rendez-vous à venir et passés.</p>
                        <a href="{{ route('rendezvous.index') }}" class="text-success fw-bold text-decoration-none">
                            Voir mon historique ➔
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-light mt-4">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-info-circle fa-2x text-secondary"></i>
                <div>
                    <h5 class="fw-bold mb-0">Besoin d'aide avec vos rendez-vous ?</h5>
                    <p class="text-muted mb-0 small">Si vous souhaitez annuler ou modifier un rendez-vous urgent, veuillez contacter le secrétariat.</p>
                </div>
            </div>
            <button class="btn btn-outline-secondary fw-bold rounded-pill">Contactez le cabinet</button>
        </div>
    </div>

</div>

@push('styles')
<style>
    .hover-effect {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>
@endpush

@endsection

