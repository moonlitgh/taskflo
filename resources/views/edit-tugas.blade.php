@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')
<div class="form-container">
    <h2 class="form-title">Edit Tugas</h2>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
        </div>

        <div class="form-group">
            <label>Tenggat Waktu</label>
            <input type="date" name="due_date" class="form-control" value="{{ $task->due_date->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label>Priority</label>
            <div class="radio-group">
                <div class="radio-item">
                    <input type="radio" name="priority" id="high" value="high" {{ $task->priority === 'high' ? 'checked' : '' }} required>
                    <label for="high" class="priority-high">High</label>
                </div>
                <div class="radio-item">
                    <input type="radio" name="priority" id="medium" value="medium" {{ $task->priority === 'medium' ? 'checked' : '' }}>
                    <label for="medium" class="priority-medium">Medium</label>
                </div>
                <div class="radio-item">
                    <input type="radio" name="priority" id="low" value="low" {{ $task->priority === 'low' ? 'checked' : '' }}>
                    <label for="low" class="priority-low">Low</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control">{{ $task->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="process" {{ $task->status === 'process' ? 'selected' : '' }}>Dalam Proses</option>
                <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Selesai</option>
                <option value="delay" {{ $task->status === 'delay' ? 'selected' : '' }}>Terlambat</option>
            </select>
        </div>

        <div class="form-actions">
            <a href="{{ route('tugas') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .form-container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        min-height: calc(100vh - 110px);
        width: 100%;
    }

    .form-title {
        color: #333;
        margin-bottom: 2rem;
        font-size: 1.5rem;
        border-bottom: 2px solid #0487FF;
        padding-bottom: 0.5rem;
        display: inline-block;
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-group label {
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
        min-height: 200px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-cancel {
        background-color: #ddd;
        color: #666;
        padding: 0.8rem 2rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        text-decoration: none;
        text-align: center;
    }

    .btn-submit {
        background-color: #0487FF;
        color: white;
        padding: 0.8rem 2rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #0376e0;
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