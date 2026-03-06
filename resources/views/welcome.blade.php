<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>K2NET | Login Inventory</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

        <style>
            :root {
                --primary-navy: #1d3557;
                /* GANTI DISINI: Dari Orange ke Biru Aksen Logo */
                --highlight-blue: #00b4d8; 
                --highlight-hover: #0096c7;
                --text-slate: #cbd5e1;
            }

            * {
                box-sizing: border-box;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
                padding: 20px;
            }

            .container {
                background-color: var(--primary-navy);
                border-radius: 20px;
                padding: 45px 35px;
                box-shadow: 0 20px 40px rgba(29, 53, 87, 0.25);
                width: 100%;
                max-width: 400px;
                text-align: center;
                position: relative;
                overflow: hidden;
                animation: slide-in 0.7s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            /* Aksen garis biru di atas card */
            .container::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 5px;
                background: var(--highlight-blue);
            }

            @keyframes slide-in {
                from { transform: translateY(40px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }

            .logo {
                width: 90px;
                margin: 0 auto 20px;
                filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
            }

            .logo img {
                width: 100%;
            }

            h1 {
                font-size: 20px;
                font-weight: 700;
                margin-bottom: 8px;
                color: #ffffff;
                letter-spacing: 0.5px;
            }

            p.subtitle {
                font-size: 13px;
                color: var(--text-slate);
                margin-bottom: 30px;
            }

            form {
                text-align: left;
            }

            .form-group {
                position: relative;
                margin-bottom: 22px;
            }

            .form-group input {
                width: 100%;
                padding: 14px 16px;
                border-radius: 12px;
                border: 1px solid rgba(203, 213, 225, 0.2);
                font-size: 14px;
                background-color: rgba(255, 255, 255, 0.05);
                transition: all 0.3s ease;
                color: #ffffff;
            }

            /* Saat input fokus */
            .form-group input:focus {
                border-color: var(--highlight-blue);
                background-color: rgba(255, 255, 255, 0.1);
                outline: none;
                box-shadow: 0 0 0 4px rgba(0, 180, 216, 0.15);
            }

            .form-group label {
                position: absolute;
                top: 14px;
                left: 16px;
                color: #94a3b8;
                padding: 0 5px;
                font-size: 14px;
                transition: 0.3s;
                pointer-events: none;
            }

            .form-group input:focus + label,
            .form-group input:not(:placeholder-shown) + label {
                top: -10px;
                left: 12px;
                font-size: 11px;
                color: var(--highlight-blue);
                background-color: var(--primary-navy);
                font-weight: 600;
            }

            .toggle-password {
                position: absolute;
                right: 16px;
                top: 15px;
                font-size: 16px;
                cursor: pointer;
                color: #94a3b8;
                z-index: 10;
            }

            button {
                width: 100%;
                padding: 14px;
                background: var(--highlight-blue);
                color: #ffffff; /* Teks tombol jadi putih biar kontras sama biru */
                border: none;
                border-radius: 12px;
                font-weight: 700;
                font-size: 15px;
                cursor: pointer;
                transition: all 0.3s;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-top: 10px;
            }

            button:hover {
                background: var(--highlight-hover);
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 180, 216, 0.3);
            }

            .footer-text {
                font-size: 12px;
                color: #64748b;
                margin-top: 30px;
                font-weight: 500;
            }

            .error-message {
                background: rgba(248, 113, 113, 0.1);
                border-left: 3px solid #f87171;
                color: #f87171;
                padding: 10px;
                border-radius: 8px;
                font-size: 13px;
                margin-bottom: 20px;
                text-align: left;
            }

            @media (max-width: 480px) {
                .container { padding: 35px 25px; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo">
                <img src="{{ asset('k2net.png') }}" alt="K2Net Logo" />
            </div>

            <h1>Inventory System</h1>
            <p class="subtitle">Enter your credentials to access the dashboard</p>

            @if (session('status'))
                <div class="error-message">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    <ul style="list-style: none; padding: 0; margin: 0">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-times-circle me-2"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="id_pegawai" id="id_pegawai" placeholder=" " required autofocus autocomplete="off" />
                    <label for="id_pegawai">ID Pegawai</label>
                </div>

                <div class="form-group">
                    <input type="password" name="password" id="password" placeholder=" " required />
                    <label for="password">Password</label>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()" id="toggleIcon"></i>
                </div>

                <button type="submit">Log In Now</button>
            </form>

            <div class="footer-text">© {{ date('Y') }} K2NET Team</div>
        </div>

        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const icon = document.getElementById('toggleIcon');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            }
        </script>
    </body>
</html>