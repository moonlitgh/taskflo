@extends('layouts.app')

@section('title', 'Calendar')

@section('content')
<div class="calendar-container">
    <h1>Task Calendar</h1>
    <div id="calendar"></div>
</div>

<!-- Task Modal -->
<div class="modal" id="taskModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tasks for <span id="selectedDate"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="taskList">
                <!-- Tasks will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
<style>
    .calendar-container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    #calendar {
        margin-top: 20px;
    }
    
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }
    
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        border-radius: 10px;
    }
    
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }
    
    .task-item {
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 12px;
        margin-top: 5px;
    }
    
    .status-badge.completed {
        background-color: #28a745;
        color: white;
    }
    
    .status-badge.pending {
        background-color: #ffc107;
        color: black;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            const tasksByDate = @json($tasksByDate ?? []);
            
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: generateEvents(tasksByDate),
                eventClick: function(info) {
                    showTasksForDate(info.event.startStr);
                },
                dateClick: function(info) {
                    showTasksForDate(info.dateStr);
                }
            });
            
            calendar.render();
            
            function generateEvents(tasksByDate) {
                const events = [];
                
                for (const date in tasksByDate) {
                    events.push({
                        title: `${tasksByDate[date].length} Task(s)`,
                        start: date,
                        allDay: true,
                        backgroundColor: '#0487FF',
                        borderColor: '#0487FF'
                    });
                }
                
                return events;
            }
            
            function showTasksForDate(date) {
                document.getElementById('selectedDate').textContent = new Date(date).toLocaleDateString();
                
                fetch(`/calendar/tasks?date=${date}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(tasks => {
                        const taskList = document.getElementById('taskList');
                        taskList.innerHTML = '';
                        
                        if (tasks.length === 0) {
                            taskList.innerHTML = '<p>No tasks for this date.</p>';
                            return;
                        }
                        
                        const list = document.createElement('div');
                        list.className = 'task-list';
                        
                        tasks.forEach(task => {
                            const item = document.createElement('div');
                            item.className = 'task-item';
                            
                            const title = document.createElement('h4');
                            title.textContent = task.title;
                            
                            const description = document.createElement('p');
                            description.textContent = task.description || 'No description';
                            
                            const status = document.createElement('span');
                            status.className = `status-badge ${task.is_completed ? 'completed' : 'pending'}`;
                            status.textContent = task.is_completed ? 'Completed' : 'Pending';
                            
                            item.appendChild(title);
                            item.appendChild(description);
                            item.appendChild(status);
                            
                            list.appendChild(item);
                        });
                        
                        taskList.appendChild(list);
                        
                        // Show modal
                        document.getElementById('taskModal').style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error fetching tasks:', error);
                        const taskList = document.getElementById('taskList');
                        taskList.innerHTML = '<p>Error loading tasks. Please try again later.</p>';
                        document.getElementById('taskModal').style.display = 'block';
                    });
            }
            
            // Close modal when clicking the close button
            document.querySelector('.close').addEventListener('click', function() {
                document.getElementById('taskModal').style.display = 'none';
            });
            
            // Close modal when clicking outside of it
            window.addEventListener('click', function(event) {
                const modal = document.getElementById('taskModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        } catch (error) {
            console.error('Calendar initialization error:', error);
            document.getElementById('calendar').innerHTML = '<div class="alert alert-danger">Error loading calendar. Please refresh the page or try again later.</div>';
        }
    });
</script>
@endpush