@extends('layouts.app')

@section('title', 'Tambah Tugas')

@section('content')
<div class="form-container">
    <h2 class="form-title">Tambah Tugas Baru</h2>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="title" class="form-control" placeholder="Masukkan judul tugas" required>
        </div>

        <div class="form-group">
            <label>Tenggat Waktu</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Priority</label>
            <div class="radio-group">
                <div class="radio-item">
                    <input type="radio" name="priority" id="high" value="high" required>
                    <label for="high" class="priority-high">High</label>
                </div>
                <div class="radio-item">
                    <input type="radio" name="priority" id="medium" value="medium" checked>
                    <label for="medium" class="priority-medium">Medium</label>
                </div>
                <div class="radio-item">
                    <input type="radio" name="priority" id="low" value="low">
                    <label for="low" class="priority-low">Low</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Task Description</label>
            <textarea name="description" class="form-control" placeholder="Masukkan deskripsi tugas"></textarea>
        </div>

        <button type="submit" class="btn-submit">Simpan</button>
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
        width: fit-content;
    }

    .form-control {
        width: 100%;
        padding: 1rem;
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

    .radio-item label {
        border-bottom: none;
        padding-bottom: 0;
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

    textarea.form-control {
        min-height: 200px;
        resize: vertical;
    }

    .btn-submit {
        background-color: #FF4444;
        color: white;
        padding: 0.8rem 2rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #ff2929;
    }
</style>
@endpush 