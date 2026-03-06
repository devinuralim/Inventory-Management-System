@extends('layouts.user')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            /* Warna Utama K2NET */
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
            padding: 2rem 1rem;
        }

        .welcome-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 2rem;
            border: none;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 10;
            border-left: 6px solid var(--highlight); /* Aksen Biru Cyan */
        }

        .welcome-text h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            color: var(--secondary);
            margin-bottom: 0;
        }

        .text-cyan {
            color: var(--highlight) !important;
        }

        .btn-notif {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
            color: var(--primary);
        }

        .btn-notif:hover {
            background: var(--highlight);
            color: white;
            border-color: var(--highlight);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .menu-card {
            background: white;
            border-radius: 20px;
            padding: 1.75rem;
            text-align: left;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: var(--card-shadow);
            text-decoration: none !important;
            display: flex;
            flex-direction: column;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 180, 216, 0.2);
            border-color: var(--highlight);
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

        /* Versi Biru Semua */
        .icon-blue {
            background: #eff6ff;
            color: #2563eb;
        }
        .icon-cyan {
            background: #e0f7fa;
            color: #00b4d8;
        }
        .icon-navy {
            background: #e0e7ff;
            color: #1d3557;
        }

        .menu-card h5 {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .menu-card p {
            font-size: 0.875rem;
            color: #64748b;
            line-height: 1.5;
        }

        .info-banner {
            background: var(--primary);
            color: white;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-right: 5px solid var(--highlight);
        }

        .btn-action-text {
            margin-top: auto;
            font-weight: 700;
            font-size: 0.875rem;
            padding-top: 1rem;
            display: flex;
            align-items: center;
            transition: gap 0.3s;
        }

        .menu-card:hover .btn-action-text {
            gap: 10px;
        }

        @media (max-width: 992px) {
            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .welcome-card {
                flex-direction: column;
                text-align: center;
                padding: 2rem 1.5rem;
                border-left: none;
                border-top: 6px solid var(--highlight);
            }
            .notif-wrapper {
                position: absolute;
                top: 15px;
                right: 15px;
            }
            .menu-grid {
                grid-template-columns: 1fr;
            }
            .welcome-text h1 {
                font-size: 1.5rem;
            }
        }
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
        {{-- Header --}}
        <div class="welcome-card animate__animated animate__fadeIn">
            <div class="welcome-text">
                <div class="text-cyan fw-bold small mb-1">
                    <i class="far fa-clock me-1"></i>
                    {{ Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
                <h1>{{ $greeting }}, {{ Auth::user()->name }}</h1>
                <p>Akses inventaris kantor K2NET dengan mudah dan cepat.</p>
            </div>

            <div class="notif-wrapper dropdown">
                <button class="btn btn-notif shadow-sm" data-bs-toggle="dropdown" data-bs-display="static">
                    <i class="fas fa-bell"></i>
                    @if ($notifPeminjaman->count() > 0)
                        <span
                            class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    @endif
                </button>
                <ul
                    class="dropdown-menu dropdown-menu-end shadow-lg p-2 animate__animated animate__fadeIn border-0"
                    style="border-radius: 15px; width: 300px">
                    <li class="px-3 py-2 fw-bold small text-navy">Status Peminjaman</li>
                    <li><hr class="dropdown-divider" /></li>
                    @forelse ($notifPeminjaman->take(4) as $notif)
                        <li>
                            <a class="dropdown-item rounded-3 p-2 mb-1" href="{{ route('user.peminjaman.index') }}">
                                <div class="d-flex align-items-center">
                                    <div
                                        class="menu-icon icon-cyan mb-0 me-3"
                                        style="width: 35px; height: 35px; font-size: 0.8rem; flex-shrink: 0">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small text-dark">
                                            {{ Str::limit($notif->nama_barang, 20) }}
                                        </div>
                                        <small class="text-muted" style="font-size: 0.7rem">
                                            Status:
                                            <span class="text-info">{{ ucfirst($notif->status) }}</span>
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="text-center py-3 text-muted small">Tidak ada peminjaman aktif</li>
                    @endforelse
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a
                            class="dropdown-item text-center small text-info fw-bold"
                            href="{{ route('user.peminjaman.index') }}">
                            Lihat Semua
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Menu --}}
        <div class="menu-grid animate__animated animate__fadeInUp">
            <a href="{{ route('user.barang.index') }}" class="menu-card">
                <div class="menu-icon icon-blue">
                    <i class="fas fa-boxes"></i>
                </div>
                <h5>Katalog Barang</h5>
                <p>Cari barang inventaris kantor dan lakukan peminjaman secara instan.</p>
                <div class="btn-action-text text-primary">
                    Buka Katalog
                    <i class="fas fa-arrow-right ms-2"></i>
                </div>
            </a>

            <a href="{{ route('user.peminjaman.riwayat') }}" class="menu-card">
                <div class="menu-icon icon-cyan">
                    <i class="fas fa-history"></i>
                </div>
                <h5>Riwayat Pinjam</h5>
                <p>Pantau status pengajuan dan riwayat barang yang pernah kamu pinjam.</p>
                <div class="btn-action-text text-info">
                    Cek Riwayat
                    <i class="fas fa-arrow-right ms-2"></i>
                </div>
            </a>

            <a href="{{ route('user.favorit.index') }}" class="menu-card">
                <div class="menu-icon icon-navy">
                    <i class="fas fa-star"></i>
                </div>
                <h5>Barang Favorit</h5>
                <p>Akses cepat untuk barang-barang yang sering kamu gunakan sehari-hari.</p>
                <div class="btn-action-text text-navy">
                    Lihat Favorit
                    <i class="fas fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>

        {{-- Info --}}
        <div class="info-banner animate__animated animate__fadeInUp" style="background: var(--primary); color: white">
            <div
                class="menu-icon mb-0"
                style="
                    width: 45px;
                    height: 45px;
                    background: rgba(255, 255, 255, 0.1);
                    color: var(--highlight);
                    border: 1px solid rgba(0, 180, 216, 0.3);
                ">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="small">
                <strong class="d-block mb-1" style="color: var(--highlight)">Pemberitahuan Sistem</strong>
                Pastikan untuk melakukan konfirmasi pengembalian barang tepat waktu agar stok tetap akurat.
            </div>
        </div>
    </div>
@endsection
