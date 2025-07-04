@extends('layouts.user')

@section('content')
<style>
    body {
        background: linear-gradient(to bottom right, #e3f2fd, #ffffff);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .dashboard-header {
        padding-top: -10px;
        padding-bottom: 10px;
        text-align: center;
    }
    .dashboard-header h1 {
        font-weight: 700;
        font-size: 1.8rem;
        color: #1d3557;
        margin-bottom: 6px;
    }
    .dashboard-header p {
        color: #555;
        font-size: 0.95rem;
        margin-bottom: 10px;
    }
    .section-divider {
        width: 60px;
        height: 4px;
        background-color: #1d3557;
        border-radius: 2px;
        margin: 0 auto 20px;
    }

    .card-feature {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease-in-out;
        padding: 1rem;
        text-align: center;
        height: 100%;
    }
    .card-feature:hover {
        transform: scale(1.02);
    }
    .card-feature i {
        font-size: 1.7rem;
        margin-bottom: 8px;
    }
    .card-feature h5 {
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 1rem;
    }
    .card-feature p {
        font-size: 0.85rem;
        color: #555;
    }

    .btn-feature {
        font-size: 0.8rem;
        margin-top: 10px;
        padding: 5px 12px;
    }

    .tips-card {
        background-color: #fffde7;
        border-left: 4px solid #fbc02d;
        padding: 1rem;
        border-radius: 12px;
        font-size: 0.85rem;
        color: #5d4037;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    @media (max-width: 768px) {
        .dashboard-header h1 {
            font-size: 1.5rem;
        }
        .card-feature {
            margin-bottom: 1rem;
        }
    }
</style>

<div class="container min-vh-100 pt-2 pb-4">

    {{-- Header Paling Atas --}}
    <div class="dashboard-header animate__animated animate__fadeInDown">
        <h1>👋 Halo, {{ Auth::user()->name }}</h1>
        <p>Selamat datang di sistem peminjaman barang!</p>
        <div class="section-divider"></div>
    </div>

    {{-- Notifikasi --}}
    @php
        $notifPeminjaman = \App\Models\Peminjaman::where('nama_peminjam', auth()->user()->name)
            ->whereIn('status', ['dipinjam', 'menunggu konfirmasi'])
            ->get();
    @endphp
    @if ($notifPeminjaman->count() > 0)
        <div class="alert alert-warning shadow-sm text-start animate__animated animate__fadeIn mb-4">
            <i class="fas fa-bell me-2"></i>
            Kamu memiliki <strong>{{ $notifPeminjaman->count() }}</strong> peminjaman aktif.
            <a href="{{ route('user.peminjaman.index') }}" class="text-decoration-underline">Lihat Detail</a>
        </div>
    @endif

    {{-- Navigasi Fitur --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-4 animate__animated animate__fadeInUp">

        {{-- Barang --}}
        <div class="col">
            <div class="card-feature">
                <i class="fas fa-box text-primary"></i>
                <h5 class="text-primary">Barang</h5>
                <p>Lihat semua barang yang tersedia untuk dipinjam.</p>
                <a href="{{ route('user.barang.index') }}" class="btn btn-outline-primary btn-feature">Lihat Barang</a>
            </div>
        </div>

        {{-- Riwayat --}}
        <div class="col">
            <div class="card-feature">
                <i class="fas fa-history text-success"></i>
                <h5 class="text-success">Riwayat</h5>
                <p>Riwayat semua barang yang pernah kamu pinjam.</p>
                <a href="{{ route('user.peminjaman.riwayat') }}" class="btn btn-outline-success btn-feature">Lihat Riwayat</a>
            </div>
        </div>

        {{-- Favorit --}}
        <div class="col">
            <div class="card-feature">
                <i class="fas fa-star text-warning"></i>
                <h5 class="text-warning">Favorit</h5>
                <p>Barang favorit yang kamu tandai.</p>
                <a href="{{ route('user.favorit.index') }}" class="btn btn-outline-warning btn-feature">Lihat Favorit</a>
            </div>
        </div>
    </div>

    {{-- Tips Hari Ini --}}
    <div class="row justify-content-center animate__animated animate__fadeInUp">
        <div class="col-md-10 col-lg-8">
            <div class="tips-card">
                <i class="fas fa-lightbulb me-2 text-warning"></i>
                <strong>Tips Hari Ini:</strong> Jangan lupa kembalikan barang tepat waktu ya! Cek di menu <strong>"Peminjaman Barang"</strong>.
            </div>
        </div>
    </div>

</div>
@endsection
