<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Inventory</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 480px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .container h1 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .container p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .buttons a {
            padding: 12px 0;
            background-color: #2563eb;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .buttons a:hover {
            background-color: #1e40af;
        }

        .footer-text {
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            .container h1 {
                font-size: 24px;
            }

            .buttons a {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Inventory App</h1>
        <p>Please login or register to continue.</p>
        
        @if (Route::has('login'))
            <div class="buttons">
                @auth
                    <a href="{{ url('/dashboard') }}">Ke Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Daftar</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="footer-text">
            <p>© 2025 K2Net</p>
        </div>
    </div>
</body>
</html>
