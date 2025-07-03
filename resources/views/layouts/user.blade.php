<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      color: #333;
    }

    @keyframes fade-in {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slide-in-left {
      from { transform: translateX(-100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    .fade-in {
      animation: fade-in 0.6s ease forwards;
    }

    .logo-fixed {
      position: fixed;
      top: 15px;
      left: 60px;
      z-index: 1100;
      font-size: 1.4rem;
      font-weight: bold;
      color: white;
      transition: transform 0.3s ease;
    }

    .logo-fixed.hidden {
      transform: translateX(-200%);
    }

    .sidebar {
      height: 100vh;
      background: linear-gradient(to bottom right, #1d3557, #0d1b2a);
      color: #fff;
      padding: 80px 20px 20px;
      position: fixed;
      width: 220px;
      left: 0;
      top: 0;
      transition: transform 0.3s ease;
      z-index: 1000;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
      animation: slide-in-left 0.5s ease;
    }

    .sidebar.hidden {
      transform: translateX(-100%);
    }

    .sidebar .nav-link {
      color: #fff;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 0.95rem;
      padding: 12px 16px;
      border-radius: 8px;
      transition: all 0.3s ease;
      font-weight: 500;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: rgba(255, 255, 255, 0.2);
      transform: scale(1.03);
    }

    .sidebar .nav-link i {
      transition: transform 0.3s;
    }

    .sidebar .nav-link:hover i {
      transform: rotate(-5deg) scale(1.2);
    }

    .sidebar-footer {
      font-size: 0.85rem;
      color: #ccc;
      text-align: center;
      padding-top: 20px;
      margin-top: 10px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .main-content {
      margin-left: 220px;
      padding: 30px 20px;
      transition: margin-left 0.3s ease;
      animation: fade-in 0.6s ease;
    }

    .main-content.full-width {
      margin-left: 0;
    }

    .toggle-btn {
      position: fixed;
      top: 25px;
      left: 15px;
      background-color: #1d3557;
      color: #fff;
      border: none;
      padding: 8px 12px;
      border-radius: 10px;
      cursor: pointer;
      z-index: 1101;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      font-size: 1.2rem;
      transition: all 0.3s ease;
    }

    .toggle-btn:hover {
      background-color: #0b2545;
      transform: scale(1.05);
    }

    h2, h3 {
      font-weight: 600;
    }

    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .btn {
      border-radius: 10px;
      transition: all 0.3s ease;
    }

    .btn:hover {
      transform: scale(1.03);
    }
  </style>
</head>
<body>
  <button class="toggle-btn" id="toggleSidebarBtn">&#9776;</button>
  <div class="logo-fixed" id="logoK2net">
    <img src="{{ asset('k2net.png') }}" alt="K2NET Logo" style="height: 50px;">
  </div>

  <div class="sidebar" id="sidebar">
    <div>
      <div class="mb-3">
        <p class="mb-1 small">Halo, <strong>{{ Auth::user()->name }}</strong></p>
      </div>
      <nav class="nav flex-column">
        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
          <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('user.barang.index') }}" class="nav-link {{ request()->routeIs('user.barang.*') ? 'active' : '' }}">
          <i class="fas fa-box"></i> Daftar Barang
        </a>
        <a href="{{ route('user.peminjaman.index') }}" class="nav-link {{ request()->routeIs('user.peminjaman.*') ? 'active' : '' }}">
          <i class="fas fa-handshake"></i> Peminjaman
        </a>
      </nav>
    </div>

    <div>
      <nav class="nav flex-column mb-2">
        <a href="{{ route('user.profile') }}" class="nav-link">
          <i class="fas fa-user"></i> Profile
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="nav-link bg-transparent border-0 text-start text-white d-flex align-items-center gap-2">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </form>
      </nav>
      <div class="sidebar-footer">
        &copy; 2025 K2NET
      </div>
    </div>
  </div>

  <div class="main-content" id="mainContent">
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggleBtn = document.getElementById('toggleSidebarBtn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const logo = document.getElementById('logoK2net');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('hidden');
      logo.classList.toggle('hidden');
      mainContent.classList.toggle('full-width');

      if (!sidebar.classList.contains('hidden')) {
        sidebar.classList.remove('fade-in');
        void sidebar.offsetWidth; 
        sidebar.classList.add('fade-in');
      }
    });
  </script>

</body>
</html>
