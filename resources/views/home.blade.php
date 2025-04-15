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

<div class="calendar">
    <div class="calendar-header">
        <button class="calendar-nav" id="prevMonth">&lt;</button>
        <h3 class="calendar-title" id="currentMonth"></h3>
        <button class="calendar-nav" id="nextMonth">&gt;</button>
    </div>
    <div class="calendar-grid">
        <div class="calendar-day header">Sun</div>
        <div class="calendar-day header">Mon</div>
        <div class="calendar-day header">Tue</div>
        <div class="calendar-day header">Wed</div>
        <div class="calendar-day header">Thu</div>
        <div class="calendar-day header">Fri</div>
        <div class="calendar-day header">Sat</div>
    </div>
</div>

<!-- Task Popup -->
<div id="taskPopup" class="task-popup">
    <div class="task-popup-content">
        <span class="close-popup">&times;</span>
        <h3 class="popup-date"></h3>
        <div class="task-list"></div>
    </div>
</div>
@endsection

@push('styles')
<style>
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

    .calendar {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .calendar-nav {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 5px 10px;
        color: #0487FF;
    }

    .calendar-title {
        font-size: 1.2rem;
        font-weight: 500;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }

    .calendar-day {
        text-align: center;
        padding: 10px;
        border: 1px solid #eee;
    }

    .calendar-day.header {
        font-weight: bold;
        border: none;
        color: #0487FF;
        padding: 10px;
        margin-bottom: 10px;
    }

    .calendar-day.today {
        background-color: #0487FF;
        color: white;
        border-radius: 5px;
    }

    .calendar-day.other-month {
        color: #ccc;
    }

    .calendar-day:not(.header) {
        border-radius: 5px;
        cursor: pointer;
    }

    .calendar-day:not(.header):hover {
        background-color: #f0f9ff;
    }

    .calendar-day.has-task {
        background-color: #FF4444;
        color: white;
        border-radius: 5px;
    }

    .calendar-day.today.has-task {
        background-color: #0487FF;
        border: 2px solid #FF4444;
    }

    /* Task Popup Styles */
    .task-popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1000;
    }

    .task-popup-content {
        position: relative;
        background-color: white;
        margin: 10% auto;
        padding: 20px;
        width: 80%;
        max-width: 500px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .close-popup {
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        color: #666;
    }

    .close-popup:hover {
        color: #000;
    }

    .popup-date {
        margin-bottom: 20px;
        color: #0487FF;
    }

    .task-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .task-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    .task-item:last-child {
        border-bottom: none;
    }

    .task-title {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .task-description {
        color: #666;
        font-size: 0.9rem;
    }

    .task-meta {
        margin-top: 8px;
        display: flex;
        gap: 10px;
    }

    .task-status, .task-priority {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8em;
        font-weight: bold;
    }

    .status-delay {
        background-color: #ff4444;
        color: white;
    }

    .status-on-progress {
        background-color: #ffbb33;
        color: white;
    }

    .status-done {
        background-color: #00C851;
        color: white;
    }

    .priority-high {
        background-color: #ff4444;
        color: white;
    }

    .priority-medium {
        background-color: #ffbb33;
        color: white;
    }

    .priority-low {
        background-color: #00C851;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
class Calendar {
    constructor() {
        this.date = new Date();
        this.currentMonth = this.date.getMonth();
        this.currentYear = this.date.getFullYear();
        
        this.monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];
        
        this.tasks = @json($tasks ?? []);
        console.log('Tasks loaded:', this.tasks);
        
        this.setupEventListeners();
        this.renderCalendar();
    }

    hasTask(year, month, day) {
        // Format the date to match database format (YYYY-MM-DD)
        const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        console.log('Checking for tasks on date:', dateString);
        
        const taskFound = this.tasks.some(task => {
            console.log('Comparing with task date:', task.date);
            return task.date === dateString;
        });
        
        console.log('Task found:', taskFound);
        return taskFound;
    }

    getTasksForDate(year, month, day) {
        const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        console.log('Getting tasks for date:', dateString);
        return this.tasks.filter(task => task.date === dateString);
    }

    showTaskPopup(tasks, date) {
        const popup = document.getElementById('taskPopup');
        const popupDate = popup.querySelector('.popup-date');
        const taskList = popup.querySelector('.task-list');
        
        popupDate.textContent = date;
        taskList.innerHTML = '';
        
        if (tasks.length === 0) {
            taskList.innerHTML = '<p>No tasks for this date</p>';
        } else {
            tasks.forEach(task => {
                const taskItem = document.createElement('div');
                taskItem.className = 'task-item';
                
                // Add status and priority classes
                const statusClass = `status-${task.status.replace(' ', '-')}`;
                const priorityClass = `priority-${task.priority}`;
                
                taskItem.innerHTML = `
                    <div class="task-title">${task.title}</div>
                    <div class="task-description">${task.description}</div>
                    <div class="task-meta">
                        <span class="task-status ${statusClass}">${task.status}</span>
                        <span class="task-priority ${priorityClass}">${task.priority}</span>
                    </div>
                `;
                taskList.appendChild(taskItem);
            });
        }
        
        popup.style.display = 'block';
    }

    setupEventListeners() {
        document.getElementById('prevMonth').addEventListener('click', () => {
            this.currentMonth--;
            if (this.currentMonth < 0) {
                this.currentMonth = 11;
                this.currentYear--;
            }
            this.renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            this.currentMonth++;
            if (this.currentMonth > 11) {
                this.currentMonth = 0;
                this.currentYear++;
            }
            this.renderCalendar();
        });

        document.querySelector('.close-popup').addEventListener('click', () => {
            document.getElementById('taskPopup').style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            const popup = document.getElementById('taskPopup');
            if (event.target === popup) {
                popup.style.display = 'none';
            }
        });
    }

    renderCalendar() {
        const firstDay = new Date(this.currentYear, this.currentMonth, 1);
        const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
        const startingDay = firstDay.getDay();
        const totalDays = lastDay.getDate();
        
        document.getElementById('currentMonth').textContent = 
            `${this.monthNames[this.currentMonth]} ${this.currentYear}`;

        const calendarGrid = document.querySelector('.calendar-grid');
        const headerRow = calendarGrid.innerHTML.split('</div>').slice(0, 7).join('</div>') + '</div>';
        calendarGrid.innerHTML = headerRow;

        // Add previous month days
        const prevMonthLastDay = new Date(this.currentYear, this.currentMonth, 0).getDate();
        for (let i = startingDay - 1; i >= 0; i--) {
            const day = document.createElement('div');
            day.className = 'calendar-day other-month';
            day.textContent = prevMonthLastDay - i;
            calendarGrid.appendChild(day);
        }

        // Add current month days
        const today = new Date();
        for (let i = 1; i <= totalDays; i++) {
            const day = document.createElement('div');
            day.className = 'calendar-day';
            
            if (this.currentYear === today.getFullYear() && 
                this.currentMonth === today.getMonth() && 
                i === today.getDate()) {
                day.classList.add('today');
            }
            
            const hasTask = this.hasTask(this.currentYear, this.currentMonth, i);
            if (hasTask) {
                day.classList.add('has-task');
                console.log('Marking day as has-task:', i);
            }
            
            day.textContent = i;
            
            day.addEventListener('click', () => {
                const tasks = this.getTasksForDate(this.currentYear, this.currentMonth, i);
                const date = `${this.monthNames[this.currentMonth]} ${i}, ${this.currentYear}`;
                this.showTaskPopup(tasks, date);
            });
            
            calendarGrid.appendChild(day);
        }

        // Add next month days
        const remainingDays = 42 - (startingDay + totalDays);
        for (let i = 1; i <= remainingDays; i++) {
            const day = document.createElement('div');
            day.className = 'calendar-day other-month';
            day.textContent = i;
            calendarGrid.appendChild(day);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new Calendar();
});
</script>
@endpush 