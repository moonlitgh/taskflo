@extends('layouts.app')

@section('title', 'Tugas')

@section('content')
<!-- Add this meta tag right after the content section starts -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="tasks-container">
    <h2 class="tasks-title">Daftar Tugas</h2>
    
    <div class="tasks-filters">
        <div class="filter-group">
            <label>Status</label>
            <select class="form-control" id="status-filter">
                <option value="all">All</option>
                <option value="delay">Delay</option>
                <option value="process">Process</option>
                <option value="done">Done</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label>Priority</label>
            <select class="form-control" id="priority-filter">
                <option value="all">All</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>
        </div>
    </div>

    <div class="tasks-list-container">
        <div class="tasks-list" id="tasks-list">
            @foreach($tasks as $task)
            <div class="task-card" 
                 data-status="{{ $task->status }}" 
                 data-priority="{{ $task->priority }}"
                 data-task-id="{{ $task->id }}">
                <div class="task-header">
                    <div class="task-checkbox">
                        <input type="checkbox" 
                               class="task-status-checkbox" 
                               data-task-id="{{ $task->id }}"
                               {{ $task->status === 'done' ? 'checked' : '' }}>
                    </div>
                    <h3 class="task-title">{{ $task->title }}</h3>
                    <span class="task-priority priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                </div>
                
                <div class="task-body">
                    <p class="task-description">{{ $task->description }}</p>
                    <div class="task-meta">
                        <span class="task-due-date">Due: {{ $task->due_date->format('d M Y') }}</span>
                        <span class="task-status status-{{ $task->status }}">{{ ucfirst($task->status) }}</span>
                    </div>
                </div>
                
                <div class="task-actions">
                    <button class="btn-edit" data-task-id="{{ $task->id }}">Edit</button>
                    <button class="btn-delete" data-task-id="{{ $task->id }}">Delete</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="pagination">
        @for($i = 1; $i <= ceil($tasks->count() / 5); $i++)
            <button class="page-btn {{ $i === 1 ? 'active' : '' }}" data-page="{{ $i }}">{{ $i }}</button>
        @endfor
    </div>
</div>

<!-- Edit Task Modal -->
<div id="editTaskModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit Task</h3>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editTaskForm" class="modal-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Due Date</label>
                    <input type="date" name="due_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Priority</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" name="priority" id="edit-high" value="high" required>
                            <label for="edit-high" class="priority-high">High</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" name="priority" id="edit-medium" value="medium">
                            <label for="edit-medium" class="priority-medium">Medium</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" name="priority" id="edit-low" value="low">
                            <label for="edit-low" class="priority-low">Low</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel">Cancel</button>
            <button type="submit" form="editTaskForm" class="btn-save">Save</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .tasks-container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        min-height: calc(100vh - 110px);
        width: 100%;
    }

    .tasks-title {
        color: #333;
        margin-bottom: 2rem;
        font-size: 1.5rem;
        border-bottom: 2px solid #0487FF;
        padding-bottom: 0.5rem;
        display: inline-block;
    }

    .tasks-filters {
        display: flex;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .filter-group {
        flex: 1;
    }

    .filter-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #333;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 0.8rem;
        border: 2px solid #87CEEB;
        border-radius: 5px;
        font-size: 1rem;
    }

    .tasks-list-container {
        max-height: 600px;
        overflow-y: auto;
        margin-bottom: 1rem;
        padding-right: 0.5rem;
    }

    .tasks-list-container::-webkit-scrollbar {
        width: 8px;
    }

    .tasks-list-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .tasks-list-container::-webkit-scrollbar-thumb {
        background: #87CEEB;
        border-radius: 4px;
    }

    .tasks-list-container::-webkit-scrollbar-thumb:hover {
        background: #70b4d3;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .page-btn {
        padding: 0.5rem 1rem;
        border: 1px solid #87CEEB;
        background-color: white;
        color: #333;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .page-btn:hover {
        background-color: #f0f8ff;
    }

    .page-btn.active {
        background-color: #87CEEB;
        color: white;
        border-color: #87CEEB;
    }

    .task-card {
        background-color: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-left: 4px solid #87CEEB;
        margin-bottom: 1rem;
    }

    .task-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .task-checkbox {
        display: flex;
        align-items: center;
    }

    .task-status-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .task-title {
        flex: 1;
        font-size: 1.2rem;
        color: #333;
        margin: 0;
    }

    .task-body {
        margin-bottom: 1rem;
    }

    .task-description {
        color: #666;
        margin-bottom: 1rem;
    }

    .task-meta {
        display: flex;
        justify-content: space-between;
        color: #666;
        font-size: 0.9rem;
    }

    .task-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-edit, .btn-delete {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: background-color 0.3s;
    }

    .btn-edit {
        background-color: #0487FF;
        color: white;
    }

    .btn-edit:hover {
        background-color: #0376e0;
    }

    .btn-delete {
        background-color: #FF4444;
        color: white;
    }

    .btn-delete:hover {
        background-color: #ff2929;
    }

    /* Modal styles */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: none;
        justify-content: center;
        align-items: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background-color: white;
        border-radius: 10px;
        width: 90%;
        max-width: 600px;
        max-height: 80vh;
        position: relative;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #eee;
        background-color: #87CEEB;
        border-radius: 10px 10px 0 0;
        color: white;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 500;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: white;
    }

    .modal-body {
        padding: 2rem;
        overflow-y: auto;
        max-height: calc(80vh - 140px);
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.8rem;
        color: #333;
        font-weight: 500;
        font-size: 1rem;
    }

    .form-control {
        width: 100%;
        padding: 0.8rem;
        border: 2px solid #87CEEB;
        border-radius: 5px;
        font-size: 1rem;
    }

    .form-control:focus {
        outline: none;
        border-color: #0487FF;
        box-shadow: 0 0 0 2px rgba(4, 135, 255, 0.1);
    }

    .radio-group {
        display: flex;
        gap: 2rem;
        margin-top: 0.5rem;
    }

    .radio-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        border-top: 1px solid #eee;
        background-color: white;
        border-radius: 0 0 10px 10px;
    }

    .btn-cancel {
        background-color: #ddd;
        color: #666;
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-save {
        background-color: #87CEEB;
        color: white;
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-save:hover {
        background-color: #70b4d3;
    }

    /* Status colors */
    .status-delay { 
        color: #FF4444; 
    }
    .status-delay::before { 
        content: "•";
        color: #FF4444;
        margin-right: 8px;
        font-size: 24px;
        line-height: 0;
        vertical-align: middle;
    }

    .status-process { 
        color: #FFA500; 
    }
    .status-process::before { 
        content: "•";
        color: #FFA500;
        margin-right: 8px;
        font-size: 24px;
        line-height: 0;
        vertical-align: middle;
    }

    .status-done { 
        color: #4CAF50; 
    }
    .status-done::before { 
        content: "•";
        color: #4CAF50;
        margin-right: 8px;
        font-size: 24px;
        line-height: 0;
        vertical-align: middle;
    }

    /* Priority colors */
    .priority-high { 
        color: #FF4444; 
    }
    .priority-high::before { 
        content: "•";
        color: #FF4444;
        margin-right: 8px;
        font-size: 24px;
        line-height: 0;
        vertical-align: middle;
    }

    .priority-medium { 
        color: #FFA500; 
    }
    .priority-medium::before { 
        content: "•";
        color: #FFA500;
        margin-right: 8px;
        font-size: 24px;
        line-height: 0;
        vertical-align: middle;
    }

    .priority-low { 
        color: #4CAF50; 
    }
    .priority-low::before { 
        content: "•";
        color: #4CAF50;
        margin-right: 8px;
        font-size: 24px;
        line-height: 0;
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('status-filter');
        const priorityFilter = document.getElementById('priority-filter');
        const tasksList = document.getElementById('tasks-list');
        const taskCards = tasksList.getElementsByClassName('task-card');
        const pageButtons = document.querySelectorAll('.page-btn');
        const tasksPerPage = 5;
        let currentPage = 1;
        const modal = document.getElementById('editTaskModal');
        const closeButton = modal.querySelector('.close-modal');
        const cancelButton = modal.querySelector('.btn-cancel');
        const editForm = document.getElementById('editTaskForm');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Add event listener for status checkboxes
        document.querySelectorAll('.task-status-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const taskId = this.getAttribute('data-task-id');
                const isChecked = this.checked;
                const status = isChecked ? 'done' : 'process';
                
                fetch(`/tasks/${taskId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        _method: 'PUT',
                        status: status 
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const taskCard = this.closest('.task-card');
                        taskCard.setAttribute('data-status', status);
                        
                        const statusSpan = taskCard.querySelector('.task-status');
                        statusSpan.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        statusSpan.className = `task-status status-${status}`;
                        
                        filterTasks();
                    } else {
                        throw new Error(data.message || 'Failed to update status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update task status');
                    // Revert checkbox state
                    this.checked = !isChecked;
                });
            });
        });

        function showPage(page) {
            const start = (page - 1) * tasksPerPage;
            const end = start + tasksPerPage;

            Array.from(taskCards).forEach((card, index) => {
                card.style.display = (index >= start && index < end) ? 'block' : 'none';
            });

            // Update active page button
            pageButtons.forEach(btn => {
                btn.classList.remove('active');
                if (parseInt(btn.dataset.page) === page) {
                    btn.classList.add('active');
                }
            });

            currentPage = page;
        }

        function filterTasks() {
            const selectedStatus = statusFilter.value;
            const selectedPriority = priorityFilter.value;
            let visibleTasks = 0;

            Array.from(taskCards).forEach(card => {
                const cardStatus = card.dataset.status;
                const cardPriority = card.dataset.priority;

                const statusMatch = selectedStatus === 'all' || cardStatus === selectedStatus;
                const priorityMatch = selectedPriority === 'all' || cardPriority === selectedPriority;

                if (statusMatch && priorityMatch) {
                    card.style.display = 'block';
                    visibleTasks++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update pagination
            const totalPages = Math.ceil(visibleTasks / tasksPerPage);
            const paginationContainer = document.querySelector('.pagination');
            paginationContainer.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.className = `page-btn ${i === 1 ? 'active' : ''}`;
                button.dataset.page = i;
                button.textContent = i;
                button.addEventListener('click', () => showPage(i));
                paginationContainer.appendChild(button);
            }

            showPage(1);
        }

        statusFilter.addEventListener('change', filterTasks);
        priorityFilter.addEventListener('change', filterTasks);

        // Initialize pagination
        pageButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                showPage(parseInt(btn.dataset.page));
            });
        });

        // Show first page initially
        showPage(1);

        function closeModal() {
            modal.classList.remove('show');
        }

        closeButton.addEventListener('click', closeModal);
        cancelButton.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Edit button click handler
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-edit')) {
                const taskId = e.target.getAttribute('data-task-id');
                handleEditTask(taskId);
            } else if (e.target.classList.contains('btn-delete')) {
                const taskId = e.target.getAttribute('data-task-id');
                handleDeleteTask(taskId);
            }
        });

        async function handleEditTask(taskId) {
            try {
                const response = await fetch(`/tasks/${taskId}`);
                if (!response.ok) throw new Error('Network response was not ok');
                
                const task = await response.json();
                
                editForm.action = `/tasks/${taskId}`;
                editForm.querySelector('[name="title"]').value = task.title || '';
                editForm.querySelector('[name="description"]').value = task.description || '';
                editForm.querySelector('[name="due_date"]').value = task.due_date.split('T')[0];
                editForm.querySelector(`[name="priority"][value="${task.priority}"]`).checked = true;
                
                modal.classList.add('show');
            } catch (error) {
                console.error('Error fetching task:', error);
                alert('Failed to load task data');
            }
        }

        // Update delete handler
        function handleDeleteTask(taskId) {
            if (confirm('Are you sure you want to delete this task?')) {
                fetch(`/tasks/${taskId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const taskCard = document.querySelector(`.task-card[data-task-id="${taskId}"]`);
                        if (taskCard) {
                            taskCard.remove();
                            filterTasks();
                        }
                    } else {
                        throw new Error(data.message || 'Failed to delete task');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to delete task');
                });
            }
        }

        // Update edit form submission
        editForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('_method', 'PUT');

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();
                
                if (data.success) {
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Failed to update task');
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message || 'Failed to save changes');
            }
        });
    });
</script>
@endpush