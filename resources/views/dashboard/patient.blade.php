@extends('layouts.app')

@section('content')

{{-- [Houcine] Dashboard Patient - cahier des charges: patient peut prendre RDV en ligne --}}
<h2>Bienvenue, {{ auth()->user()->prenom }} !</h2>
<p class="text-muted">Tableau de bord patient.</p>

<hr>

<div class="d-flex flex-wrap gap-2 mt-3">
    <a href="{{ route('rendezvous.create') }}" class="btn btn-primary">
        ➕ Prendre un Rendez-Vous
    </a>
    <a href="{{ route('rendezvous.index') }}" class="btn btn-outline-success">
        📅 Mes Rendez-Vous
    </a>
</div>

@endsection