@extends('layouts.user')

@section('content')
<style>
    .judul-section {
        border-bottom: 3px solid #1d3557;
        display: inline-block;
        padding-bottom: 6px;
    }

    .favorit-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(6px);
        border-radius: 16px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .favorit-card:hover {
        transform: scale(1.01);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .favorit-title {
        font-weight: 600;
        font-size: 1rem;
        color: #1d3557;
        margin-bottom: 0.5rem;
    }

    .favorit-info {
        font-size: 0.85rem;
        color: #555;
    }

    .favorit-actions {
        text-align: right;
        margin-top: 0.5rem;
    }

    .favorit-actions button {
        font-size: 0.75rem;
        padding: 4px 8px;
    }

    .btn-back {
        width: 32px;
        height: 32px;
        padding: 0;
        font-size: 0.9rem;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    @media (min-width: 768px) {
        .favorit-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
        }
    }

    @media (max-width: 576px) {
        .btn-back {
            width: 28px;
            height: 28px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff);">
    <div class="container">

        {{-- Tombol Back --}}
        <div class="mb-3">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-back shadow-sm" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        {{-- Judul --}}
        <div class="text-center mb-4 animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark judul-section">
                <i class="fas fa-star me-2 text-warning"></i>Barang Favorit
            </h2>
            <p class="text-muted mt-2">Barang yang kamu tandai sebagai favorit tampil di sini.</p>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success text-center w-75 mx-auto animate__animated animate__fadeIn">
                {{ session('success') }}
            </div>
        @endif

        {{-- Grid List --}}
        <div class="favorit-grid animate__animated animate__fadeInUp">
            @forelse($favoritBarangs as $barang)
                <div class="favorit-card">
                    <div class="favorit-title">{{ $barang->nama_barang }}</div>
                    <div class="favorit-info">Jenis: {{ $barang->jenis_barang }}</div>
                    <div class="favorit-info">Stok: {{ $barang->stok }}</div>
                    <div class="favorit-info">Seri: {{ $barang->seri }}</div>
                    <div class="favorit-info">Keterangan: {{ $barang->keterangan }}</div>
                    <div class="favorit-actions">
                        <form action="{{ route('user.favorit.toggle', $barang->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning">&#9733; Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-4 w-100">
                    <i class="fas fa-star fa-2x mb-2 text-secondary"></i><br>
                    Belum ada barang yang kamu tandai sebagai favorit.
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
