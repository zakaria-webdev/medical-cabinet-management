@extends('layouts.app')
@section('page-title', 'Espace Médecin')

@section('content')

<div class="hero-banner hero-medecin">
    <div class="hero-banner-content">
        <h1>Dr. {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</h1>
        <p>Bonne journée — consultez votre planning du {{ now()->format('d F Y') }}</p>
    </div>
    <svg class="hero-illustration" viewBox="0 0 200 200" fill="white">
        ircle cx="100" cy="60" r="35" fill-opacity="0.4"/>
        <path d="M60 200 Q100 140 140 200" fill-opacity="0.3"/>
        <rect x="88" y="30" width="8" height="60" rx="3" fill-opacity="0.6"/>
        <rect x="68" y="50" width="48" height="8" rx="3" fill-opacity="0.6"/>
    </svg>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon teal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/>e x1="16" y1="2" x2="16" y2="6"/>e x1="8" y1="2" x2="8" y2="6"/>e x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <div class="stat-label">RDV Aujourd'hui</div>
            @php
                $medecinId = auth()->id();
                $rdvToday = \App\Models\RendezVous::where('medecin_id', $medecinId)->whereDate('date_rdv', today())->count();
            @endphp
            <div class="stat-value" data-count="{{ $rdvToday }}">0</div>
            <div class="stat-delta up">Planning du jour</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <div class="stat-label">Mes Patients</div>
            @php $totalPatients = \App\Models\RendezVous::where('medecin_id', $medecinId)->distinct('patient_id')->count('patient_id'); @endphp
            <div class="stat-value" data-count="{{ $totalPatients }}">0</div>
            <div class="stat-delta neutral">Patients suivis</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="stat-label">RDV Confirmés</div>
            @php $confirmed = \App\Models\RendezVous::where('medecin_id', $medecinId)->where('statut', 'confirme')->count(); @endphp
            <div class="stat-value" data-count="{{ $confirmed }}">0</div>
            <div class="stat-delta up">↑ Ce mois</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon violet">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
        </div>
        <div>
            <div class="stat-label">Consultations</div>
            @php $consults = \App\Models\Consultation::where('medecin_id', $medecinId)->count() ?? 0; @endphp
            <div class="stat-value" data-count="{{ $consults }}">0</div>
            <div class="stat-delta neutral">Total</div>
        </div>
    </div>
</div>

<div class="actions-grid" style="grid-template-columns: repeat(auto-fit, minmax(140px,1fr))">
    <a href="{{ route('rendezvous.index') }}" class="action-card">
        <div class="action-card-icon" style="background:#F0FDFA;color:#0D9488"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/>e x1="16" y1="2" x2="16" y2="6"/>e x1="8" y1="2" x2="8" y2="6"/>e x1="3" y1="10" x2="21" y2="10"/></svg></div>
        Mes RDV
    </a>
    <a href="{{ route('rendezvous.calendar') }}" class="action-card">
        <div class="action-card-icon" style="background:#FFFBEB;color:#D97706"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">ircle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        Calendrier
    </a>
    <a href="/patients" class="action-card">
        <div class="action-card-icon" style="background:#EFF6FF;color:#2563EB"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
        Patients
    </a>
    <a href="{{ route('consultations.create') }}" class="action-card">
        <div class="action-card-icon" style="background:#ECFDF5;color:#059669"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">ircle cx="12" cy="12" r="10"/>e x1="12" y1="8" x2="12" y2="16"/>e x1="8" y1="12" x2="16" y2="12"/></svg></div>
        Nouvelle Consultation
    </a>
    <a href="{{ route('consultations.index') }}" class="action-card">
        <div class="action-card-icon" style="background:#F5F3FF;color:#7C3AED"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12"/></svg></div>
        Historique
    </a>
    <a href="{{ route('dossiers.index') }}" class="action-card">
        <div class="action-card-icon" style="background:#FFF1F2;color:#E11D48"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/></svg></div>
        Dossiers
    </a>
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count);
    if (target === 0) return;
    let c = 0; const step = target / 60;
    const t = setInterval(() => { c += step; if(c>=target){el.textContent=target;clearInterval(t);}else el.textContent=Math.floor(c); }, 16);
});
</script>
@endpush