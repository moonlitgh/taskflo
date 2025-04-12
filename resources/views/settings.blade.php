@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="settings-container">
    <h2 class="settings-title">Pengaturan Profil</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="profile-section">
        <div class="profile-picture">
            @if($user->profile_picture)
                <img src="{{ Storage::url('profile_pictures/' . $user->profile_picture) }}" alt="Profile Picture" id="profileImage">
            @else
                <img src="{{ asset('images/default-avatar.png') }}" alt="Default Profile Picture" id="profileImage">
            @endif
        </div>
        <form id="profilePictureForm" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display: none;">
            <button type="button" class="change-photo-btn" onclick="document.getElementById('profile_picture').click()">Ubah Foto</button>
        </form>
    </div>

    <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Pengguna</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password baru">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
        </div>

        <button type="submit" class="btn-save">Simpan Perubahan</button>
    </form>
</div>
@endsection

@push('styles')
<style>
    .settings-container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        min-height: calc(100vh - 110px);
        width: 100%;
    }

    .settings-title {
        color: #333;
        margin-bottom: 2rem;
        font-size: 1.5rem;
        border-bottom: 2px solid #0487FF;
        padding-bottom: 0.5rem;
        display: inline-block;
    }

    .profile-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2rem;
    }

    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-color: #87CEEB;
        margin-bottom: 1rem;
        position: relative;
        overflow: hidden;
    }

    .profile-picture img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .change-photo-btn {
        background-color: #0487FF;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: background-color 0.3s;
    }

    .change-photo-btn:hover {
        background-color: #0371db;
    }

    .form-group {
        margin-bottom: 1.5rem;
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

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .btn-save {
        background-color: #0487FF;
        color: white;
        padding: 0.8rem 2rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s;
    }

    .btn-save:hover {
        background-color: #0371db;
    }

    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profilePictureInput = document.getElementById('profile_picture');
        const profileImage = document.getElementById('profileImage');
        const profilePictureForm = document.getElementById('profilePictureForm');

        profilePictureInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);

                // Upload image
                const formData = new FormData(profilePictureForm);

                fetch('{{ route("settings.update") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Show success message
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success';
                        alertDiv.textContent = data.message;
                        document.querySelector('.settings-container').insertBefore(alertDiv, document.querySelector('.profile-section'));
                        
                        // Remove alert after 3 seconds
                        setTimeout(() => {
                            alertDiv.remove();
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengupload foto profil. Pastikan file yang diupload adalah gambar (JPEG, PNG, JPG) dan ukurannya tidak lebih dari 2MB.');
                });
            }
        });
    });
</script>
@endpush 