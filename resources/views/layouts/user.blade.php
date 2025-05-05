<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
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
      background-color: #1d2b3a;
      color: #fff;
      padding: 60px 15px 15px;
      position: fixed;
      width: 220px;
      left: 0;
      top: 0;
      transition: transform 0.3s ease;
      z-index: 1000;
    }

    .sidebar.hidden {
      transform: translateX(-100%);
    }

    .sidebar .nav-link {
      color: #fff;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 0.95rem;
      padding: 8px 10px;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background-color: #0d6efd;
      border-radius: 6px;
    }

    .main-content {
      margin-left: 220px;
      padding: 20px;
      transition: margin-left 0.3s ease;
    }

    .main-content.full-width {
      margin-left: 0;
    }

    .toggle-btn {
      position: fixed;
      top: 15px;
      left: 15px;
      background-color: #0d6efd;
      color: #fff;
      border: none;
      padding: 8px 12px;
      border-radius: 5px;
      cursor: pointer;
      z-index: 1101;
    }

    .navbar {
      z-index: 900;
    }

    .dropdown-menu {
      min-width: 160px;
      font-size: 0.95rem;
      margin-top: 0px !important;
    }

    .dropdown-menu a,
    .dropdown-menu button {
      padding: 8px 14px;
    }

    .sidebar .mb-3 {
      margin-top: 15px;
    }

    .sidebar-footer {
      position: absolute;
      bottom: 10px;
      left: 0;
      width: 100%;
      text-align: center;
      font-size: 0.75rem;
      color: #ccc;
    }
  </style>
</head>
<body>

  <button class="toggle-btn" id="toggleSidebarBtn">&#9776;</button>

  <div class="logo-fixed" id="logoK2net">
    <img src="{{ asset('k2net.png') }}" alt="K2NET Logo" style="height: 36px;">
  </div>

  <div class="sidebar" id="sidebar">
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
      <a href="{{ route('user.karyawan.index') }}" class="nav-link {{ request()->routeIs('user.karyawan.*') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Daftar Karyawan
      </a>
      <a href="{{ route('user.peminjaman.index') }}" class="nav-link {{ request()->routeIs('user.peminjaman.*') ? 'active' : '' }}">
        <i class="fas fa-handshake"></i> Peminjaman
      </a>
    </nav>
    <div class="sidebar-footer">
      &copy; 2025 K2NET
    </div>
  </div>

  <div class="main-content" id="mainContent">
    <nav class="navbar navbar-expand navbar-light bg-white shadow-sm rounded mb-4">
      <div class="container-fluid">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle fw-semibold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end text-sm" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
    <div>
      @yield('content')
    </div>
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
    });
  </script>
</body>
</html>
