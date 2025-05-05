<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Inventory</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0f172a, #1e3a8a);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #1e293b;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: #fff;
            width: 100%;
            max-width: 420px;
        }

        .logo {
            width: 100px;
            margin: 0 auto 20px;
        }

        .logo img {
            width: 100%;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p.subtitle {
            font-size: 14px;
            color: #cbd5e1;
            margin-bottom: 25px;
        }

        form {
            text-align: left;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #e2e8f0;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 8px;
            border: none;
            font-size: 15px;
            background-color: #f8fafc;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        .footer-text {
            font-size: 13px;
            color: #cbd5e1;
            margin-top: 25px;
            text-align: center;
        }

        .footer-text a {
            color: #60a5fa;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #f87171;
            font-size: 14px;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- LOGO -->
        <div class="logo">
            <img src="{{ asset('k2net.png') }}" alt="K2Net Logo">
        </div>

        <!-- TITLE -->
        <h1>Welcome to Inventory System</h1>
        <p class="subtitle">Please login or register to continue.</p>

        <!-- ERROR MESSAGE -->
        @if(session('status'))
            <div class="error-message">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-message">
                <ul style="list-style: none; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- LOGIN FORM -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="id_pegawai">ID Pegawai</label>
                <input type="text" name="id_pegawai" id="id_pegawai" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Login</button>
        </form>

        @if (Route::has('register'))
            <div class="footer-text">
                Don't have an account? <a href="{{ route('register') }}">Register here</a>
            </div>
        @endif

        <div class="footer-text" style="margin-top: 10px;">
            © 2025 K2Net
        </div>
    </div>
</body>
</html>
