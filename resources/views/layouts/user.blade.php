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
    :root {
      --primary-color: #1d3557;
      --secondary-color: #457b9d;
      --highlight-color: #fca311;
      --bg-color: #f2f4f8;
      --card-bg: #ffffff;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--bg-color);
      color: #333;
    }

    .navbar {
      background-color: var(--primary-color);
      backdrop-filter: blur(8px);
    }

    .navbar-brand img {
      height: 42px;
    }

    .navbar-brand span {
      margin-left: 10px;
      font-size: 14px;
    }

    .nav-link {
      color: #ffffffcc !important;
      transition: 0.3s;
    }

    .nav-link:hover {
      color: #ffffff !important;
      text-shadow: 0 0 5px #fca311;
    }

    .nav-link.active {
      font-weight: 600;
      color: var(--highlight-color) !important;
      text-shadow: 0 0 8px #fca311;
    }

    .nav-link.btn-logout:hover {
      color: #ff4d4d !important;
    }

    main {
      padding-top: 40px;
      min-height: 100vh;
      position: relative;
    }

    .content-container {
      max-width: 1140px;
      margin: 0 auto;
      animation: fadeInSlide 1s ease;
    }

    .card {
      border-radius: 20px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      background-color: var(--card-bg);
      overflow: hidden;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 16px 40px rgba(0, 0, 0, 0.2);
    }

    .card-header {
      background: var(--secondary-color);
      color: white;
      font-weight: 600;
      font-size: 1.1rem;
      padding: 1rem 1.5rem;
    }

    .btn-primary {
      background-color: var(--highlight-color);
      border: none;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background-color: #ff9f1c;
    }

    .icon-circle {
      width: 50px;
      height: 50px;
      background-color: #e9ecef;
      color: var(--primary-color);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
    }

    footer {
      background-color: var(--secondary-color);
      color: #fff;
      text-align: center;
      padding: 1rem 0;
      margin-top: 60px;
    }

    @keyframes fadeInSlide {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="{{ asset('k2net.png') }}" alt="K2NET">
        <span class="badge bg-warning text-dark ms-2">Inventory</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
              <i class="fas fa-home me-1"></i> Beranda
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.barang.*') ? 'active' : '' }}" href="{{ route('user.barang.index') }}">
              <i class="fas fa-boxes me-1"></i> Barang
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.peminjaman.*') ? 'active' : '' }}" href="{{ route('user.peminjaman.index') }}">
              <i class="fas fa-exchange-alt me-1"></i> Peminjaman
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
              <i class="fas fa-user me-1"></i> Profil
            </a>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="nav-link bg-transparent border-0 text-warning fw-semibold btn-logout">
                <i class="fas fa-sign-out-alt me-1"></i> Keluar
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
    <div class="container content-container">
      @yield('content')
    </div>
  </main>

  <footer>
    <div class="container">
      <small>© {{ now()->year }} K2NET. All rights reserved.</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
