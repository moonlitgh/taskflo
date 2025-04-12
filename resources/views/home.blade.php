@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2>Dashboard</h2>
<div class="stats-container">
    <div class="stat-card">
        <h3>Total Tasks</h3>
        <p>{{ $totalTasks }}</p>
    </div>
    <div class="stat-card">
        <h3>Completed</h3>
        <p>{{ $doneTasks }}</p>
    </div>
    <div class="stat-card">
        <h3>Delayed</h3>
        <p>{{ $delayTasks }}</p>
    </div>
</div>

{{-- Placeholder for the new calendar --}}
<div id='calendar'></div>

@endsection

@push('styles')
{{-- FullCalendar CSS --}}
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/main.min.css' rel='stylesheet' />
<style>
    /* Keep existing styles for stats cards */
    .stats-container {
        display: flex;
        gap: 20px;
        margin-bottom: 2rem;
    }

    .stat-card {
        flex: 1;
        background-color: #87CEEB;
        padding: 1.5rem;
        border-radius: 10px;
        color: white;
    }

    .stat-card h3 {
        margin-bottom: 10px;
        font-size: 1.2rem;
    }

    .stat-card p {
        font-size: 2rem;
        font-weight: bold;
    }

    /* Basic styling for the new calendar container */
    #calendar {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-top: 2rem; /* Add some space above the calendar */
    }

    /* Optional: Style FullCalendar events */
    .fc-event {
        cursor: pointer;
        border: none !important; /* Override default border if needed */
    }
    /* You can add more specific event styling based on status/priority later */
    .fc-event-main {
        padding: 4px 6px;
        font-size: 0.85em;
        line-height: 1.3;
    }

</style>
@endpush

@push('scripts')
{{-- FullCalendar JS --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/main.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    // Get tasks data from PHP
    const tasksData = @json($tasks ?? []);
    console.log('Tasks data for FullCalendar:', tasksData);

    // Map tasks data to FullCalendar event format
    const calendarEvents = tasksData.map(task => {
        // Basic validation
        if (!task.date || !task.title) {
            console.warn('Skipping task due to missing date or title:', task);
            return null; // Skip invalid tasks
        }
        return {
            title: task.title,
            start: task.date, // FullCalendar uses 'start' for the date
            allDay: true, // Assume tasks are all-day events for now
            extendedProps: { // Store extra data here
                description: task.description,
                status: task.status,
                priority: task.priority
            },
            // Optional: Add coloring based on status/priority later
            // color: getEventColor(task.status, task.priority)
        };
    }).filter(event => event !== null); // Remove null entries

    console.log('Formatted events for FullCalendar:', calendarEvents);

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // Default view
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek' // Add more views if needed
        },
        events: calendarEvents, // Load events
        eventClick: function(info) {
            // Basic alert on click - replace with a proper modal/popup later
            const task = info.event.extendedProps;
            const title = info.event.title;
            alert(
                `Task: ${title}\n` +
                `Date: ${info.event.start.toLocaleDateString()}\n` +
                `Description: ${task.description || 'N/A'}\n` +
                `Status: ${task.status}\n` +
                `Priority: ${task.priority}`
            );
        },
        // Optional: More configuration can be added here
        // editable: true, // If you want drag-and-drop
        // dayMaxEvents: true, // allow "more" link when too many events
    });

    calendar.render();
});
</script>
@endpush 