@extends('layouts.user')

@section('content')
<style>
    body {
        background: linear-gradient(to bottom right, #e0f2f1, #ffffff);
    }
    .icon-circle {
        background: rgba(0, 0, 0, 0.05);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card-glass {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card-glass:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
</style>

<div class="min-vh-100 pt-4 pb-5 text-center">
    <div class="container px-4">

        {{-- Header --}}
        <div class="mb-4 animate__animated animate__fadeInDown">
            <h1 class="display-6 fw-bold text-dark mb-2 d-flex justify-content-center align-items-center gap-2">
                <i class="fas fa-user-tie text-black"></i> Halo, {{ Auth::user()->name }}
            </h1>
            <p class="text-secondary mb-3">Selamat datang di sistem peminjaman barang</p>
            <div class="mx-auto" style="width: 80px; height: 4px; background-color: #1d3557; border-radius: 4px;"></div>

            {{-- 🔔 Notifikasi --}}
            @php
                $notifPeminjaman = \App\Models\Peminjaman::where('nama_peminjam', auth()->user()->name)
                    ->whereIn('status', ['dipinjam', 'menunggu konfirmasi'])
                    ->get();
            @endphp

            @if ($notifPeminjaman->count() > 0)
                <div class="alert alert-warning shadow-sm mt-4 w-75 mx-auto text-start animate__animated animate__fadeIn">
                    <i class="fas fa-bell me-2"></i>
                    Kamu memiliki <strong>{{ $notifPeminjaman->count() }}</strong> peminjaman aktif.
                    <a href="{{ route('user.peminjaman.index') }}" class="text-decoration-underline">Lihat Detail</a>
                </div>
            @endif
        </div>

        {{-- Kartu Navigasi --}}
        <div class="row justify-content-center row-cols-1 row-cols-md-3 g-4 mb-5 animate__animated animate__fadeInUp">

            {{-- Barang --}}
            <div class="col d-flex justify-content-center">
                <div class="card card-glass rounded-4 border-0 text-center" style="width: 100%; max-width: 300px;">
                    <div class="card-body">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-box text-primary fs-4"></i>
                        </div>
                        <h5 class="fw-semibold text-primary">Barang</h5>
                        <p class="text-muted small">Lihat daftar barang yang tersedia untuk dipinjam.</p>
                        <a href="{{ route('user.barang.index') }}" class="btn btn-outline-primary mt-2">Lihat Barang →</a>
                    </div>
                </div>
            </div>

            {{-- Riwayat --}}
            <div class="col d-flex justify-content-center">
                <div class="card card-glass rounded-4 border-0 text-center" style="width: 100%; max-width: 300px;">
                    <div class="card-body">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-history text-success fs-4"></i>
                        </div>
                        <h5 class="fw-semibold text-success">Riwayat</h5>
                        <p class="text-muted small">Lihat daftar barang yang sudah kamu kembalikan.</p>
                        <a href="{{ route('user.peminjaman.riwayat') }}" class="btn btn-outline-success mt-2">Lihat Riwayat →</a>
                    </div>
                </div>
            </div>

            {{-- Favorit --}}
            <div class="col d-flex justify-content-center">
                <div class="card card-glass rounded-4 border-0 text-center" style="width: 100%; max-width: 300px;">
                    <div class="card-body">
                        <div class="icon-circle mb-3">
                            <i class="fas fa-star text-warning fs-4"></i>
                        </div>
                        <h5 class="fw-semibold text-warning">Favorit</h5>
                        <p class="text-muted small">Lihat barang-barang favorit yang sudah kamu tandai.</p>
                        <a href="{{ route('user.favorit.index') }}" class="btn btn-outline-warning mt-2">Lihat Favorit →</a>
                    </div>
                </div>
            </div>

        </div>

        {{-- Tips Hari Ini --}}
        <div class="row justify-content-center animate__animated animate__fadeInUp">
            <div class="col-md-8">
                <div class="card card-glass border-0 p-4 rounded-4 text-center">
                    <h6 class="fw-semibold text-dark mb-2">
                        <i class="fas fa-lightbulb text-warning me-2"></i>Tips Hari Ini
                    </h6>
                    <p class="text-muted mb-0">
                        Jangan lupa kembalikan barang tepat waktu, ya! Cek status peminjamanmu di menu <strong>"Peminjaman Barang"</strong>.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
