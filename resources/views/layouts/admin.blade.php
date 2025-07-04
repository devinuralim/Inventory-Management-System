<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }

    .sidebar {
      height: 100vh;
      background: linear-gradient(to bottom, #1d3557, #0d1b2a);
      color: #fff;
      padding: 80px 15px 20px;
      position: fixed;
      width: 220px;
      left: 0;
      top: 0;
      transition: transform 0.3s ease;
      z-index: 1000;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
    }

    .sidebar.hidden {
      transform: translateX(-100%);
    }

    .sidebar .nav-link {
      color: #fff;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 0.95rem;
      padding: 10px 14px;
      border-radius: 6px;
      transition: all 0.2s ease-in-out;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.15);
      transform: translateX(5px);
    }

    .sidebar-footer {
      font-size: 0.85rem;
      color: #ccc;
      text-align: center;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
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
      top: 23px;
      left: 15px;
      background-color: #457b9d;
      color: #fff;
      border: none;
      padding: 6px 10px;
      border-radius: 8px;
      cursor: pointer;
      z-index: 1101;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      font-size: 1.2rem;
    }

    .toggle-btn:hover {
      background-color: #1d3557;
    }

    .sidebar .nav-bottom {
      border-top: 1px solid rgba(255,255,255,0.1);
      padding-top: 10px;
    }

    .sidebar .nav-bottom form,
    .sidebar .nav-bottom .nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 0.95rem;
      margin-bottom: 10px;
      color: #fff;
    }

    .sidebar .nav-bottom button {
      background: none;
      border: none;
      color: #fff;
      padding: 10px 14px;
      width: 100%;
      text-align: left;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        width: 200px;
        padding: 60px 10px 20px;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0 !important;
        padding: 15px;
      }

      .toggle-btn {
        top: 15px;
        left: 10px;
        padding: 6px 8px;
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <button class="toggle-btn" id="toggleSidebarBtn">&#9776;</button>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div>
      <div class="text-center mb-4">
        <img src="{{ asset('k2net.png') }}" alt="K2NET Logo" style="height: 50px;">
      </div>
      <div class="mb-3">
        <p class="mb-1 small">Selamat datang, Admin</p>
        <strong class="d-block mb-3">{{ Auth::user()->name }}</strong>
      </div>
      <nav class="nav flex-column">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('admin.barangs') }}" class="nav-link {{ request()->routeIs('admin.barangs') ? 'active' : '' }}">
          <i class="fas fa-box"></i> Daftar Barang
        </a>
        <a href="{{ route('admin.karyawans.index') }}" class="nav-link {{ request()->routeIs('admin.karyawans.*') ? 'active' : '' }}">
          <i class="fas fa-users"></i> Daftar Karyawan
        </a>
        <a href="{{ route('admin.peminjaman.index') }}" class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
          <i class="fas fa-handshake"></i> Peminjaman
          @if(isset($notifikasiCount) && $notifikasiCount > 0)
            <span class="badge bg-danger ms-auto">{{ $notifikasiCount }}</span>
          @endif
        </a>
        <!-- Tambahan menu Pengumuman -->
        <a href="{{ route('admin.pengumuman.index') }}" class="nav-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
          <i class="fas fa-bullhorn"></i> Pengumuman
        </a>
      </nav>
    </div>
    <div class="nav-bottom">
      <a href="{{ route('admin.profile') }}" class="nav-link">
        <i class="fas fa-user"></i> Profile
      </a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">
          <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </form>
      <div class="sidebar-footer">
        &copy; 2025 K2NET
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content" id="mainContent">
    @if (request()->routeIs('admin.dashboard'))
      <div class="dashboard-header p-4 mb-4 rounded text-white"
           style="background: linear-gradient(90deg, #457b9d, #1d3557); box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <h3><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</h3>
        <p class="mb-0">Kelola semua data barang, karyawan, dan peminjaman di sini.</p>
      </div>
    @endif

    @yield('content')
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggleBtn = document.getElementById('toggleSidebarBtn');
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');

      toggleBtn.addEventListener('click', function () {
        if (window.innerWidth <= 768) {
          sidebar.classList.toggle('show');
        } else {
          sidebar.classList.toggle('hidden');
          mainContent.classList.toggle('full-width');
        }
      });
    });
  </script>

  @stack('scripts')
</body>
</html>
