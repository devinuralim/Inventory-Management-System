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
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f4f6f9;
                margin: 0;
            }
            .sidebar {
                height: 100vh;
                background: #0f172a;
                color: #fff;
                position: fixed;
                width: 260px;
                left: 0;
                top: 0;
                transition: transform 0.3s ease;
                z-index: 1000;
                display: grid;
                grid-template-rows: 1fr auto;
                box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
            }
            .sidebar.hidden {
                transform: translateX(-100%);
            }
            .sidebar-menu-wrapper {
                overflow-y: auto;
                padding: 20px 18px;
                min-height: 0;
            }
            .sidebar-footer-fixed {
                flex-shrink: 0;
                padding: 15px 18px;
                border-top: 1px solid rgba(255, 255, 255, 0.05);
            }
            .sidebar .nav-link {
                color: #94a3b8;
                margin-bottom: 4px;
                display: flex;
                align-items: center;
                gap: 12px;
                font-size: 0.9rem;
                padding: 10px 12px;
                border-radius: 8px;
                transition: 0.2s;
            }
            .sidebar .nav-link:hover {
                background-color: rgba(255, 255, 255, 0.05);
                color: #fff;
            }
            .sidebar .nav-link.active {
                background-color: #3b82f6;
                color: #fff;
            }
            .main-content {
                margin-left: 260px;
                padding: 25px;
                transition: margin-left 0.3s ease;
            }
            .main-content.full-width {
                margin-left: 0;
            }
            .toggle-btn {
                position: fixed;
                top: 15px;
                left: 15px;
                background-color: #3b82f6;
                color: #fff;
                border: none;
                padding: 8px 12px;
                border-radius: 8px;
                cursor: pointer;
                z-index: 1101;
            }
            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-100%);
                }
                .sidebar.show {
                    transform: translateX(0);
                }
                .main-content {
                    margin-left: 0 !important;
                }
            }
        </style>
    </head>
    <body>
        <button class="toggle-btn" id="toggleSidebarBtn">&#9776;</button>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-menu-wrapper">
                <div class="text-center mb-4">
                    <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 40px" />
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

                    {{-- Menu Reporting --}}
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

                    <div
                        class="collapse {{ request()->routeIs('admin.laporan.*', 'admin.riwayat.*') ? 'show' : '' }}"
                        id="laporanMenu">
                        <a
                            href="{{ route('admin.laporan.index') }}"
                            class="nav-link ps-4 {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                            <i class="fas fa-triangle-exclamation me-2"></i>
                            Kondisi Barang
                            @if (isset($notifikasiLaporan) && $notifikasiLaporan > 0)
                                <span class="badge bg-warning text-dark ms-auto">{{ $notifikasiLaporan }}</span>
                            @endif
                        </a>
                        <a
                            href="{{ route('admin.riwayat.index') }}"
                            class="nav-link ps-4 {{ request()->routeIs('admin.riwayat.*') ? 'active' : '' }}">
                            <i class="fas fa-history me-2"></i>
                            Riwayat Peminjaman
                        </a>
                    </div>
                </nav>
            </div>

            <div class="sidebar-footer-fixed">
                <a href="{{ route('admin.profile') }}" class="nav-link">
                    <i class="fas fa-user-circle"></i>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="nav-link w-100"
                        style="background: none; border: none; cursor: pointer; color: #f87171">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
                <div style="font-size: 0.7rem; color: #64748b; text-align: center; margin-top: 10px">
                    &copy; {{ date('Y') }} K2NET
                </div>
            </div>
        </div>

        <div class="main-content" id="mainContent">
            @yield('content')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const btn = document.getElementById('toggleSidebarBtn');
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('mainContent');

            btn.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    sidebar.classList.toggle('show');
                } else {
                    sidebar.classList.toggle('hidden');
                    main.classList.toggle('full-width');
                }
            });
        </script>
    </body>
</html>
