@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('medecin.dashboard') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <h2 class="mb-0">Liste des Dossiers Médicaux</h2>
        </div>

        <a href="{{ route('dossiers.create') }}" class="btn btn-primary shadow-sm">
            + Créer un Dossier
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient (Nom & Prénom)</th>
                        <th>Groupe Sanguin</th>
                        <th>Date de Création</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dossiers as $dossier)
                        <tr>
                            <td>{{ $dossier->id }}</td>
                            <td>{{ $dossier->patient->nom }} {{ $dossier->patient->prenom }}</td>
                            <td>
                                <span class="badge bg-danger">{{ $dossier->groupe_sanguin ?? 'Non spécifié' }}</span>
                            </td>
                            <td>{{ $dossier->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('dossiers.show', $dossier->id) }}" class="btn btn-info btn-sm text-white" title="Voir">👁️</a>
                                <a href="{{ route('dossiers.edit', $dossier->id) }}" class="btn btn-warning btn-sm text-dark" title="Modifier">✏️</a>

                                <form action="{{ route('dossiers.destroy', $dossier->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce dossier ?')" title="Supprimer">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucun dossier médical trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
