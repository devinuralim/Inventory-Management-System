@extends('layouts.user')

@section('content')
<div class="min-h-screen bg-white py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-1">Halo, {{ Auth::user()->name }} 👋</h1>
            <p class="text-gray-500 text-sm">Senang melihatmu kembali. Yuk, cek apa yang bisa kamu lakukan hari ini.</p>
        </div>

        {{-- Kartu Navigasi --}}
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-12">
            <div class="col">
                <div class="card h-100 bg-light rounded-xl p-4 shadow-sm text-center">
                    <div class="text-primary fs-2 mb-2">
                        <i class="fas fa-box"></i>
                    </div>
                    <h2 class="h5 font-semibold text-primary">Barang</h2>
                    <p class="text-muted">Lihat semua daftar barang yang tersedia.</p>
                    <a href="{{ route('user.barang.index') }}" class="btn btn-outline-primary mt-3">Lihat Barang →</a>
                </div>
            </div>
        </div>

        {{-- Tips Section --}}
        <div class="card bg-light border-light p-4 rounded-lg shadow-sm">
            <h3 class="h6 font-semibold text-dark mb-2">
                <i class="fas fa-lightbulb text-warning me-2"></i>Tips Hari Ini
            </h3>
            <p class="text-muted">
                Pastikan barang yang kamu pinjam dikembalikan tepat waktu, ya! Kamu bisa cek status peminjaman kapan saja dari menu <strong>"Peminjaman Barang"</strong>.
            </p>
        </div>
    </div>
</div>
@endsection
