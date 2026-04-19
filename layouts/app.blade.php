<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cabinet Médical — @yield('page-title', 'Dashboard')</title>
    //fonts.googleapis.com">
    //fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- [Houcine] Bootstrap kept for form validation + modals only --}}
    //cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- [Houcine] Custom design system --}}
    /app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

@auth
<div class="layout-wrapper">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar">

        {{-- Logo --}}
        <a href="/" class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </div>
            <div>
                <div class="sidebar-logo-text">Cabinet Médical</div>
                <div class="sidebar-logo-sub">Système de gestion</div>
            </div>
        </a>

        {{-- Navigation --}}
        <nav class="sidebar-nav">

            {{-- Admin nav --}}
            @if(auth()->user()->role === 'admin')
            <div class="sidebar-section-label">Administration</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Tableau de bord
            </a>
            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                Utilisateurs
            </a>
            <a href="/patients" class="{{ request()->is('patients*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Patients
            </a>
            <div class="sidebar-section-label">Planning</div>
            <a href="{{ route('rendezvous.index') }}" class="{{ request()->routeIs('rendezvous.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/>e x1="16" y1="2" x2="16" y2="6"/>e x1="8" y1="2" x2="8" y2="6"/>e x1="3" y1="10" x2="21" y2="10"/></svg>
                Rendez-Vous
            </a>
            <a href="{{ route('rendezvous.calendar') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                Calendrier
            </a>
            @endif

            {{-- Médecin nav --}}
            @if(auth()->user()->role === 'medecin')
            <div class="sidebar-section-label">Espace Médecin</div>
            <a href="{{ route('medecin.dashboard') }}" class="{{ request()->routeIs('medecin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="/patients">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Mes Patients
            </a>
            <a href="{{ route('rendezvous.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/>e x1="16" y1="2" x2="16" y2="6"/>e x1="8" y1="2" x2="8" y2="6"/>e x1="3" y1="10" x2="21" y2="10"/></svg>
                Rendez-Vous
            </a>
            <a href="{{ route('rendezvous.calendar') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">ircle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Calendrier
            </a>
            <div class="sidebar-section-label">Médical</div>
            <a href="{{ route('consultations.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                Consultations
            </a>
            <a href="{{ route('dossiers.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/></svg>
                Dossiers
            </a>
            @endif

            {{-- Secrétaire nav --}}
            @if(auth()->user()->role === 'secretaire')
            <div class="sidebar-section-label">Espace Secrétaire</div>
            <a href="{{ route('secretaire.dashboard') }}" class="{{ request()->routeIs('secretaire.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="/patients"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>Patients</a>
            <a href="{{ route('rendezvous.index') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/>e x1="16" y1="2" x2="16" y2="6"/>e x1="8" y1="2" x2="8" y2="6"/>e x1="3" y1="10" x2="21" y2="10"/></svg>Rendez-Vous</a>
            <a href="{{ route('rendezvous.calendar') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">ircle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Calendrier</a>
            @endif

            {{-- Patient nav --}}
            @if(auth()->user()->role === 'patient')
            <div class="sidebar-section-label">Mon Espace</div>
            <a href="{{ route('patient.dashboard') }}" class="{{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="{{ route('rendezvous.create') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">ircle cx="12" cy="12" r="10"/>e x1="12" y1="8" x2="12" y2="16"/>e x1="8" y1="12" x2="16" y2="12"/></svg>Prendre RDV</a>
            <a href="{{ route('rendezvous.index') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/>e x1="16" y1="2" x2="16" y2="6"/>e x1="8" y1="2" x2="8" y2="6"/>e x1="3" y1="10" x2="21" y2="10"/></svg>Mes RDV</a>
            @endif

            {{-- Always visible --}}
            <div class="sidebar-section-label">Compte</div>
            <a href="{{ route('notifications.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                Notifications
                @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                @if($unread > 0)
                    <span class="sidebar-badge">{{ $unread }}</span>
                @endif
            </a>
        </nav>

        {{-- User Card --}}
        <div class="sidebar-user">
            @php
                $initials = strtoupper(substr(auth()->user()->prenom, 0, 1) . substr(auth()->user()->nom, 0, 1));
                $roleColors = ['admin' => 'blue', 'medecin' => 'teal', 'secretaire' => 'violet', 'patient' => 'violet'];
                $avatarClass = $roleColors[auth()->user()->role] ?? 'blue';
            @endphp
            <div class="sidebar-user-avatar avatar-{{ $avatarClass }}">{{ $initials }}</div>
            <div>
                <div class="sidebar-user-name">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</div>
                <div class="sidebar-user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-user-logout" title="Déconnexion">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                </button>
            </form>
        </div>

    </aside>
    {{-- ===== END SIDEBAR ===== --}}

    {{-- ===== MAIN ===== --}}
    <div class="main-content">

        {{-- Topbar --}}
        <header class="topbar">
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-right">
                <span class="topbar-date" id="topbar-date"></span>
                <a href="{{ route('notifications.index') }}" class="notif-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notif-dot"></span>
                    @endif
                </a>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="page-body">
            @yield('content')
        </div>

    </div>
    {{-- ===== END MAIN ===== --}}

</div>
@else
    {{-- Non-authenticated pages (login/register) --}}
    @yield('content')
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// [Houcine] Live date in topbar
const d = new Date();
const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
const el = document.getElementById('topbar-date');
if (el) el.textContent = d.toLocaleDateString('fr-FR', options);
</script>
@stack('scripts')
</body>
</html>