@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('consultations.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Retour à l'historique
        </a>
        <h2 class="mb-0">Détails de la Consultation N°{{ $consultation->id }}</h2>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Infos Générales</h5>
                </div>
                <div class="card-body">
                    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y') }}</p>
                    <p><strong>Patient :</strong> {{ $consultation->dossierMedical->patient->nom ?? '' }} {{ $consultation->dossierMedical->patient->prenom ?? '' }}</p>
                    <p><strong>Médecin :</strong> Dr. {{ $consultation->medecin->nom ?? '' }}</p>
                    <p><strong>RDV N° :</strong> {{ $consultation->rdv_id }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Compte Rendu (Bilan)</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0" style="white-space: pre-line;">{{ $consultation->compte_rendu }}</p>
                </div>
            </div>

            @if($consultation->ordonnance)
            <div class="card shadow-sm border-success mb-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Prescription / Ordonnance</h5>
                    <a href="{{ route('consultations.pdf', $consultation->id) }}" target="_blank" class="btn btn-sm btn-light text-success fw-bold shadow-sm">
                        📄 Générer PDF
                    </a>
                </div>
                <div class="card-body">
                    <h6>Médicaments (Noms et dosages) :</h6>
                    <p class="bg-light p-3 rounded" style="white-space: pre-line;">{{ $consultation->ordonnance->medicaments_details }}</p>

                    @if($consultation->ordonnance->notes_utilisation)
                        <h6 class="mt-3">Notes d'utilisation :</h6>
                        <p class="text-muted">{{ $consultation->ordonnance->notes_utilisation }}</p>
                    @endif
                </div>
            </div>
            @else
            <div class="alert alert-secondary">
                Aucune ordonnance n'a été prescrite lors de cette consultation.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
