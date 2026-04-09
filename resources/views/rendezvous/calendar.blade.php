@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Calendrier des rendez-vous</h2>
        <a href="{{ route('rendezvous.index') }}" class="btn btn-outline-secondary">
            Voir liste
        </a>
    </div>
    <div id="calendar"></div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cal = new FullCalendar.Calendar(
        document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '{{ route("rendezvous.calendar.data") }}',
            eventClick: function(info) {
                window.location.href = info.event.url;
                info.jsEvent.preventDefault();
            },
            businessHours: { daysOfWeek:[1,2,3,4,5], startTime:'08:00', endTime:'18:00' }
        }
    );
    cal.render();
});
</script>
@endpush