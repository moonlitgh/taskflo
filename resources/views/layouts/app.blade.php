<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        .user-info .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 1rem;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0487FF;
            font-size: 2rem;
            font-weight: bold;
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

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .menu-item.active {
            background-color: white;
            color: #0487FF;
        }

        /* Logout item */
        .logout-item {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 1rem;
        }

        .main-content {
            flex: 1;
            padding: 0 2rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="logo">TASKFLO</div>
    </nav>

    <div class="container">
        @include('layouts.sidebar')
        
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>