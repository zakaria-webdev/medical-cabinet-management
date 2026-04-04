@extends('layouts.app')
@section('content')
    {{-- [Houcine] Dashboard temporaire → sera remplacé en Sprint 2/3 --}}
    <h2>Bienvenue, {{ auth()->user()->prenom }} !</h2>
    <p>Tableau de bord patient.</p>
@endsection
