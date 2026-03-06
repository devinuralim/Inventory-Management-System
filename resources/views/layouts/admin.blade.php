<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>K2NET | Admin</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet" />

        <style>
            :root {
                --sidebar-bg: #0f172a;
                --sidebar-hover: rgba(255, 255, 255, 0.08);
                --primary-blue: #3b82f6;
                --text-muted: #94a3b8;
                --bg-main: #f8fafc;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: var(--bg-main);
                margin: 0;
                overflow-x: hidden;
            }

            /* --- Sidebar Style --- */
            .sidebar {
                height: 100vh;
                background: var(--sidebar-bg);
                color: #fff;
                position: fixed;
                width: 260px;
                left: 0;
                top: 0;
                transition: all 0.3s ease;
                z-index: 1050;
                display: flex;
                flex-direction: column;
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            }

            .sidebar.hidden {
                transform: translateX(-260px);
            }

            .sidebar-header {
                padding: 15px 20px;
                text-align: center;
                flex-shrink: 0;
            }

            .sidebar-menu-wrapper {
                flex-grow: 1;
                overflow-y: auto;
                padding: 0 14px;
            }

            .sidebar .nav-link {
                color: var(--text-muted);
                margin-bottom: 5px;
                display: flex;
                align-items: center;
                font-size: 0.9rem;
                padding: 12px 15px;
                border-radius: 10px;
                transition: 0.2s;
                text-decoration: none;
                position: relative; /* Penting untuk posisi badge */
            }

            .sidebar .nav-link i.fa-fw {
                margin-right: 12px;
                font-size: 1.1rem;
                text-align: center;
                width: 20px;
            }

            .sidebar .nav-link:hover {
                background-color: var(--sidebar-hover);
                color: #fff;
            }

            .sidebar .nav-link.active {
                background-color: var(--primary-blue);
                color: #fff !important;
            }

            /* --- Badge Notifikasi --- */
            .badge-notif {
                background-color: #ef4444;
                color: white;
                font-size: 0.7rem;
                font-weight: 700;
                padding: 2px 6px;
                border-radius: 6px;
                margin-left: auto;
                min-width: 18px;
                text-align: center;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .menu-label {
                font-size: 0.75rem;
                text-transform: uppercase;
                color: #475569;
                margin: 15px 0 10px 15px;
                font-weight: 600;
                letter-spacing: 0.05em;
            }

            /* --- Footer Sidebar --- */
            .sidebar-footer {
                padding: 15px;
                border-top: 1px solid rgba(255, 255, 255, 0.05);
                flex-shrink: 0;
                background: rgba(0, 0, 0, 0.2);
            }

            .btn-logout {
                width: 100%;
                border: none;
                background: transparent;
                color: #ef4444 !important;
                padding: 12px 15px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                font-size: 0.9rem;
                transition: 0.2s;
                font-family: 'Poppins', sans-serif;
            }

            .btn-logout:hover {
                background-color: rgba(239, 68, 68, 0.1);
            }

            .copyright-text {
                font-size: 0.65rem;
                color: #475569;
                margin-top: 10px;
                text-align: center;
                line-height: 1.4;
            }

            /* --- Main Content --- */
            .main-content {
                margin-left: 260px;
                padding: 30px;
                transition: all 0.3s ease;
                min-height: 100vh;
            }

            .main-content.full-width {
                margin-left: 0;
            }

            .toggle-btn {
                position: fixed;
                top: 15px;
                left: 15px;
                background-color: var(--primary-blue);
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
                    padding: 20px;
                    padding-top: 70px;
                }
            }
        </style>
    </head>
    <body>
        @php
            // Hitung Peminjaman yang butuh aksi
            $countPeminjaman = \App\Models\Peminjaman::whereIn('status', ['menunggu konfirmasi', 'dipinjam'])->count();

            // Hitung Laporan Kondisi Barang yang statusnya 'menunggu' atau 'diproses'
            // Saya tambahkan 'diproses' sesuai permintaan kamu tadi
            $countLaporan = \App\Models\LaporanBarang::whereIn('status', ['menunggu', 'diproses'])->count();
        @endphp

        <button class="toggle-btn" id="toggleSidebarBtn"><i class="fas fa-bars"></i></button>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('k2net.png') }}" alt="Logo" style="height: 40px" />
            </div>

            <div class="sidebar-menu-wrapper">
                <nav class="nav flex-column">
                    <div class="menu-label">Menu Utama</div>

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie fa-fw"></i>
                        <span>Dashboard</span>
                    </a>

                    <a
                        href="{{ route('admin.barangs') }}"
                        class="nav-link {{ request()->routeIs('admin.barangs*') ? 'active' : '' }}">
                        <i class="fas fa-boxes-stacked fa-fw"></i>
                        <span>Data Barang</span>
                    </a>

                    <a
                        href="{{ route('admin.karyawans.index') }}"
                        class="nav-link {{ request()->routeIs('admin.karyawans*') ? 'active' : '' }}">
                        <i class="fas fa-users fa-fw"></i>
                        <span>Data Karyawan</span>
                    </a>

                    <a
                        href="{{ route('admin.peminjaman.index') }}"
                        class="nav-link {{ request()->routeIs('admin.peminjaman*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt fa-fw"></i>
                        <span>Peminjaman</span>
                        @if ($countPeminjaman > 0)
                            <span class="badge-notif">{{ $countPeminjaman }}</span>
                        @endif
                    </a>

                    <div class="menu-label">Laporan</div>

                    <a
                        class="nav-link d-flex align-items-center"
                        data-bs-toggle="collapse"
                        href="#reportingSubmenu"
                        role="button"
                        aria-expanded="{{ request()->routeIs('admin.laporan*', 'admin.riwayat*') ? 'true' : 'false' }}">
                        <i class="fas fa-file-invoice fa-fw"></i>
                        <span class="flex-grow-1">Reporting</span>
                        @if ($countLaporan > 0)
                            <span class="badge-notif me-2" style="background-color: var(--highlight-color)">!</span>
                        @endif

                        <i class="fas fa-chevron-down fa-xs ms-auto"></i>
                    </a>

                    <div
                        class="collapse {{ request()->routeIs('admin.laporan*', 'admin.riwayat*') ? 'show' : '' }}"
                        id="reportingSubmenu">
                        <a
                            href="{{ route('admin.laporan.index') }}"
                            class="nav-link ps-5 {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                            <i class="fas fa-info-circle fa-fw"></i>
                            <span>Kondisi Barang</span>
                            @if ($countLaporan > 0)
                                <span class="badge-notif">{{ $countLaporan }}</span>
                            @endif
                        </a>
                        <a
                            href="{{ route('admin.riwayat.index') }}"
                            class="nav-link ps-5 {{ request()->routeIs('admin.riwayat*') ? 'active' : '' }}">
                            <i class="fas fa-history fa-fw"></i>
                            <span>Riwayat Pinjam</span>
                        </a>
                    </div>
                </nav>
            </div>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt fa-fw me-3"></i>
                        <span>Logout</span>
                    </button>
                </form>

                <div class="copyright-text">
                    &copy; {{ date('Y') }}
                    <b>K2NET</b>
                    <br />
                    Inventory Management System
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

            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !btn.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        </script>
    </body>
</html>
