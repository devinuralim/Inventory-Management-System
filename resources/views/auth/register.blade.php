<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - Aplikasi Inventory</title>

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * { box-sizing: border-box; }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(to right, #e0f2fe, #bae6fd);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 20px;
    }

    .container {
      background-color: #1e293b;
      border-radius: 20px;
      padding: 50px 35px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 420px;
      text-align: center;
      animation: slide-in 0.6s ease-out;
      max-height: 95vh;
      overflow-y: auto;
    }

    @keyframes slide-in {
      from { transform: translateY(30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .logo {
      width: 90px;
      margin: 0 auto 20px;
    }

    .logo img {
      width: 100%;
    }

    h1 {
      font-size: 26px;
      margin-bottom: 10px;
      color: #ffffff;
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
      position: relative;
      margin-bottom: 20px;
    }

    .form-group input {
      width: 100%;
      padding: 14px 16px;
      border-radius: 10px;
      border: 1px solid #94a3b8;
      font-size: 14px;
      background-color: #ffffff;
      transition: border-color 0.2s;
      color: #1e293b;
    }

    .form-group input:focus {
      border-color: #38bdf8;
      outline: none;
    }

    .form-group label {
      position: absolute;
      top: 14px;
      left: 16px;
      color: #64748b;
      background-color: transparent;
      padding: 0 6px;
      font-size: 14px;
      transition: 0.2s;
      pointer-events: none;
    }

    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
      top: -9px;
      left: 12px;
      font-size: 11px;
      color: #38bdf8;
      background-color: #1e293b;
    }

    .toggle-password {
      position: absolute;
      right: 14px;
      top: 14px;
      font-size: 16px;
      cursor: pointer;
      color: #64748b;
    }

    .toggle-password:hover {
      color: #38bdf8;
    }

    button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(to right, #38bdf8, #0ea5e9);
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background: linear-gradient(to right, #0ea5e9, #0284c7);
    }

    .footer-text {
      font-size: 13px;
      color: #cbd5e1;
      margin-top: 25px;
    }

    .footer-text a {
      color: #38bdf8;
      font-weight: 600;
      text-decoration: none;
    }

    .footer-text a:hover {
      text-decoration: underline;
    }

    .error-message {
      color: #f87171;
      font-size: 14px;
      margin-bottom: 16px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="{{ asset('k2net.png') }}" alt="K2Net Logo">
    </div>

    <h1>Register</h1>
    <p class="subtitle">Create an account using your Employee ID</p>

    @if ($errors->any())
      <div class="error-message">
        <ul style="list-style: none; padding: 0; margin: 0;">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="form-group">
        <input id="id_pegawai" name="id_pegawai" type="text" value="{{ old('id_pegawai') }}" placeholder=" " required>
        <label for="id_pegawai">ID Pegawai</label>
      </div>

      <div class="form-group">
        <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder=" " required>
        <label for="name">Nama</label>
      </div>

      <div class="form-group">
        <input id="password" name="password" type="password" placeholder=" " required>
        <label for="password">Password</label>
        <i class="fas fa-eye toggle-password" onclick="toggleVisibility('password', this)"></i>
      </div>

      <div class="form-group">
        <input id="password_confirmation" name="password_confirmation" type="password" placeholder=" " required>
        <label for="password_confirmation">Konfirmasi Password</label>
        <i class="fas fa-eye toggle-password" onclick="toggleVisibility('password_confirmation', this)"></i>
      </div>

      <button type="submit">Register</button>
    </form>

    <div class="footer-text">
      Sudah punya akun? <a href="{{ url('/') }}">Login di sini</a>
    </div>
    <div class="footer-text">© 2025 K2Net</div>
  </div>

  <script>
    function toggleVisibility(inputId, icon) {
      const input = document.getElementById(inputId);
      const isPassword = input.type === "password";
      input.type = isPassword ? "text" : "password";
      icon.classList.toggle("fa-eye");
      icon.classList.toggle("fa-eye-slash");
    }
  </script>
</body>
</html>
