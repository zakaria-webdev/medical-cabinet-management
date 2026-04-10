@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('medecin.dashboard') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <h2 class="mb-0">📝 Historique des Consultations</h2>
        </div>
        <a href="{{ route('consultations.create') }}" class="btn btn-warning shadow-sm">
            ➕ Nouvelle Consultation
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>N°</th>
                            <th>Date</th>
                            <th>Patient</th>
                            <th>Médecin</th>
                            <th>RDV Associé</th>
                            <th>Ordonnance ?</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultations as $consultation)
                            <tr>
                                <td class="fw-bold">{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y') }}</td>
                                <td>
                                    {{ $consultation->dossierMedical->patient->nom ?? 'Inconnu' }}
                                    {{ $consultation->dossierMedical->patient->prenom ?? '' }}
                                </td>
                                <td>Dr. {{ $consultation->medecin->nom ?? 'Inconnu' }}</td>
                                <td>#{{ $consultation->rdv_id }}</td>
                                <td>
                                    @if($consultation->ordonnance)
                                        <span class="badge bg-success">Oui</span>
                                    @else
                                        <span class="badge bg-secondary">Non</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('consultations.show', $consultation->id) }}" class="btn btn-sm btn-outline-info">
                                        Détails
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Aucune consultation enregistrée pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
