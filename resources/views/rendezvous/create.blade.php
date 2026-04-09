@extends('layouts.app')
@section('content')
<div class="container" style="max-width:600px">
    <h2 class="mb-4">Nouveau rendez-vous</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('rendezvous.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Patient</label>
            <select name="patient_id" class="form-select" required>
                @foreach($patients as $p)
                    <option value="{{ $p->id }}">{{ $p->nom }} {{ $p->prenom }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Médecin</label>
            <select name="medecin_id" class="form-select" required>
                @foreach($medecins as $m)
                    <option value="{{ $m->id }}">Dr {{ $m->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date_rdv" class="form-control"
                       min="{{ now()->format('Y-m-d') }}" required>
            </div>
            <div class="col mb-3">
                <label class="form-label">Heure</label>
                <input type="time" name="heure_rdv" class="form-control"
                       min="08:00" max="18:00" step="900" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Motif (optionnel)</label>
            <textarea name="motif" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
    </form>
</div>
@endsection