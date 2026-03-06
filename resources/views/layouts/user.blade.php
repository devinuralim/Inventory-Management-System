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
                --highlight-color: #00b4d8; 
                --bg-color: #f8fafc;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: var(--bg-color);
                margin: 0;
            }

            /* --- Navbar Dasar --- */
            .navbar {
                background-color: var(--primary-color) !important;
                border-bottom: 3px solid var(--highlight-color);
                padding: 0.6rem 0;
            }

            .navbar-brand img { 
                height: 45px; 
                width: auto;
                object-fit: contain;
            }

            .nav-link {
                color: rgba(255, 255, 255, 0.7) !important; /* Warna default (sama semua) */
                font-weight: 500;
                border-radius: 8px;
                padding: 0.6rem 1rem !important;
                transition: 0.3s;
            }

            /* Saat Menu Utama Aktif atau Di-hover */
            .nav-link.active, .nav-link:hover, .show > .nav-link {
                color: var(--highlight-color) !important;
                background: rgba(255, 255, 255, 0.05);
            }

            /* --- Dropdown Desktop --- */
            @media (min-width: 992px) {
                .dropdown-menu {
                    background-color: white;
                    border: none;
                    border-radius: 12px;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                    padding: 0.5rem;
                    margin-top: 10px !important;
                }
                .dropdown-item {
                    color: var(--primary-color); /* Warna teks item di desktop */
                    font-weight: 500;
                    border-radius: 8px;
                    padding: 0.7rem 1rem;
                }
                .dropdown-item:hover, .dropdown-item.active {
                    background: #f0f9ff;
                    color: var(--highlight-color) !important;
                }
            }

            /* --- RESPONSIVE HP (Mobile) --- */
            @media (max-width: 991.98px) {
                .navbar-collapse {
                    background: var(--primary-color);
                    margin-top: 10px;
                    padding: 15px;
                    border-radius: 12px;
                    border: 1px solid rgba(255,255,255,0.1);
                }

                .dropdown-menu {
                    background-color: transparent;
                    border: none;
                    padding-left: 1.5rem;
                    margin: 0;
                }

                /* Warna font item dropdown disamakan dengan menu lain (Putih Transparan) */
                .dropdown-item {
                    color: rgba(255, 255, 255, 0.7) !important;
                    font-weight: 500;
                    padding: 0.6rem 0;
                    background: transparent !important;
                }

                /* Baru jadi Biru kalau di-klik/aktif */
                .dropdown-item.active, .dropdown-item:hover {
                    color: var(--highlight-color) !important;
                }

                .dropdown-divider { border-color: rgba(255,255,255,0.1); }
                .nav-item { margin-bottom: 5px; }
            }

            .dropdown-item i {
                width: 25px;
                /* Icon ikut warna teks kecuali kalau aktif */
                color: inherit; 
            }

            .dropdown-item.active i, .dropdown-item:hover i {
                color: var(--highlight-color);
            }

            .btn-logout { color: #fecaca !important; }
            .btn-logout:hover { color: #ef4444 !important; }

            main { min-height: 80vh; padding: 20px 0; }
        </style>
    </head>
    <body>
        
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                    <img src="{{ asset('k2net.png') }}" alt="Logo K2NET" />
                </a>

                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                                <i class="fas fa-home me-1"></i> Beranda
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('user.barang.*') || request()->is('user/favorit*') ? 'active' : '' }}" 
                               href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-boxes me-1"></i> Barang
                            </a>
                            <ul class="dropdown-menu animate__animated animate__fadeIn">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('user.barang.index') ? 'active' : '' }}" href="{{ route('user.barang.index') }}">
                                        <i class="fas fa-list-ul me-1"></i> Daftar Barang
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item {{ request()->is('user/favorit*') ? 'active' : '' }}" href="{{ route('user.favorit.index') }}">
                                        <i class="fas fa-star me-1"></i> Barang Favorit
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('user.peminjaman.*') ? 'active' : '' }}" 
                               href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-exchange-alt me-1"></i> Pinjam
                            </a>
                            <ul class="dropdown-menu animate__animated animate__fadeIn">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('user.peminjaman.index') ? 'active' : '' }}" href="{{ route('user.peminjaman.index') }}">
                                        <i class="fas fa-plus-circle me-1"></i> Pinjam Barang
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('user.peminjaman.riwayat') ? 'active' : '' }}" href="{{ route('user.peminjaman.riwayat') }}">
                                        <i class="fas fa-history me-1"></i> Riwayat Pinjam
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.laporan.*') ? 'active' : '' }}" href="{{ route('user.laporan.index') }}">
                                <i class="fas fa-flag me-1"></i> Laporan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                                <i class="fas fa-user-circle me-1"></i> Profil
                            </a>
                        </li>

                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link bg-transparent border-0 btn-logout text-start w-100">
                                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="animate__animated animate__fadeIn">
            <div class="container">
                @yield('content')
            </div>
        </main>

        <footer class="py-4 bg-white border-top text-center mt-5">
            <p class="text-muted small mb-0">&copy; {{ date('Y') }} <strong>K2NET</strong> Inventory. All rights reserved.</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>