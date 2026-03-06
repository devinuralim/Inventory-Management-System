<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard Admin</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

        <style>
            <style > body {
                font-family: 'Poppins', sans-serif;
                background-color: #f4f6f9;
                margin: 0;
                padding: 0;
            }

            /* ================= SIDEBAR ================= */
            .sidebar {
                height: 100vh;
                background: linear-gradient(to bottom, #1d3557, #0d1b2a);
                color: #fff;
                padding: 20px 18px;
                position: fixed;
                width: 300px;
                left: 0;
                top: 0;
                transition: transform 0.3s ease;
                z-index: 1000;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                box-shadow: 2px 0 15px rgba(0, 0, 0, 0.15);
            }

            .sidebar.hidden {
                transform: translateX(-100%);
            }

            .sidebar .nav-link {
                color: #e0e0e0;
                margin-bottom: 4px;
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 0.92rem;
                padding: 8px 12px;
                border-radius: 6px;
                transition: all 0.2s ease;
            }

            .sidebar .nav-link:hover {
                background-color: rgba(255, 255, 255, 0.08);
            }

            .sidebar .nav-link.active {
                background-color: #457b9d;
                color: #fff;
            }

            .sidebar-footer {
                font-size: 0.8rem;
                color: #bbb;
                text-align: center;
                padding-top: 15px;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* ================= SUBMENU ================= */
            .collapse .nav-link {
                font-size: 0.85rem;
                padding: 6px 12px;
                margin-bottom: 2px;
                opacity: 0.9;
            }

            .collapse .nav-link:hover {
                background-color: rgba(255, 255, 255, 0.06);
            }

            /* ================= MAIN CONTENT ================= */
            .main-content {
                margin-left: 250px; /* Sesuai sidebar */
                padding: 25px;
                transition: margin-left 0.3s ease;
            }

            .main-content.full-width {
                margin-left: 0;
            }

            /* ================= TOGGLE BUTTON ================= */
            .toggle-btn {
                position: fixed;
                top: 20px;
                left: 15px;
                background-color: #457b9d;
                color: #fff;
                border: none;
                padding: 6px 10px;
                border-radius: 8px;
                cursor: pointer;
                z-index: 1101;
                font-size: 1.1rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            }

            .toggle-btn:hover {
                background-color: #1d3557;
            }

            .sidebar .nav-bottom {
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                padding-top: 10px;
            }

            .sidebar .nav-bottom form,
            .sidebar .nav-bottom .nav-link {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 0.9rem;
                margin-bottom: 6px;
                color: #fff;
            }

            .sidebar .nav-bottom button {
                background: none;
                border: none;
                color: #fff;
                padding: 8px 12px;
                width: 100%;
                text-align: left;
            }

            /* ================= RESPONSIVE ================= */
            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-100%);
                    width: 220px;
                    padding: 60px 15px 20px;
                }

                .sidebar.show {
                    transform: translateX(0);
                }

                .main-content {
                    margin-left: 0 !important;
                    padding: 20px;
                }

                .toggle-btn {
                    top: 15px;
                    left: 10px;
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
                    <img src="{{ asset('k2net.png') }}" alt="K2NET Logo" style="height: 50px" />
                </div>

                <div class="mb-3">
                    <p class="mb-1 small text-light opacity-75">Selamat datang, Admin</p>
                    <strong class="d-block mb-3">{{ Auth::user()->name }}</strong>
                </div>

                <nav class="nav flex-column">
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>

                    <a
                        href="{{ route('admin.barangs') }}"
                        class="nav-link {{ request()->routeIs('admin.barangs') ? 'active' : '' }}">
                        <i class="fas fa-box-open"></i>
                        Data Barang
                    </a>

                    <a
                        href="{{ route('admin.karyawans.index') }}"
                        class="nav-link {{ request()->routeIs('admin.karyawans.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        Data Karyawan
                    </a>

                    <a
                        href="{{ route('admin.peminjaman.index') }}"
                        class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                        <i class="fas fa-handshake"></i>
                        Data Peminjam
                        @if (isset($notifikasiCount) && $notifikasiCount > 0)
                            <span class="badge bg-danger ms-auto">{{ $notifikasiCount }}</span>
                        @endif
                    </a>

                    <!-- REPORTING -->
                    <a
                        class="nav-link d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse"
                        href="#laporanMenu">
                        <span>
                            <i class="fas fa-chart-line me-2"></i>
                            Reporting
                        </span>

                        <i class="fas fa-chevron-down"></i>
                    </a>

                    <div class="collapse {{ request()->routeIs('admin.laporan.*') ? 'show' : '' }}" id="laporanMenu">
                        <a
                            href="{{ route('admin.laporan.index') }}"
                            class="nav-link ps-4 {{ request()->routeIs('admin.laporan.index') ? 'active' : '' }}">
                            <i class="fas fa-triangle-exclamation me-2"></i>
                            Kondisi Barang

                            @if (isset($notifikasiLaporan) && $notifikasiLaporan > 0)
                                <span class="badge bg-danger ms-auto">{{ $notifikasiLaporan }}</span>
                            @endif
                        </a>
                        
                    </div>
                </nav>
            </div>

            <div class="nav-bottom">
                <a href="{{ route('admin.profile') }}" class="nav-link">
                    <i class="fas fa-user"></i>
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>

                <div class="sidebar-footer">© 2025 K2NET</div>
            </div>
        </div>

        <div class="main-content" id="mainContent">
            @yield('content')
        </div>

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
    </body>
</html>
