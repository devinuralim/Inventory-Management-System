@extends('layouts.user')

@section('content')
<div class="min-vh-100 pt-4 pb-5 text-center bg-light">
    <div class="container px-4">

        {{-- Header --}}
        <div class="mb-4 animate__animated animate__fadeInDown">
            <h1 class="display-6 fw-bold text-dark mb-2 d-flex justify-content-center align-items-center gap-2">
                <i class="fas fa-user-tie text-black"></i> Halo, {{ Auth::user()->name }}
            </h1>
            <p class="text-secondary mb-3">Selamat datang di sistem peminjaman barang</p>
            <div class="mx-auto" style="width: 80px; height: 4px; background-color: #1d3557; border-radius: 4px;"></div>
        </div>

        {{-- Navigasi Kartu --}}
        <div class="row justify-content-center row-cols-1 row-cols-md-3 g-4 mb-5 animate__animated animate__fadeInUp">
            <div class="col d-flex justify-content-center">
                <div class="card h-100 bg-white rounded-4 shadow-sm border-0 text-center" style="width: 100%; max-width: 300px;">
                    <div class="card-body">
                        <div class="icon-circle mx-auto mb-3">
                            <i class="fas fa-box text-primary fs-3"></i>
                        </div>
                        <h5 class="fw-semibold text-primary">Barang</h5>
                        <p class="text-muted small">Lihat daftar barang yang tersedia untuk dipinjam.</p>
                        <a href="{{ route('user.barang.index') }}" class="btn btn-outline-primary mt-2">Lihat Barang →</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tips Hari Ini --}}
        <div class="row justify-content-center animate__animated animate__fadeInUp">
            <div class="col-md-8">
                <div class="card bg-white border-0 shadow-sm p-4 rounded-4 text-center">
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
