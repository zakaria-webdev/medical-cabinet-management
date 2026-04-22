@extends('layouts.app')

@section('content')

<div class="row mb-4 align-items-center">
    <div class="col">
        <h2>Gestion des Profils & Rôles</h2>
        <p class="text-muted mb-0">Gérez votre équipe : ajoutez, modifiez ou supprimez des membres.</p>
    </div>
    <div class="col-auto d-flex gap-2">
        <button type="button" class="btn btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addStaffModal">
            <i class="fas fa-plus-circle me-1"></i> Ajouter un membre
        </button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary shadow-sm">← Retour</a>
    </div>
</div>

{{-- Message de succès / erreur --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- [NOUVEAU] Boutons de Filtre par Rôle --}}
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('admin.users') }}" class="btn btn-sm {{ !request('role') ? 'btn-dark' : 'btn-outline-dark' }} rounded-pill px-4 fw-bold shadow-sm">
        <i class="fas fa-users me-1"></i> Tous
    </a>
    <a href="{{ route('admin.users', ['role' => 'medecin']) }}" class="btn btn-sm {{ request('role') == 'medecin' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4 fw-bold shadow-sm">
        <i class="fas fa-user-md me-1"></i> Médecins
    </a>
    <a href="{{ route('admin.users', ['role' => 'secretaire']) }}" class="btn btn-sm {{ request('role') == 'secretaire' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }} rounded-pill px-4 fw-bold shadow-sm">
        <i class="fas fa-user-tie me-1"></i> Secrétaires
    </a>
    <a href="{{ route('admin.users', ['role' => 'patient']) }}" class="btn btn-sm {{ request('role') == 'patient' ? 'btn-secondary' : 'btn-outline-secondary' }} rounded-pill px-4 fw-bold shadow-sm">
        <i class="fas fa-user-injured me-1"></i> Patients
    </a>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Rôle actuel</th>
                        <th>Changer le rôle</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-3 fw-bold text-muted">{{ $user->id }}</td>
                        <td class="fw-bold">{{ $user->prenom }} {{ $user->nom }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger rounded-pill px-3">Admin</span>
                            @elseif($user->role === 'medecin')
                                <span class="badge bg-primary rounded-pill px-3">Médecin</span>
                            @elseif($user->role === 'secretaire')
                                <span class="badge bg-warning text-dark rounded-pill px-3">Secrétaire</span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3">Patient</span>
                            @endif
                        </td>
                        <td>
                            @if($user->id === auth()->id())
                                <span class="text-muted fst-italic small">Votre compte</span>
                            @else
                                <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
                                    @csrf
                                    <div class="input-group input-group-sm" style="max-width: 220px;">
                                        <select name="role" class="form-select form-select-sm bg-light">
                                            @foreach($roles as $role)
                                                <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm fw-bold">Enregistrer</button>
                                    </div>
                                </form>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            @if($user->id !== auth()->id())
                                {{-- Bouton Modifier (Ouvre le modal) --}}
                                <button type="button" class="btn btn-sm btn-outline-warning text-dark rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}" title="Modifier le profil">
                                    <i class="fas fa-edit"></i>
                                </button>

                                {{-- Bouton Supprimer --}}
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce membre définitivement ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                                {{-- [NOUVEAU] Modal Modifier pour chaque utilisateur --}}
                                <div class="modal fade text-start" id="editModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header bg-light border-0">
                                                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-user-edit text-warning me-2"></i>Modifier le Profil</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.users.updateProfile', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold small">Prénom</label>
                                                            <input type="text" name="prenom" class="form-control bg-light" value="{{ $user->prenom }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold small">Nom</label>
                                                            <input type="text" name="nom" class="form-control bg-light" value="{{ $user->nom }}" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold small">Email</label>
                                                            <input type="email" name="email" class="form-control bg-light" value="{{ $user->email }}" required>
                                                        </div>
                                                        <div class="col-12 mt-3 border-top pt-3">
                                                            <label class="form-label fw-bold small text-danger">Nouveau Mot de passe <span class="fw-normal text-muted">(Optionnel)</span></label>
                                                            <input type="password" name="password" class="form-control bg-light" placeholder="Laissez vide pour ne pas changer">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 bg-light">
                                                    <button type="button" class="btn btn-outline-secondary rounded-pill fw-bold px-4" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-warning text-dark rounded-pill fw-bold px-4">Mettre à jour</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted"><i class="fas fa-ban"></i></span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Ajouter Staff (Gardé identique à avant) --}}
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold" style="color: #0f2c4c;">
                    <i class="fas fa-user-plus text-success me-2"></i>Nouveau Membre
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Prénom *</label>
                            <input type="text" name="prenom" class="form-control bg-light" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Nom *</label>
                            <input type="text" name="nom" class="form-control bg-light" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Email *</label>
                            <input type="email" name="email" class="form-control bg-light" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Rôle *</label>
                            <select name="role" class="form-select bg-light" required>
                                <option value="medecin">Médecin</option>
                                <option value="secretaire">Secrétaire</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Mot de passe *</label>
                            <input type="password" name="password" class="form-control bg-light" value="12345678" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary rounded-pill fw-bold px-4" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success rounded-pill fw-bold px-4">Créer le compte</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
