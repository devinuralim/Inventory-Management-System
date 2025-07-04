@extends('layouts.user')

@section('content')
<style>
    body {
        background: linear-gradient(to bottom right, #e3f2fd, #ffffff);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dashboard-header {
        text-align: center;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .dashboard-header h1 {
        font-weight: 700;
        font-size: 1.8rem;
        color: #1d3557;
    }

    .dashboard-header p {
        color: #555;
        font-size: 0.95rem;
        margin-top: -4px;
    }

    .datetime-text {
        font-size: 0.9rem;
        color: #777;
        margin-top: 0.25rem;
    }

    .notification-wrapper {
        position: absolute;
        top: 0;
        right: 0;
        margin: 10px 15px;
    }

    .dropdown-menu {
        font-size: 0.85rem;
        min-width: 270px;
    }

    .card-feature {
        border: none;
        border-radius: 16px;
        padding: 1.2rem;
        height: 100%;
        text-align: center;
        background: linear-gradient(to top right, #ffffff, #f1f9ff);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
    }

    .card-feature:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .card-feature i {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .card-feature h5 {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .btn-feature {
        font-size: 0.8rem;
        padding: 6px 14px;
        margin-top: 8px;
    }

    .announcement-card {
        background: #e8f5e9;
        border-left: 6px solid #4caf50;
        padding: 1rem;
        border-radius: 12px;
        color: #2e7d32;
        margin-top: 1rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
    }

    .announcement-card h6 {
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .tips-card {
        background-color: #fff8e1;
        border-left: 4px solid #ffc107;
        padding: 1rem;
        border-radius: 12px;
        font-size: 0.9rem;
        color: #6d4c41;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }

    @media (max-width: 768px) {
        .dashboard-header h1 {
            font-size: 1.5rem;
        }

        .card-feature {
            margin-bottom: 1rem;
        }

        .notification-wrapper {
            margin-top: -10px;
            margin-right: 5px;
        }
    }
</style>

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    $hour = Carbon::now()->hour;
    $greeting = $hour >= 4 && $hour < 10 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));

    $notifPeminjaman = \App\Models\Peminjaman::where('nama_peminjam', auth()->user()->name)
                        ->whereIn('status', ['dipinjam', 'menunggu konfirmasi'])
                        ->get();

    $pengumuman = \App\Models\Pengumuman::where('tampilkan', true)->latest()->first();
@endphp

<div class="container min-vh-100 py-3">

    {{-- Header --}}
    <div class="dashboard-header animate__animated animate__fadeInDown">

        {{-- Notifikasi --}}
        <div class="notification-wrapper dropdown">
            <button class="btn btn-light position-relative shadow-sm" data-bs-toggle="dropdown">
                <i class="fas fa-bell text-dark"></i>
                @if ($notifPeminjaman->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $notifPeminjaman->count() }}
                    </span>
                @endif
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2">
                <li class="dropdown-header fw-bold text-dark mb-1">Notifikasi</li>
                @forelse ($notifPeminjaman->take(5) as $notif)
                    <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-center small text-dark" href="{{ route('user.peminjaman.index') }}">
                            <span>
                                <i class="fas fa-box me-1 text-primary"></i>{{ $notif->nama_barang }}
                                <span class="text-muted">({{ $notif->jumlah }}x)</span>
                            </span>
                            <span class="badge {{ $notif->status == 'dipinjam' ? 'bg-danger' : 'bg-warning text-dark' }}">
                                {{ ucfirst($notif->status) }}
                            </span>
                        </a>
                    </li>
                @empty
                    <li class="text-center small text-muted p-2">Tidak ada notifikasi</li>
                @endforelse
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-center small" href="{{ route('user.peminjaman.index') }}">Lihat semua</a></li>
            </ul>
        </div>

        <h1>👋 {{ $greeting }}, {{ Auth::user()->name }}</h1>
        <p>Selamat datang di sistem peminjaman barang!</p>
        <div class="datetime-text">
            {{ Carbon::now()->translatedFormat('l, d F Y — H:i') }} WIB
        </div>

        {{-- Pengumuman --}}
        @if ($pengumuman)
            <div class="announcement-card animate__animated animate__fadeInDown">
                <h6><i class="fas fa-bullhorn me-1"></i> {{ $pengumuman->judul }}</h6>
                <div>{{ $pengumuman->isi }}</div>
            </div>
        @endif
    </div>

    {{-- Fitur --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-4 animate__animated animate__fadeInUp">
        <div class="col">
            <div class="card-feature">
                <i class="fas fa-box text-primary"></i>
                <h5 class="text-primary">Barang</h5>
                <p>Lihat semua barang yang tersedia untuk dipinjam.</p>
                <a href="{{ route('user.barang.index') }}" class="btn btn-outline-primary btn-feature">Lihat Barang</a>
            </div>
        </div>
        <div class="col">
            <div class="card-feature">
                <i class="fas fa-history text-success"></i>
                <h5 class="text-success">Riwayat</h5>
                <p>Riwayat semua barang yang pernah kamu pinjam.</p>
                <a href="{{ route('user.peminjaman.riwayat') }}" class="btn btn-outline-success btn-feature">Lihat Riwayat</a>
            </div>
        </div>
        <div class="col">
            <div class="card-feature">
                <i class="fas fa-star text-warning"></i>
                <h5 class="text-warning">Favorit</h5>
                <p>Barang favorit yang kamu tandai.</p>
                <a href="{{ route('user.favorit.index') }}" class="btn btn-outline-warning btn-feature">Lihat Favorit</a>
            </div>
        </div>
    </div>

    {{-- Tips --}}
    <div class="row justify-content-center animate__animated animate__fadeInUp">
        <div class="col-md-10 col-lg-8">
            <div class="tips-card">
                <i class="fas fa-lightbulb me-2 text-warning"></i>
                <strong>Tips Hari Ini:</strong> Jangan lupa kembalikan barang tepat waktu ya! Cek di menu <strong>Peminjaman Barang</strong>.
            </div>
        </div>
    </div>
</div>
@endsection
