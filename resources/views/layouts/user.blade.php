<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }

    .navbar-brand img {
      height: 40px;
    }

    .sidebar {
      height: 100vh;
      background-color: #1d2b3a;
      color: #fff;
      padding: 20px;
      position: fixed;
      width: 200px;
      left: 0;
      top: 0;
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
      margin-left: 200px;
      padding: 20px;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <p class="fw-bold">Halo, {{ Auth::user()->name }}</p>
    <nav class="nav flex-column">
      <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        Dashboard
      </a>
      <a href="#" class="nav-link">
        Menu User 1
      </a>
      <a href="#" class="nav-link">
        Menu User 2
      </a>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <nav class="navbar navbar-expand navbar-light bg-white shadow-sm rounded mb-4">
      <div class="container-fluid">
        <span class="navbar-text fw-bold">Dashboard User</span>
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

    <!-- Isi Halaman -->
    <div>
      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
