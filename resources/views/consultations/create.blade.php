@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ajouter une Consultation (Zakaria)</h2>
       <a href="{{ route('medecin.dashboard') }}" class="btn btn-secondary">
    ⬅️ Tableau de bord
</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('consultations.store') }}" method="POST">
        @csrf

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Détails de la Consultation</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Rendez-vous associé *</label>
                        <select name="rdv_id" class="form-select" required>
                            <option value="">-- Sélectionnez le RDV --</option>
                            @foreach($rendezVous as $rdv)
                                <option value="{{ $rdv->id }}">RDV #{{ $rdv->id }} (Patient ID: {{ $rdv->patient_id }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dossier Médical du patient *</label>
                        <select name="dossier_medical_id" class="form-select" required>
                            <option value="">-- Sélectionnez le dossier --</option>
                            @foreach($dossiers as $dossier)
                                <option value="{{ $dossier->id }}">Dossier de : {{ $dossier->patient->nom }} {{ $dossier->patient->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date de la consultation *</label>
                    <input type="date" name="date_consultation" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Compte Rendu (Bilan du médecin) *</label>
                    <textarea name="compte_rendu" class="form-control" rows="4" placeholder="Tapez le compte rendu ici..." required></textarea>
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm border-success">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Prescription / Ordonnance (Optionnel)</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">Ne remplissez cette section que si vous donnez des médicaments au patient.</p>

                <div class="mb-3">
                    <label class="form-label">Médicaments (Noms et dosages)</label>
                    <textarea name="medicaments_details" class="form-control" rows="3" placeholder="Ex: Paracétamol 1000mg, 1 boite..."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes d'utilisation</label>
                    <textarea name="notes_utilisation" class="form-control" rows="2" placeholder="Ex: 1 comprimé le matin après le petit-déjeuner."></textarea>
                </div>
            </div>
        </div>

        <div class="text-end mb-5">
            <button type="submit" class="btn btn-primary btn-lg">Enregistrer la Consultation</button>
        </div>
    </form>
</div>
@endsection
