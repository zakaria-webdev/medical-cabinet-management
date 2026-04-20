@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- الترحيب والزر الفوقاني --}}
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 class="fw-bold mb-0" style="color: #0f2c4c;">
                🖥️ Tableau de bord Secrétaire
            </h2>
            <p class="text-muted mt-2 fs-5 mb-0">Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
        </div>
        <div>
            <a href="{{ route('rendezvous.create') }}" class="btn btn-primary btn-lg fw-bold shadow-sm rounded-pill px-4">
                <i class="fas fa-calendar-plus me-2"></i> Nouveau RDV
            </a>
        </div>
    </div>

    {{-- [الجديد]: أرقام سريعة (KPIs) --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-0 rounded-4" style="background-color: #e0f2fe; color: #0284c7;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold mb-1">Membres des RDV Aujourd'hui</h6>
                        <h2 class="mb-0 fw-bolder" style="font-size: 2.5rem;">{{ $rdvAujourdhuiCount ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-calendar-day fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-0 rounded-4" style="background-color: #fef08a; color: #a16207;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold mb-1">En Salle d'attente</h6>
                        <h2 class="mb-0 fw-bolder" style="font-size: 2.5rem;">{{ $enAttenteCount ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- البطاقات القديمة ديالكم --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect border-start border-success border-5">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-4">
                        <i class="fas fa-calendar-alt fa-2x text-success"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Gestion des Rendez-vous</h4>
                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('rendezvous.index') }}" class="btn btn-sm btn-success rounded-pill px-3">Gérer les RDV</a>
                            <a href="{{ route('rendezvous.calendar') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Calendrier</a>
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
                        <a href="/patients" class="btn btn-sm btn-outline-primary rounded-pill px-3">Voir les patients ➔</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- [الجديد]: طابلو المواعيد الجاية اليوم --}}
    <div class="card shadow-sm border-0 rounded-4 mt-2">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
            <h5 class="fw-bold" style="color: #0f2c4c;"><i class="fas fa-clock me-2 text-primary"></i> Prochains RDV d'aujourd'hui</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Heure</th>
                            <th class="py-3">Patient</th>
                            <th class="py-3">Statut</th>
                            <th class="py-3 pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prochainsRdv ?? [] as $rdv)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">
                                    {{ \Carbon\Carbon::parse($rdv->heure_rdv)->format('H:i') }}
                                </td>
                                <td class="fw-medium">
                                    {{ $rdv->patient->nom ?? 'Inconnu' }} {{ $rdv->patient->prenom ?? '' }}
                                </td>
                                <td>
                                    @if($rdv->statut == 'en_attente')
                                        <span class="badge bg-warning text-dark rounded-pill">En attente</span>
                                    @elseif($rdv->statut == 'confirme')
                                        <span class="badge bg-success rounded-pill">Confirmé</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">{{ ucfirst($rdv->statut) }}</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('rendezvous.show', $rdv->id) }}" class="btn btn-sm btn-light rounded-circle" title="Voir détails">
                                        <i class="fas fa-eye text-secondary"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="fas fa-mug-hot fa-2x mb-3 text-light"></i>
                                    <p class="mb-0">Aucun rendez-vous à venir pour le moment.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .hover-effect { transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
    .hover-effect:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }

    /* تحسينات صغيرة للطابلو */
    .table th { font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; }
    .table td, .table th { border-bottom-color: #f1f5f9; }
</style>
@endpush
@endsection
