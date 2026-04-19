@extends('layouts.app')
@section('page-title', 'Administration — <span>Cabinet Médical</span>')

@section('content')

{{-- [Houcine] Hero Banner Admin --}}
<div class="hero-banner hero-admin">
    <div class="hero-banner-content">
        <h1>Bonjour, {{ auth()->user()->prenom }} 👋</h1>
        <p>Bienvenue dans votre espace d'administration — {{ now()->format('l d F Y') }}</p>
    </div>
    {{-- SVG illustration watermark --}}
    <svg class="hero-illustration" viewBox="0 0 200 200" fill="white">
        ircle cx="100" cy="100" r="80" fill-opacity="0.3"/>
        <rect x="85" y="40" width="30" height="120" rx="4"/>
        <rect x="40" y="85" width="120" height="30" rx="4"/>
    </svg>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
        </div>
        <div>
            <div class="stat-label">Utilisateurs</div>
            <div class="stat-value" data-count="{{ \App\Models\User::count() }}">0</div>
            <div class="stat-delta neutral">Comptes actifs</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <div class="stat-label">Patients</div>
            <div class="stat-value" data-count="{{ \App\Models\Patient::count() }}">0</div>
            <div class="stat-delta neutral">Dossiers créés</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon violet">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/>e x1="16" y1="2" x2="16" y2="6"/>e x1="8" y1="2" x2="8" y2="6"/>e x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <div class="stat-label">RDV Aujourd'hui</div>
            <div class="stat-value" data-count="{{ \App\Models\RendezVous::whereDate('date_rdv', today())->count() }}">0</div>
            <div class="stat-delta up">↑ Planning du jour</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
        </div>
        <div>
            <div class="stat-label">Total RDV</div>
            <div class="stat-value" data-count="{{ \App\Models\RendezVous::count() }}">0</div>
            <div class="stat-delta neutral">Tous statuts</div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="card mb-4">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
            Actions rapides
        </div>
    </div>
    <div class="card-body">
        <div class="actions-grid">
            <a href="{{ route('admin.users') }}" class="action-card">
                <div class="action-card-icon" style="background:#EFF6FF;color:#2563EB">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
                Gérer les rôles
            </a>
            <a href="/patients" class="action-card">
                <div class="action-card-icon" style="background:#F0FDFA;color:#0D9488">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                Patients
            </a>
            <a href="{{ route('rendezvous.index') }}" class="action-card">
                <div class="action-card-icon" style="background:#F5F3FF;color:#7C3AED">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/>e x1="16" y1="2" x2="16" y2="6"/>e x1="8" y1="2" x2="8" y2="6"/>e x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                Rendez-Vous
            </a>
            <a href="{{ route('rendezvous.create') }}" class="action-card">
                <div class="action-card-icon" style="background:#ECFDF5;color:#059669">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">ircle cx="12" cy="12" r="10"/>e x1="12" y1="8" x2="12" y2="16"/>e x1="8" y1="12" x2="16" y2="12"/></svg>
                </div>
                Nouveau RDV
            </a>
            <a href="{{ route('rendezvous.calendar') }}" class="action-card">
                <div class="action-card-icon" style="background:#FFFBEB;color:#D97706">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">ircle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                Calendrier
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// [Houcine] Animated stat counters
document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count);
    if (target === 0) return;
    let current = 0;
    const duration = 1000;
    const step = target / (duration / 16);
    const timer = setInterval(() => {
        current += step;
        if (current >= target) { el.textContent = target; clearInterval(timer); }
        else el.textContent = Math.floor(current);
    }, 16);
});
</script>
@endpush