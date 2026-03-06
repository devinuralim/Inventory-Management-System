@extends('layouts.user')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary: #1d3557;
            --highlight: #00b4d8;
            --secondary: #64748b;
            --bg-main: #f8fafc;
            --card-shadow: 0 10px 25px -5px rgba(29, 53, 87, 0.08), 0 8px 10px -6px rgba(29, 53, 87, 0.05);
        }

        body {
            background-color: var(--bg-main);
            font-family: 'Poppins', sans-serif;
        }

        .dashboard-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 1.5rem 1rem;
        }

        /* --- Header Welcome (Responsive) --- */
        .welcome-header {
            margin-bottom: 2rem;
            position: relative;
            z-index: 10;
        }

        /* Desktop: Pakai Card Putih & Border */
        @media (min-width: 769px) {
            .welcome-header {
                background: #ffffff;
                border-radius: 20px;
                padding: 2.5rem 2rem;
                box-shadow: var(--card-shadow);
                border-left: 6px solid var(--highlight);
            }
        }

        /* Mobile: Tanpa Border & Background Putih */
        @media (max-width: 768px) {
            .welcome-header {
                background: transparent;
                border: none;
                box-shadow: none;
                padding: 0.5rem;
            }
            .welcome-text h1 {
                font-size: 1.5rem !important;
            }
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .date-text {
            color: var(--secondary);
            font-weight: 500;
            font-size: 0.85rem;
        }

        .welcome-text h1 {
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        /* --- Notifikasi & Dropdown (Fixed for Mobile) --- */
        .btn-notif-new {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: var(--primary);
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .dropdown-menu-notif {
            border-radius: 15px !important;
            width: 280px;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
            padding: 8px !important;
            /* Memastikan dropdown tidak terpotong di HP */
            position: absolute; 
            margin-top: 5px !important;
        }

        /* Memastikan link "Lihat Semua" terlihat jelas */
        .view-all-link {
            color: var(--primary) !important;
            font-weight: 700 !important;
            text-align: center;
            display: block;
            padding: 10px;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .view-all-link:hover {
            color: var(--highlight) !important;
            background-color: #f8fafc;
            border-radius: 8px;
        }

        /* --- Menu Grid --- */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .menu-card {
            background: white;
            border-radius: 20px;
            padding: 1.75rem;
            transition: 0.3s;
            border: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: var(--card-shadow);
            text-decoration: none !important;
            display: flex;
            flex-direction: column;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            border-color: var(--highlight);
        }

        .menu-card h5 {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .menu-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .icon-blue { background: #eff6ff; color: #2563eb; }
        .icon-cyan { background: #e0f7fa; color: #00b4d8; }
        .icon-navy { background: #e0e7ff; color: #1d3557; }

        .btn-action-text {
            margin-top: auto;
            font-weight: 700;
            font-size: 0.875rem;
            color: var(--primary);
            padding-top: 1rem;
        }

        .pulse-red {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 10px;
            height: 10px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
        }

        @media (max-width: 992px) { .menu-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .menu-grid { grid-template-columns: 1fr; } }
    </style>

    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
        $hour = Carbon::now()->hour;
        $greeting = $hour >= 4 && $hour < 10 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));

        $notifPeminjaman = \App\Models\Peminjaman::where('nama_peminjam', auth()->user()->name)
            ->whereIn('status', ['dipinjam', 'menunggu konfirmasi'])
            ->latest()
            ->get();
    @endphp

    <div class="dashboard-container">
        <div class="welcome-header animate__animated animate__fadeIn">
            <div class="header-top">
                <div class="date-text">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
                
                <div class="dropdown">
                    <div class="notif-badge-container" data-bs-toggle="dropdown" style="cursor: pointer">
                        <div class="btn-notif-new shadow-sm">
                            <i class="fas fa-bell"></i>
                        </div>
                        @if ($notifPeminjaman->count() > 0)
                            <div class="pulse-red"></div>
                        @endif
                    </div>
                    
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 dropdown-menu-notif">
                        <li class="px-3 py-2 fw-bold small text-dark">Pemberitahuan</li>
                        <li><hr class="dropdown-divider"></li>
                        
                        @forelse ($notifPeminjaman->take(3) as $notif)
                            <li>
                                <a class="dropdown-item p-2 mb-1" href="{{ route('user.peminjaman.index') }}" style="border-radius: 10px;">
                                    <div class="d-flex align-items-center">
                                        <div class="menu-icon icon-cyan mb-0 me-3" style="width: 35px; height: 35px; font-size: 0.8rem; flex-shrink: 0;">
                                            <i class="fas fa-box"></i>
                                        </div>
                                        <div style="white-space: normal;">
                                            <div class="fw-bold text-dark" style="font-size: 0.8rem; line-height: 1.2;">{{ Str::limit($notif->nama_barang, 20) }}</div>
                                            <small class="text-muted" style="font-size: 0.7rem;">Status: <span class="text-primary fw-bold">{{ $notif->status }}</span></small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="text-center py-4 text-muted small">Tidak ada aktivitas.</li>
                        @endforelse
                        
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="view-all-link" href="{{ route('user.peminjaman.index') }}">
                                Lihat Semua Riwayat
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="welcome-text">
                <h1>{{ $greeting }}, {{ Auth::user()->name }}</h1>
                <p>Kelola kebutuhan inventaris Anda di satu tempat.</p>
            </div>
        </div>

        <div class="menu-grid animate__animated animate__fadeInUp">
            <a href="{{ route('user.barang.index') }}" class="menu-card">
                <div class="menu-icon icon-blue">
                    <i class="fas fa-boxes"></i>
                </div>
                <h5>Katalog Barang</h5>
                <p>Cari barang inventaris kantor dan lakukan peminjaman secara instan.</p>
                <div class="btn-action-text">
                    Buka Katalog <i class="fas fa-arrow-right ms-2"></i>
                </div>
            </a>

            <a href="{{ route('user.peminjaman.riwayat') }}" class="menu-card">
                <div class="menu-icon icon-cyan">
                    <i class="fas fa-history"></i>
                </div>
                <h5>Riwayat Pinjam</h5>
                <p>Pantau status pengajuan dan riwayat barang yang pernah dipinjam.</p>
                <div class="btn-action-text">
                    Cek Riwayat <i class="fas fa-arrow-right ms-2"></i>
                </div>
            </a>

            <a href="{{ route('user.favorit.index') }}" class="menu-card">
                <div class="menu-icon icon-navy">
                    <i class="fas fa-star"></i>
                </div>
                <h5>Barang Favorit</h5>
                <p>Akses cepat untuk barang-barang yang sering kamu gunakan.</p>
                <div class="btn-action-text">
                    Lihat Favorit <i class="fas fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>
    </div>
@endsection