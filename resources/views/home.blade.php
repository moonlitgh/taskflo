<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

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

        .logout-item {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 1rem;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
        }

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
            background-color: #FF4444;  /* Warna merah untuk tanggal yang ada tugasnya */
            color: white;
            border-radius: 5px;
        }

        /* Prioritaskan warna today jika hari ini juga memiliki tugas */
        .calendar-day.today.has-task {
            background-color: #0487FF;
            border: 2px solid #FF4444;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">TAKSFLO</div>
        
    </nav>

    <div class="container">
        <div class="sidebar">
            <div class="user-info">
                <img src="path/to/avatar.jpg" alt="User Avatar">
                <div class="user-details">
                    <span class="username">User</span>
                    <span class="email">emailuser@gmail.com</span>
                </div>
            </div>

            <div class="menu-items">
                <div class="menu-item active">
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

        <div class="main-content">
            <h2>Dashboard</h2>
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total</h3>
                    <p>XX</p>
                </div>
                <div class="stat-card">
                    <h3>Done</h3>
                    <p>XX</p>
                </div>
                <div class="stat-card">
                    <h3>Delay</h3>
                    <p>XX</p>
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
        </div>
    </div>

    <script>
    class Calendar {
        constructor() {
            this.date = new Date();
            this.currentMonth = this.date.getMonth();
            this.currentYear = this.date.getFullYear();
            
            this.monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"];
            
            // Contoh data tugas (nanti bisa diambil dari database)
            this.tasks = [
                { date: '2025-03-15' }, // Format: YYYY-MM-DD
                { date: '2025-03-20' },
                { date: '2025-03-25' }
            ];
            
            this.setupEventListeners();
            this.renderCalendar();
        }

        hasTask(year, month, day) {
            const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            return this.tasks.some(task => task.date === dateString);
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
        }

        renderCalendar() {
            const firstDay = new Date(this.currentYear, this.currentMonth, 1);
            const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
            const startingDay = firstDay.getDay();
            const totalDays = lastDay.getDate();
            
            // Update month and year display
            document.getElementById('currentMonth').textContent = 
                `${this.monthNames[this.currentMonth]} ${this.currentYear}`;

            const calendarGrid = document.querySelector('.calendar-grid');
            const headerRow = calendarGrid.innerHTML.split('</div>').slice(0, 7).join('</div>') + '</div>';
            calendarGrid.innerHTML = headerRow;

            // Previous month's days
            const prevMonthLastDay = new Date(this.currentYear, this.currentMonth, 0).getDate();
            for (let i = startingDay - 1; i >= 0; i--) {
                const day = document.createElement('div');
                day.className = 'calendar-day other-month';
                day.textContent = prevMonthLastDay - i;
                calendarGrid.appendChild(day);
            }

            // Current month's days
            const today = new Date();
            for (let i = 1; i <= totalDays; i++) {
                const day = document.createElement('div');
                day.className = 'calendar-day';
                
                // Cek apakah hari ini
                if (this.currentYear === today.getFullYear() && 
                    this.currentMonth === today.getMonth() && 
                    i === today.getDate()) {
                    day.classList.add('today');
                }
                
                // Cek apakah ada tugas
                if (this.hasTask(this.currentYear, this.currentMonth, i)) {
                    day.classList.add('has-task');
                }
                
                day.textContent = i;
                calendarGrid.appendChild(day);
            }

            // Next month's days
            const remainingDays = 42 - (startingDay + totalDays); // 42 is 6 rows * 7 days
            for (let i = 1; i <= remainingDays; i++) {
                const day = document.createElement('div');
                day.className = 'calendar-day other-month';
                day.textContent = i;
                calendarGrid.appendChild(day);
            }
        }
    }

    // Initialize calendar when page loads
    document.addEventListener('DOMContentLoaded', () => {
        new Calendar();
    });
    </script>
</body>
</html> 