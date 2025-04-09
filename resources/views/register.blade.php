<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - Register</title>
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
            background-color: white;
            color: #0487FF;
            border: 1px solid #0487FF !important;
        }

        .register-btn {
            background-color: #0487FF;
            color: white;
        }

        .register-container {
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

        .register-title {
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

        .register-submit {
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

        .register-submit:hover {
            background-color: #0371db;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">TAKSFLO</div>
        <div class="nav-buttons">
            <button class="login-btn" onclick="window.location.href='{{ route('login') }}'">Login</button>
            <button class="register-btn" onclick="window.location.href='{{ route('register') }}'">Register</button>
        </div>
    </nav>

    <div class="register-container">
        <p class="welcome-text">Wellcome to TaskFlow</p>
        <h1 class="register-title">Register to Continue</h1>
        
        <input type="text" class="input-field" placeholder="Username">
        <input type="email" class="input-field" placeholder="Alamat email@gmail.com">
        <input type="password" class="input-field" placeholder="Masukkan Password">
        <input type="password" class="input-field" placeholder="Konfirmasi Password">

        <p class="terms-text">
            Dengan melanjutkan, <a href="#">Anda menyetujui</a> kami<br>
            <a href="#">Syarat & Kebijakan</a> Privasi
        </p>

        <button class="register-submit">Register</button>
    </div>
</body>
</html> 