@extends('layouts.app')

@section('content')
<div class="container" style="max-width:600px">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Modifier le rendez-vous</h2>
        <a href="{{ route('rendezvous.index') }}" class="btn btn-outline-secondary">
            Retour
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('rendezvous.update', $rendezVous) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Patient</label>
            <select name="patient_id" class="form-select" required>
                @foreach($patients as $p)
                    <option value="{{ $p->id }}"
                        {{ $rendezVous->patient_id == $p->id ? 'selected' : '' }}>
                        {{ $p->nom }} {{ $p->prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Médecin</label>
            <select name="medecin_id" class="form-select" required>
                @foreach($medecins as $m)
                    <option value="{{ $m->id }}"
                        {{ $rendezVous->medecin_id == $m->id ? 'selected' : '' }}>
                        Dr {{ $m->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date_rdv" class="form-control"
                    value="{{ old('date_rdv', $rendezVous->date_rdv->format('Y-m-d')) }}"
                    required>
            </div>
            <div class="col mb-3">
                <label class="form-label">Heure</label>
                <input type="time" name="heure_rdv" class="form-control"
                    value="{{ old('heure_rdv', $rendezVous->heure_rdv) }}"
                    min="08:00" max="18:00" step="900" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Statut</label>
            <select name="statut" class="form-select" required>
                <option value="en_attente"
                    {{ old('statut', $rendezVous->statut) == 'en_attente' ? 'selected' : '' }}>
                    En attente
                </option>
                <option value="confirmé"
                    {{ old('statut', $rendezVous->statut) == 'confirmé' ? 'selected' : '' }}>
                    Confirmé
                </option>
                <option value="annulé"
                    {{ old('statut', $rendezVous->statut) == 'annulé' ? 'selected' : '' }}>
                    Annulé
                </option>
                <option value="terminé"
                    {{ old('statut', $rendezVous->statut) == 'terminé' ? 'selected' : '' }}>
                    Terminé
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Motif (optionnel)</label>
            <textarea name="motif" class="form-control" rows="3">{{ old('motif', $rendezVous->motif) }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning w-100">
                Enregistrer les modifications
            </button>
        </div>

    </form>
</div>
@endsection