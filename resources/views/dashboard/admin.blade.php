@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #0f2c4c;">
                🛡️ Tableau de bord Admin
            </h2>
            <p class="text-muted mt-2 fs-5">
                Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
            </p>
        </div>
    </div>

    {{-- ===== KPI Cards (الأرقام الكبيرة) ===== --}}
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <div class="text-primary fs-1 fw-bold">{{ $totalPatients }}</div>
                <div class="text-muted">Total Patients</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <div class="text-success fs-1 fw-bold">{{ $appointmentsByStatus['confirmé'] ?? 0 }}</div>
                <div class="text-muted">RDV Confirmés</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <div class="text-danger fs-1 fw-bold">{{ $appointmentsByStatus['annulé'] ?? 0 }}</div>
                <div class="text-muted">RDV Annulés</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <div class="text-warning fs-1 fw-bold">{{ $totalRdv }}</div>
                <div class="text-muted">Total RDV</div>
            </div>
        </div>
    </div>

    {{-- ===== Graphiques Chart.js ===== --}}
    <div class="row g-4 mb-5">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">📊 Rendez-vous par mois ({{ date('Y') }})</h5>
                <canvas id="barChart" height="100"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">🥧 Statuts des RDV</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== Boutons de navigation (الكود القديم محتفظ بيه) ===== --}}
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-users-cog fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Utilisateurs & Rôles</h5>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary rounded-pill w-100">Gérer les rôles</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect">
                <div class="card-body p-4 text-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-hospital-user fa-2x text-info"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Patients</h5>
                    <a href="/patients" class="btn btn-sm btn-outline-info rounded-pill w-100">Voir les patients</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-effect">
                <div class="card-body p-4 text-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-calendar-alt fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Rendez-vous</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('rendezvous.index') }}" class="btn btn-sm btn-success rounded-pill">Gérer les RDV</a>
                        <a href="{{ route('rendezvous.create') }}" class="btn btn-sm btn-outline-success rounded-pill">+ Nouveau RDV</a>
                        <a href="{{ route('rendezvous.calendar') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Calendrier</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthlyData = @json($monthlyData);
    const statusData  = @json($appointmentsByStatus);

    // Bar Chart — المواعيد بالشهر
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
            datasets: [{
                label: 'Rendez-vous',
                data: monthlyData,
                backgroundColor: 'rgba(13, 110, 253, 0.6)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Pie Chart — الحالات
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: Object.keys(statusData),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: ['#ffc107','#198754','#dc3545','#0dcaf0']
            }]
        },
        options: { responsive: true }
    });
</script>

@push('styles')
<style>
    .hover-effect { transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
    .hover-effect:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
</style>
@endpush

@endsection