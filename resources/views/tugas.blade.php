<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - Daftar Tugas</title>
    <style>
        /* Style dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        /* Navbar styles */
        .navbar {
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .logo {
            font-weight: bold;
            font-size: 24px;
            color: #333;
        }
        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #0487FF;
        }

        /* Container dan Sidebar styles */
        .container {
            display: flex;
            min-height: calc(100vh - 70px);
            padding-top: 20px;
        }

        .sidebar {
            width: 250px;
            background-color: #87CEEB;
            padding: 2rem;
            color: white;
            border-radius: 20px;
            margin-left: 20px;
            height: calc(100vh - 90px);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* User info dalam sidebar */
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 2rem;
        }

        .user-info img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 1rem;
            background-color: white;
        }

        .user-info .user-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .user-info .username {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.3rem;
        }

        .user-info .email {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Menu items styles */
        .menu-items {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .menu-item.active {
            background-color: white;
            color: #0487FF;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Logout item */
        .logout-item {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 1rem;
        }

        /* Style khusus untuk halaman tugas */
        .main-content {
            flex: 1;
            padding: 0 2rem;
        }

        .task-container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: calc(100vh - 110px);
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .tasks-wrapper {
            flex: 1;
            overflow-y: auto;
            padding-right: 10px; /* Ruang untuk scrollbar */
        }

        /* Styling untuk scrollbar */
        .tasks-wrapper::-webkit-scrollbar {
            width: 8px;
        }

        .tasks-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .tasks-wrapper::-webkit-scrollbar-thumb {
            background: #87CEEB;
            border-radius: 4px;
        }

        .tasks-wrapper::-webkit-scrollbar-thumb:hover {
            background: #70b4d3;
        }

        .task-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .task-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .task-checkbox {
            width: 20px;
            height: 20px;
        }

        .task-content {
            flex: 1;
            display: grid;
            grid-template-columns: 2fr 2fr 1fr 1fr 100px;
            align-items: center;
            gap: 1rem;
        }

        .task-title {
            font-weight: 500;
        }

        .task-description {
            color: #666;
        }

        .task-date {
            color: #888;
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 0.3rem 1rem;
            border-radius: 15px;
            color: white;
            font-size: 0.9rem;
            text-align: center;
            width: fit-content;
        }

        .task-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem;
            border: none;
            background: none;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            background-color: #87CEEB;
            padding: 1rem;
            border-radius: 10px;
            color: white;
        }

        .add-task-btn {
            background-color: white;
            color: #0487FF;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .back-btn {
            background-color: #87CEEB;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 1rem;
        }

        /* Update style untuk modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
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
            max-height: 80vh; /* Maksimum tinggi 80% dari viewport */
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
            overflow-y: auto; /* Membuat konten bisa di-scroll */
            max-height: calc(80vh - 140px); /* Tinggi maksimum dikurangi header dan footer */
        }

        .modal-form .form-group {
            margin-bottom: 1.5rem;
        }

        .modal-form label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        .modal-form .form-control {
            width: 100%;
            padding: 1rem;
            border: 2px solid #87CEEB;  /* Garis biru di semua sisi */
            border-radius: 5px;
            font-size: 1rem;
        }

        .modal-form textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Custom scrollbar untuk modal-body */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #87CEEB;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #70b4d3;
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

        .radio-item input[type="radio"] {
            width: 16px;
            height: 16px;
        }

        /* Warna untuk status */
        .status-delay { color: #FF4444; }
        .status-process { color: #FFA500; }
        .status-done { color: #4CAF50; }

        /* Warna untuk priority */
        .priority-high { color: #FF4444; }
        .priority-medium { color: #FFA500; }
        .priority-low { color: #4CAF50; }

        /* Update priority badges di task list */
        .priority-badge {
            padding: 0.3rem 1rem;
            border-radius: 15px;
            color: white;
            font-size: 0.9rem;
            text-align: center;
            width: fit-content;
        }

        .priority-badge-high {
            background-color: #FF4444;
        }

        .priority-badge-medium {
            background-color: #FFA500;
        }

        .priority-badge-low {
            background-color: #4CAF50;
        }

        /* Status colors dalam modal */
        .modal .status-delay::before { 
            content: "•";
            color: #FF4444;
            margin-right: 8px;
            font-size: 24px;
            line-height: 0;
            vertical-align: middle;
        }

        .modal .status-process::before { 
            content: "•";
            color: #FFA500;
            margin-right: 8px;
            font-size: 24px;
            line-height: 0;
            vertical-align: middle;
        }

        .modal .status-done::before { 
            content: "•";
            color: #4CAF50;
            margin-right: 8px;
            font-size: 24px;
            line-height: 0;
            vertical-align: middle;
        }

        /* Update priority di modal - menggunakan titik warna seperti status */
        
        .modal .priority-dot-high::before { 
            content: "•";
            color: #FF4444;
            margin-right: 8px;
            font-size: 24px;
            line-height: 0;
            vertical-align: middle;
        }

       
        .modal .priority-dot-medium::before { 
            content: "•";
            color: #FFA500;
            margin-right: 8px;
            font-size: 24px;
            line-height: 0;
            vertical-align: middle;
        }

        .modal .priority-dot-low::before { 
            content: "•";
            color: #4CAF50;
            margin-right: 8px;
            font-size: 24px;
            line-height: 0;
            vertical-align: middle;
        }

        /* Tetap pertahankan priority badge di list tugas (di luar modal) */
        .task-content .priority-badge {
            padding: 0.3rem 1rem;
            border-radius: 15px;
            color: white;
            font-size: 0.9rem;
            text-align: center;
            width: fit-content;
        }


        /* Radio group styling dalam modal */
        .modal .radio-group {
            display: flex;
            gap: 2rem;
            margin-top: 0.5rem;
        }

        .modal .radio-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">TAKSFLO</div>
        
    </nav>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="user-info">
                <img src="path/to/avatar.jpg" alt="User Avatar">
                <div class="user-details">
                    <span class="username">User</span>
                    <span class="email">emailuser@gmail.com</span>
                </div>
            </div>

            <div class="menu-items">
                <div class="menu-item">
                    <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">
                        <i class="icon">📊</i>
                        Dashboard
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('tambah-tugas') }}" style="text-decoration: none; color: inherit;">
                        <i class="icon">➕</i>
                        Tambah Tugas
                    </a>
                </div>
                <div class="menu-item active">
                    <a href="{{ route('tugas') }}" style="text-decoration: none; color: inherit;">
                        <i class="icon">📝</i>
                        Tugas
                    </a>
                </div>
                <div class="menu-item">
                    <i class="icon">⚙️</i>
                    Settings
                </div>
                <div class="menu-item">
                    <i class="icon">❓</i>
                    Help
                </div>
            </div>

            <div class="menu-item logout-item">
                <i class="icon">🚪</i>
                Logout
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="task-container">
                <div class="task-header">
                    <h2>Tugas</h2>
                    <button class="add-task-btn">+ Add Task</button>
                </div>
                
                <div class="tasks-wrapper">
                    <!-- Update task card di list tugas - tanpa variabel database -->
                    <div class="task-card">
                        <input type="checkbox" class="task-checkbox">
                        <div class="task-content">
                            <span class="task-title">Membuat Desain Website</span>
                            <span class="task-description">Membuat desain website untuk client</span>
                            <span class="task-date">2024-03-20</span>
                            <span class="priority-badge priority-badge-high">High</span>
                            <div class="task-actions">
                                <button class="action-btn edit-btn">✏️</button>
                                <button class="action-btn delete-btn">🗑️</button>
                            </div>
                        </div>
                    </div>

                    <!-- Tambahkan beberapa contoh task lain -->
                    <div class="task-card">
                        <input type="checkbox" class="task-checkbox">
                        <div class="task-content">
                            <span class="task-title">Implementasi Database</span>
                            <span class="task-description">Mengimplementasikan struktur database</span>
                            <span class="task-date">2024-03-25</span>
                            <span class="priority-badge priority-badge-medium">Medium</span>
                            <div class="task-actions">
                                <button class="action-btn edit-btn">✏️</button>
                                <button class="action-btn delete-btn">🗑️</button>
                            </div>
                        </div>
                    </div>

                    <div class="task-card">
                        <input type="checkbox" class="task-checkbox">
                        <div class="task-content">
                            <span class="task-title">Testing Aplikasi</span>
                            <span class="task-description">Melakukan testing pada aplikasi</span>
                            <span class="task-date">2024-03-30</span>
                            <span class="priority-badge priority-badge-low">Low</span>
                            <div class="task-actions">
                                <button class="action-btn edit-btn">✏️</button>
                                <button class="action-btn delete-btn">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="back-btn">Back</button>
            </div>
        </div>
    </div>

    <!-- Update struktur modal -->
    <div id="editTaskModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Tugas</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="modal-form">
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control" value="Lorem Ipsum Dior">
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control">Lorem ipsum</textarea>
                    </div>

                    <div class="form-group">
                        <label>Tenggat Waktu</label>
                        <input type="date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" name="status" id="edit-delay">
                                <label for="edit-delay" class="status-delay"> Delay</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="status" id="edit-process">
                                <label for="edit-process" class="status-process"> On Process</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="status" id="edit-done">
                                <label for="edit-done" class="status-done"> Done</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Priority</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" name="priority" id="edit-high">
                                <label for="edit-high" class="priority-dot-high">High</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="priority" id="edit-medium">
                                <label for="edit-medium" class="priority-dot-medium">Medium</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="priority" id="edit-low">
                                <label for="edit-low" class="priority-dot-low">Low</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel">Batal</button>
                <button type="submit" class="btn-save">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Tambahkan script untuk mengatur modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editTaskModal');
            const editButtons = document.querySelectorAll('.action-btn');
            const closeButton = modal.querySelector('.close-modal');
            const cancelButton = modal.querySelector('.btn-cancel');

            // Buka modal saat tombol edit diklik
            editButtons.forEach(button => {
                if (!button.classList.contains('delete-btn')) {
                    button.addEventListener('click', () => {
                        modal.classList.add('show');
                    });
                }
            });

            // Tutup modal
            function closeModal() {
                modal.classList.remove('show');
            }

            closeButton.addEventListener('click', closeModal);
            cancelButton.addEventListener('click', closeModal);

            // Tutup modal jika mengklik area di luar modal
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html> 