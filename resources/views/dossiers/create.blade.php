@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Ajouter un Dossier Médical</h2>

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <form action="{{ route('dossiers.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="patient_id" class="form-label fw-bold">Sélectionner un Patient <span class="text-danger">*</span></label>
                    <select class="form-select @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id" required>
                        <option value="" selected disabled>-- Choisissez un patient sans dossier --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->nom }} {{ $patient->prenom }} (CIN: {{ $patient->cin }})</option>
                        @endforeach
                    </select>
                    @error('patient_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="groupe_sanguin" class="form-label fw-bold">Groupe Sanguin</label>
                    <select class="form-select @error('groupe_sanguin') is-invalid @enderror" id="groupe_sanguin" name="groupe_sanguin">
                        <option value="">-- Inconnu --</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                    @error('groupe_sanguin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="allergies" class="form-label fw-bold">Allergies</label>
                    <textarea class="form-control" id="allergies" name="allergies" rows="2" placeholder="Ex: Pénicilline, Arachides..."></textarea>
                </div>

                <div class="mb-3">
                    <label for="maladies_chroniques" class="form-label fw-bold">Maladies Chroniques</label>
                    <textarea class="form-control" id="maladies_chroniques" name="maladies_chroniques" rows="2" placeholder="Ex: Diabète, Hypertension..."></textarea>
                </div>

                <div class="mb-3">
                    <label for="operations_chirurgicales" class="form-label fw-bold">Opérations Chirurgicales (Antécédents)</label>
                    <textarea class="form-control" id="operations_chirurgicales" name="operations_chirurgicales" rows="2" placeholder="Ex: Appendicite en 2015..."></textarea>
                </div>

                <div class="mb-3">
                    <label for="traitement_en_cours" class="form-label fw-bold">Traitement en Cours</label>
                    <textarea class="form-control" id="traitement_en_cours" name="traitement_en_cours" rows="2" placeholder="Ex: Médicaments actuels..."></textarea>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('dossiers.index') }}" class="btn btn-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer le Dossier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
