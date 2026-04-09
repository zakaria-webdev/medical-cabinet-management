@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Rendez-vous</h2>
        <div>
            <a href="{{ route('rendezvous.calendar') }}" class="btn btn-outline-primary me-2">
                Calendrier
            </a>
            <a href="{{ route('rendezvous.create') }}" class="btn btn-primary">
                + Nouveau RDV
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Patient</th><th>Médecin</th>
                <th>Date</th><th>Heure</th>
                <th>Statut</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($rendezvous as $rdv)
            <tr>
                <td>{{ $rdv->patient->nom }}</td>
                <td>Dr {{ $rdv->medecin->nom }}</td>
                <td>{{ $rdv->date_rdv->format('d/m/Y') }}</td>
                <td>{{ $rdv->heure_rdv }}</td>
                <td>
                    <span class="badge bg-{{ $rdv->statut === 'confirmé' ? 'success' :
                        ($rdv->statut === 'annulé' ? 'danger' :
                        ($rdv->statut === 'terminé' ? 'secondary' : 'primary')) }}">
                        {{ $rdv->statut }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('rendezvous.edit', $rdv) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('rendezvous.destroy', $rdv) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Confirmer ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $rendezvous->links() }}
</div>
@endsection