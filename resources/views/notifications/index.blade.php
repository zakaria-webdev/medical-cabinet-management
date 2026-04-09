{{-- [Houcine] Vue liste des notifications - Sprint 2 --}}
{{-- Cette vue affiche toutes les notifications de l'utilisateur connecté --}}
{{-- Elle étend le layout principal app.blade.php (navbar + bootstrap) --}}
@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- En-tête de la page --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>🔔 Mes Notifications</h2>

            {{-- Bouton "Tout marquer comme lu" affiché UNIQUEMENT --}}
            {{-- s'il y a des notifications non lues --}}
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form method="POST" action="{{ route('notifications.markAllAsRead') }}">
                    {{-- @csrf = token de sécurité obligatoire pour chaque formulaire POST --}}
                    {{-- Laravel vérifie ce token pour éviter les attaques CSRF --}}
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                        ✓ Tout marquer comme lu
                    </button>
                </form>
            @endif
        </div>

        {{-- Message de succès après une action (markAsRead ou markAllAsRead) --}}
        {{-- session('success') = message flash stocké en session par le contrôleur --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Boucle sur toutes les notifications paginées --}}
        {{-- $notifications vient de NotificationController@index --}}
        @forelse($notifications as $notif)

            {{-- Carte de notification --}}
            {{-- Style différent selon lue (bg-white) ou non lue (bg-light + bordure bleue) --}}
            <div class="card mb-3 {{ $notif->read_at ? '' : 'border-primary' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">

                        <div>
                            {{-- Icône selon statut lecture --}}
                            @if(!$notif->read_at)
                                <span class="badge bg-primary me-2">Nouveau</span>
                            @else
                                <span class="badge bg-secondary me-2">Lu</span>
                            @endif

                            {{-- Message principal stocké dans data['message'] --}}
                            {{-- $notif->data est automatiquement décodé du JSON par Laravel --}}
                            <strong>{{ $notif->data['message'] }}</strong>

                            {{-- Détails du RDV --}}
                            <p class="mb-1 mt-2 text-muted">
                                📅 <strong>{{ $notif->data['date_rdv'] }}</strong>
                                à <strong>{{ $notif->data['heure_rdv'] }}</strong>
                                — Patient : {{ $notif->data['patient'] }}
                            </p>

                            {{-- Motif affiché uniquement s'il existe (nullable) --}}
                            @if($notif->data['motif'])
                                <p class="mb-1 text-muted">
                                    📋 Motif : {{ $notif->data['motif'] }}
                                </p>
                            @endif

                            {{-- Date d'envoi de la notification en format relatif --}}
                            {{-- diffForHumans() = "il y a 2 heures", "il y a 1 jour" etc. --}}
                            <small class="text-muted">
                                {{ $notif->created_at->diffForHumans() }}
                            </small>
                        </div>

                        {{-- Bouton marquer comme lu (affiché seulement si non lue) --}}
                        @if(!$notif->read_at)
                            <form method="POST"
                                  action="{{ route('notifications.markAsRead', $notif->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    ✓ Marquer lu
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>

        {{-- @empty = affiché si $notifications est vide (aucune notification) --}}
        @empty
            <div class="text-center py-5 text-muted">
                <p style="font-size: 3rem;">🔕</p>
                <h5>Aucune notification pour le moment.</h5>
                <p>Les rappels de rendez-vous apparaîtront ici.</p>
            </div>
        @endforelse

        {{-- Liens de pagination Bootstrap 5 --}}
        {{-- ->links() génère automatiquement les boutons Précédent/Suivant --}}
        <div class="mt-3">
            {{ $notifications->links() }}
        </div>

    </div>
</div>

@endsection