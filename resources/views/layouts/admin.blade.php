<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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

    .logo-fixed span {
      color: #00c0ff;
    }

    .logo-fixed.hidden {
      transform: translateX(-200%);
    }

    .sidebar {
      height: 100vh;
      background-color: #1d2b3a;
      color: #fff;
      padding: 80px 20px 20px;
      position: fixed;
      width: 240px;
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
      margin-bottom: 10px;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background-color: #0d6efd;
      border-radius: 8px;
    }

    .main-content {
      margin-left: 240px;
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
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
      z-index: 1101;
    }

    .navbar {
      z-index: 900;
    }

    /* Atur jarak teks navbar saat sidebar tampil */
    .main-content:not(.full-width) .navbar-text {
      margin-left: 20px;
    }
  </style>
</head>
<body>

  <!-- Tombol Toggle Sidebar -->
  <button class="toggle-btn" id="toggleSidebarBtn">&#9776;</button>

  <!-- Logo K2NET -->
  <div class="logo-fixed" id="logoK2net">
    <img src="{{ asset('k2net.png') }}" alt="K2NET Logo" style="height: 40px;">
  </div>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="mb-4">
      <p class="mb-0">Selamat datang, <strong>Admin {{ Auth::user()->name }}</strong></p>
    </div>
    <nav class="nav flex-column">
      <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        Dashboard
      </a>
      <a href="{{ route('admin.barangs') }}" class="nav-link {{ request()->routeIs('admin.barangs') ? 'active' : '' }}">
        Daftar Barang
      </a>
      <a href="{{ route('admin.karyawans.index') }}" class="nav-link {{ request()->routeIs('admin.karyawans.*') ? 'active' : '' }}">
        Daftar Karyawan
      </a>
      <a href="{{ route('admin.peminjaman.index') }}" class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
        Daftar Peminjaman Barang
      </a>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="main-content" id="mainContent">
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand navbar-light bg-white shadow-sm rounded mb-4">
      <div class="container-fluid">
        <span class="navbar-text fw-bold">Dashboard Admin</span>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
              {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit">Logout</button>
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Yield Halaman -->
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
