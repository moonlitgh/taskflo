<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - Login</title>
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

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .nav-buttons button {
            padding: 8px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .login-btn {
            background-color: #0487FF;
            color: white;
        }

        .register-btn {
            background-color: white;
            color: #0487FF;
            border: 1px solid #0487FF !important;
        }

        .login-container {
            max-width: 800px;
            margin: 80px auto;
            padding: 3rem;
            background-color: white;
            border-radius: 10px;
            border: 1px solid #e1e1e1;
            box-shadow: 0 0 30px rgba(4, 135, 255, 0.2);
        }

        .welcome-text {
            color: #0487FF;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .login-title {
            color: #0487FF;
            font-size: 32px;
            margin-bottom: 30px;
        }

        .input-field {
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            border: 1px solid #0487FF;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
        }

        .input-field:focus {
            border: 2px solid #0487FF;
            box-shadow: 0 0 5px rgba(4, 135, 255, 0.2);
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .login-submit {
            width: 100%;
            padding: 15px;
            background-color: #0487FF;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-submit:hover {
            background-color: #0371db;
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: #0487FF;
            text-decoration: none;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .terms-text {
            text-align: center;
            font-size: 16px;
            margin: 30px 0;
            line-height: 1.5;
        }

        .terms-text a {
            color: #0487FF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">TASKFLO</div>
        <div class="nav-buttons">
            <button class="login-btn" onclick="window.location.href='{{ route('login') }}'">Login</button>
            <button class="register-btn" onclick="window.location.href='{{ route('register') }}'">Register</button>
        </div>
    </nav>

    <div class="login-container">
        <p class="welcome-text">Welcome back to TaskFlow</p>
        <h1 class="login-title">Login to Continue</h1>
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" class="input-field" placeholder="Email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <input type="password" name="password" class="input-field" placeholder="Password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
            
            <p class="terms-text">
                Dengan melanjutkan, <a href="#">Anda menyetujui</a> kami<br>
                <a href="#">Syarat & Kebijakan</a> Privasi
            </p>

            <button type="submit" class="login-submit">Login</button>

            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function(e) {
                const email = form.querySelector('input[name="email"]').value;
                const password = form.querySelector('input[name="password"]').value;
                
                if (!email || !password) {
                    e.preventDefault();
                    alert('Please fill in all fields');
                }
            });
        });
    </script>
</body>
</html> 