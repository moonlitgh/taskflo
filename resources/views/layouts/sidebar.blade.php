<div class="sidebar">
    <div class="user-info">
        <div class="avatar">
            @if($user->profile_picture)
                <img src="{{ Storage::url('profile_pictures/' . $user->profile_picture) }}" alt="Profile Picture" class="profile-image">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>
        <div class="user-details">
            <span class="username">{{ $user->name }}</span>
            <span class="email">{{ $user->email }}</span>
        </div>
    </div>

    <div class="menu-items">
        <div class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">
                <i class="icon">📊</i>
                Dashboard
            </a>
        </div>
        <div class="menu-item {{ request()->routeIs('tambah-tugas') ? 'active' : '' }}">
            <a href="{{ route('tambah-tugas') }}" style="text-decoration: none; color: inherit;">
                <i class="icon">➕</i>
                Tambah Tugas
            </a>
        </div>
        <div class="menu-item {{ request()->routeIs('tugas') ? 'active' : '' }}">
            <a href="{{ route('tugas') }}" style="text-decoration: none; color: inherit;">
                <i class="icon">📝</i>
                Tugas
            </a>
        </div>
        <div class="menu-item {{ request()->routeIs('settings') ? 'active' : '' }}">
            <a href="{{ route('settings') }}" style="text-decoration: none; color: inherit;">
                <i class="icon">⚙️</i>
                Settings
            </a>
        </div>
        <div class="menu-item {{ request()->routeIs('help') ? 'active' : '' }}">
            <a href="{{ route('help') }}" style="text-decoration: none; color: inherit;">
                <i class="icon">❓</i>
                Help
            </a>
        </div>
    </div>

    <div class="menu-item logout-item">
        <form id="logout-form" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-button">
                <i class="icon">🚪</i>
                Logout
            </button>
        </form>
    </div>
</div>

<style>
.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #0487FF;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    overflow: hidden;
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.logout-button {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    transition: background-color 0.3s;
}

.logout-button:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.logout-item {
    margin-top: auto;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    padding-top: 1rem;
}
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutForm = document.getElementById('logout-form');
        
        logoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                this.submit();
            }
        });
    });
</script>
@endpush 