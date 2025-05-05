<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <style>
    * { box-sizing:border-box; margin:0; padding:0; }
    body {
      font-family:'Segoe UI',sans-serif;
      background:linear-gradient(to right,#0f172a,#1e3a8a);
      display:flex;justify-content:center;align-items:center;
      height:100vh;margin:0;padding:20px;
    }
    .container {
      background-color:#1e293b;
      border-radius:16px;
      padding:20px 20px;        /* kurangin padding vertikal */
      box-shadow:0 12px 24px rgba(0,0,0,0.3);
      text-align:center;color:#fff;
      width:100%;max-width:420px;
    }
    .logo {
      width:80px;               /* kecilkan logo */
      margin:0 auto 10px;       /* kurangin margin-bottom */
    }
    .logo img { width:100%; }
    h2 {
      font-size:22px;
      margin-bottom:8px;        /* kurangin jarak ke subtitle */
    }
    p.subtitle {
      font-size:14px;color:#cbd5e1;
      margin-bottom:12px;       /* kurangin jarak */
    }
    form {
      display:flex;flex-direction:column;
      gap:8px;                   /* kurangin gap antar input */
      text-align:left;
    }
    .form-group { margin-bottom:8px; }
    .form-group label {
      display:block;margin-bottom:4px;
      font-size:14px;color:#e2e8f0;
    }
    .form-group input {
      width:100%;padding:10px;
      border-radius:8px;border:none;
      font-size:14px;background:#f8fafc;color:#0f172a;
    }
    .error-message {
      color:#f87171;font-size:14px;
      margin-bottom:8px;text-align:left;
    }
    button {
      width:100%;padding:10px;
      background:#2563eb;color:#fff;border:none;
      border-radius:8px;font-weight:600;
      font-size:16px;cursor:pointer;
      transition:background-color .3s;
    }
    button:hover { background:#1d4ed8; }
    .footer-text {
      font-size:13px;color:#cbd5e1;
      margin-top:12px;
    }
    .footer-text a { color:#60a5fa;text-decoration:none; }
    .footer-text a:hover { text-decoration:underline; }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="{{ asset('k2net.png') }}" alt="K2Net Logo">
    </div>

    <h2>Register</h2>
    <p class="subtitle">Create an account using your Employee ID</p>

    @if($errors->any())
      <div class="error-message">
        <ul style="list-style:none;padding-left:0;">
          @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="form-group">
        <label for="id_pegawai">ID Pegawai</label>
        <input id="id_pegawai" name="id_pegawai" type="text" value="{{ old('id_pegawai') }}" required>
      </div>
      <div class="form-group">
        <label for="name">Nama</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required>
      </div>

      <button type="submit">Register</button>
    </form>

    <div class="footer-text">
    Already have an account?<a href="{{ url('/') }}">Login here</a>
    </div>
    <div class="footer-text">© 2025 K2Net</div>
  </div>
</body>
</html>
