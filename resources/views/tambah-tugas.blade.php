<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - Tambah Tugas</title>
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

        /* Tambahan style untuk form tambah tugas */
        .main-content {
            flex: 1;
            padding: 0 2rem;
        }

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
</head>
<body>
    <!-- Copy navbar dari home -->
    <nav class="navbar">
        <div class="logo">TAKSFLO</div>
        
    </nav>

    <div class="container">
        <!-- Copy sidebar dari home -->
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
                <div class="menu-item active">
                    <a href="{{ route('tambah-tugas') }}" style="text-decoration: none; color: inherit;">
                        <i class="icon">➕</i>
                        Tambah Tugas
                    </a>
                </div>
                <div class="menu-item">
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

        <!-- Konten utama form tambah tugas -->
        <div class="main-content">
            <div class="form-container">
                <h2 class="form-title">Tambah Tugas Baru</h2>
                <form>
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control" placeholder="Lorem ipsum dolor sit amet">
                    </div>

                    <div class="form-group">
                        <label>Tenggat Waktu</label>
                        <input type="date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" name="status" id="delay">
                                <label for="delay" class="status-delay">Delay</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="status" id="process">
                                <label for="process" class="status-process">On Process</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="status" id="done">
                                <label for="done" class="status-done">Done</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Priority</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" name="priority" id="high">
                                <label for="high" class="priority-high">High</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="priority" id="medium">
                                <label for="medium" class="priority-medium">Medium</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="priority" id="low">
                                <label for="low" class="priority-low">Low</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Task Description</label>
                        <textarea class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 