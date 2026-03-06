<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>K2NET | Inventory System</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <style>
            :root {
                --primary-color: #1d3557;
                --secondary-color: #457b9d;
                /* GANTI: Orange jadi Biru Cyan khas K2NET */
                --highlight-color: #00b4d8; 
                --bg-color: #f8fafc;
                --card-bg: #ffffff;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: var(--bg-color);
                color: #334155;
                margin: 0;
                overflow-x: hidden;
            }

            /* --- Navbar Styling --- */
            .navbar {
                background-color: var(--primary-color) !important;
                padding: 0.8rem 0;
                /* Border bawah ganti biru */
                border-bottom: 3px solid var(--highlight-color);
            }

            .navbar-brand img {
                height: 40px;
                filter: drop-shadow(0 0 2px rgba(255,255,255,0.2));
            }

            .nav-link {
                color: rgba(255, 255, 255, 0.8) !important;
                font-weight: 500;
                padding: 0.5rem 1rem !important;
                transition: all 0.3s ease;
                border-radius: 8px;
            }

            .nav-link:hover {
                color: #ffffff !important;
                background: rgba(255, 255, 255, 0.1);
            }

            .nav-link.active {
                /* Text menu aktif jadi biru */
                color: var(--highlight-color) !important;
                background: rgba(0, 180, 216, 0.1);
            }

            .btn-logout {
                color: #fecaca !important;
                transition: 0.3s;
            }

            .btn-logout:hover {
                color: #ef4444 !important;
                background: rgba(239, 68, 68, 0.1);
            }

            /* --- Main Content --- */
            main {
                min-height: 85vh;
                padding-top: 30px;
                padding-bottom: 50px;
            }

            /* --- Responsive Mobile --- */
            @media (max-width: 991px) {
                .navbar-collapse {
                    background: var(--primary-color);
                    padding: 1rem;
                    border-radius: 12px;
                    margin-top: 1rem;
                    box-shadow: 0 10px 15px rgba(0,0,0,0.1);
                }
            }

            .page-transition {
                animation: fadeIn 0.5s ease-out;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* Badge inventory agar warnanya senada */
            .badge-custom {
                background-color: var(--highlight-color);
                color: white;
                font-size: 0.65rem;
                padding: 2px 6px;
                border-radius: 4px;
            }
        </style>
    </head>
    <body>
        
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('user.dashboard') }}">
                    <img src="{{ asset('k2net.png') }}" alt="K2NET Logo" />
                    <div class="ms-2 d-none d-sm-block">
                        <span class="fw-bold text-white mb-0 d-block" style="line-height: 1;">K2NET</span>
                        <span class="badge-custom">INVENTORY</span>
                    </div>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto gap-1">
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
                                <i class="fas fa-exchange-alt me-1"></i> Pinjam
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('user/favorit*') ? 'active' : '' }}" href="{{ route('user.favorit.index') }}">
                                <i class="fas fa-star me-1"></i> Favorit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.laporan.*') ? 'active' : '' }}" href="{{ route('user.laporan.index') }}">
                                <i class="fas fa-flag me-1"></i> Laporan
                            </a>
                        </li>
                        <li class="nav-item border-lg-start ms-lg-2 ps-lg-2">
                            <a class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                                <i class="fas fa-user-circle me-1"></i> Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link bg-transparent border-0 btn-logout w-100 text-start">
                                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="page-transition">
            @yield('content')
        </main>

        <footer class="py-4 bg-white border-top mt-auto">
            <div class="container text-center">
                <p class="text-muted small mb-0">&copy; {{ date('Y') }} <strong>K2NET</strong> Inventory System. All rights reserved.</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>
    </body>
</html>