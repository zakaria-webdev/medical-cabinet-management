@extends('layouts.app')

{{-- [Houcine] Vue : Gestion des Rôles --}}
{{-- Accessible uniquement par l'admin (protégé par middleware role:admin) --}}
{{-- Permet à l'admin de changer le rôle de n'importe quel utilisateur --}}

@section('content')

<div class="row mb-4">
    <div class="col">
        <h2>Gestion des Rôles</h2>
        <p class="text-muted">Modifiez le rôle de chaque utilisateur via le menu déroulant.</p>
    </div>
    <div class="col-auto">
        {{-- Bouton retour vers le dashboard admin --}}
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Retour au dashboard</a>
    </div>
</div>

{{-- Message de succès --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Message d'erreur --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nom complet</th>
                    <th>Email</th>
                    <th>Rôle actuel</th>
                    <th>Changer le rôle</th>
                </tr>
            </thead>
            <tbody>
                {{-- Boucle sur tous les utilisateurs --}}
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->prenom }} {{ $user->nom }}</td>
                    <td>{{ $user->email }}</td>

                    {{-- Badge coloré selon le rôle actuel --}}
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @elseif($user->role === 'medecin')
                            <span class="badge bg-primary">Médecin</span>
                        @elseif($user->role === 'secretaire')
                            <span class="badge bg-warning text-dark">Secrétaire</span>
                        @else
                            <span class="badge bg-secondary">Patient</span>
                        @endif
                    </td>

                    {{-- Dropdown pour changer le rôle --}}
                    {{-- Désactivé si c'est l'admin lui-même (sécurité) --}}
                    <td>
                        @if($user->id === auth()->id())
                            <span class="text-muted fst-italic">Votre compte</span>
                        @else
                            <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
                                @csrf
                                <div class="input-group input-group-sm" style="max-width: 220px;">
                                    <select name="role" class="form-select form-select-sm">
                                        @foreach($roles as $role)
                                            <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                                </div>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
