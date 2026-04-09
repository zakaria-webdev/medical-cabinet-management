{{-- [Houcine] Composant cloche de notifications - Sprint 2 --}}
{{-- Ce partial est inclus dans layouts/app.blade.php via @include --}}
{{-- Il affiche une icône cloche avec un badge rouge indiquant le nombre --}}
{{-- de notifications NON lues de l'utilisateur connecté --}}

@auth
{{-- @auth = ce bloc ne s'affiche QUE si l'utilisateur est connecté --}}
{{-- unreadNotifications = relation Laravel (Notifiable trait) --}}
{{-- qui filtre les notifications où read_at IS NULL --}}

<div class="dropdown d-inline-block">

    {{-- Bouton déclencheur du dropdown Bootstrap --}}
    {{-- data-bs-toggle="dropdown" = comportement dropdown Bootstrap 5 --}}
    <a href="{{ route('notifications.index') }}"
       class="btn btn-outline-light btn-sm position-relative me-2"
       title="Notifications">

        {{-- Icône cloche Unicode --}}
        🔔

        {{-- Badge rouge affiché UNIQUEMENT s'il y a des notifications non lues --}}
        {{-- position-absolute + translate-middle = coin supérieur droit Bootstrap 5 --}}
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="position-absolute top-0 start-100 translate-middle
                         badge rounded-pill bg-danger">
                {{-- Affiche le nombre, max 99 pour ne pas déborder --}}
                {{ auth()->user()->unreadNotifications->count() > 99
                    ? '99+'
                    : auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </a>

</div>
@endauth