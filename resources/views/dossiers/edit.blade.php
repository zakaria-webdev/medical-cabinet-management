@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Modifier le Dossier Médical : <span class="text-primary">{{ $dossier->patient->nom }} {{ $dossier->patient->prenom }}</span></h2>

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <form action="{{ route('dossiers.update', $dossier->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Patient (Non modifiable)</label>
                    <input type="text" class="form-control" value="{{ $dossier->patient->nom }} {{ $dossier->patient->prenom }} (CIN: {{ $dossier->patient->cin }})" disabled>
                </div>

                <div class="mb-3">
                    <label for="groupe_sanguin" class="form-label fw-bold">Groupe Sanguin</label>
                    <select class="form-select @error('groupe_sanguin') is-invalid @enderror" id="groupe_sanguin" name="groupe_sanguin">
                        <option value="" {{ is_null($dossier->groupe_sanguin) ? 'selected' : '' }}>-- Inconnu --</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $groupe)
                            <option value="{{ $groupe }}" {{ $dossier->groupe_sanguin == $groupe ? 'selected' : '' }}>{{ $groupe }}</option>
                        @endforeach
                    </select>
                    @error('groupe_sanguin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="allergies" class="form-label fw-bold">Allergies</label>
                    <textarea class="form-control" id="allergies" name="allergies" rows="2">{{ $dossier->allergies }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="maladies_chroniques" class="form-label fw-bold">Maladies Chroniques</label>
                    <textarea class="form-control" id="maladies_chroniques" name="maladies_chroniques" rows="2">{{ $dossier->maladies_chroniques }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="operations_chirurgicales" class="form-label fw-bold">Opérations Chirurgicales</label>
                    <textarea class="form-control" id="operations_chirurgicales" name="operations_chirurgicales" rows="2">{{ $dossier->operations_chirurgicales }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="traitement_en_cours" class="form-label fw-bold">Traitement en Cours</label>
                    <textarea class="form-control" id="traitement_en_cours" name="traitement_en_cours" rows="2">{{ $dossier->traitement_en_cours }}</textarea>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('dossiers.index') }}" class="btn btn-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-success">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
