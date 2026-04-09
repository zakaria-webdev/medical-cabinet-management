@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Détail du Rendez-vous</h2>
    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Patient :</strong> {{ $rendezVous->patient->nom }} {{ $rendezVous->patient->prenom }}</p>
            <p><strong>Médecin :</strong> Dr. {{ $rendezVous->medecin->nom }}</p>
            <p><strong>Date :</strong> {{ $rendezVous->date_rdv->format('d/m/Y') }}</p>
            <p><strong>Heure :</strong> {{ $rendezVous->heure_rdv }}</p>
            <p><strong>Statut :</strong>
                <span class="badge bg-{{
                    $rendezVous->statut === 'confirmé' ? 'success' :
                    ($rendezVous->statut === 'annulé' ? 'danger' :
                    ($rendezVous->statut === 'terminé' ? 'secondary' : 'primary'))
                }}">{{ $rendezVous->statut }}</span>
            </p>
            <p><strong>Motif :</strong> {{ $rendezVous->motif ?? '—' }}</p>
        </div>
    </div>
    <a href="{{ route('rendezvous.index') }}" class="btn btn-outline-secondary mt-3">Retour</a>
</div>
@endsection
