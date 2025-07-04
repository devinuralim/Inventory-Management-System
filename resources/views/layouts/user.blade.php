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
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: var(--primary-color);
    }

    .navbar-brand img {
      height: 36px;
    }

    .nav-link {
      color: #ffffffcc !important;
      transition: 0.3s;
      font-size: 0.95rem;
    }

    .nav-link:hover {
      color: #ffffff !important;
      text-shadow: 0 0 5px #fca311;
    }

    .nav-link.active {
      font-weight: 600;
      color: var(--highlight-color) !important;
    }

    .btn-logout:hover {
      color: #ff4d4d !important;
    }

    main {
      padding-top: 20px;
      padding-bottom: 40px;
    }

    .content-container {
      max-width: 1140px;
      margin: auto;
      padding: 0 15px;
      animation: fadeInSlide 0.8s ease;
    }

    .card {
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
      background-color: var(--card-bg);
      overflow: hidden;
    }

    .card-header {
      background: var(--secondary-color);
      color: white;
      font-weight: 600;
      font-size: 1.05rem;
      padding: 1rem;
    }

    .btn-primary {
      background-color: var(--highlight-color);
      border: none;
    }

    .btn-primary:hover {
      background-color: #ff9f1c;
    }

    footer {
      background-color: var(--secondary-color);
      color: #fff;
      text-align: center;
      padding: 1rem 0;
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

    @media (max-width: 768px) {
      .navbar-brand span {
        font-size: 0.75rem;
      }

      .nav-link {
        font-size: 0.85rem;
        padding: 6px 10px;
      }

      .navbar-toggler {
        border: none;
        padding: 4px 8px;
      }

      main {
        padding-top: 10px;
      }

      .content-container {
        padding: 0 10px;
      }

      .card-header {
        font-size: 1rem;
        padding: 0.75rem 1rem;
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
        <ul class="navbar-nav gap-lg-3">
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
