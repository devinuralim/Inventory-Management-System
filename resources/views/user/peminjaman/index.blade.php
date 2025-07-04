@extends('layouts.user')

@section('content')
<style>
    .judul-section {
        border-bottom: 3px solid #1d3557;
        display: inline-block;
        padding-bottom: 6px;
    }

    .card-list {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 1rem;
        transition: 0.3s;
        position: relative;
    }

    .card-list:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .list-title {
        font-weight: 600;
        font-size: 1.05rem;
        color: #1d3557;
        margin-bottom: 4px;
    }

    .badge-status {
        font-size: 0.75rem;
        border-radius: 12px;
        padding: 4px 10px;
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    .list-detail {
        font-size: 0.85rem;
        margin-bottom: 6px;
        color: #444;
    }

    .list-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 0.5rem;
    }

    .btn-kembalikan,
    .btn-upload,
    .btn-hapus,
    .btn-detail {
        font-size: 0.85rem;
        padding: 8px 14px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-kembalikan {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .btn-kembalikan:hover {
        background-color: #2e7d32;
        color: white;
    }

    .btn-upload {
        background-color: #e3f2fd;
        color: #1565c0;
    }

    .btn-upload:hover {
        background-color: #1565c0;
        color: white;
    }

    .btn-hapus {
        background-color: #ffecec;
        color: #d90429;
    }

    .btn-hapus:hover {
        background-color: #d90429;
        color: white;
    }

    .btn-detail {
        background-color: #f3e5f5;
        color: #6a1b9a;
    }

    .btn-detail:hover {
        background-color: #6a1b9a;
        color: white;
    }

    @media (max-width: 576px) {
        .list-actions {
            flex-direction: column;
        }

        .list-actions a,
        .list-actions form {
            width: 100% !important;
        }
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff);">
    <div class="container">

        {{-- Tombol Kembali --}}
        <div class="mb-2">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary rounded-circle shadow-sm" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        {{-- Judul --}}
        <div class="mb-4 text-center animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark judul-section">
                <i class="fas fa-clipboard-list me-2 text-black"></i>Daftar Peminjaman Anda
            </h2>
            <p class="text-muted mt-2">Cek riwayat & status peminjaman barang kamu di sini.</p>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success text-center animate__animated animate__fadeIn">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger text-center animate__animated animate__fadeIn">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        {{-- Tombol Tambah --}}
        <div class="mb-3 text-end">
            <a href="{{ route('user.peminjaman.create') }}" class="btn btn-dark shadow-sm">
                <i class="fas fa-plus me-1"></i> Tambah
            </a>
        </div>

        {{-- Daftar Peminjaman --}}
        @forelse ($peminjamans as $peminjaman)
            <div class="card-list animate__animated animate__fadeInUp">
                <div class="list-title">{{ $peminjaman->nama_barang }}</div>

                @if ($peminjaman->status == 'dipinjam')
                    <span class="badge bg-danger badge-status">Dipinjam</span>
                @elseif ($peminjaman->status == 'menunggu konfirmasi')
                    <span class="badge bg-warning text-dark badge-status">Menunggu</span>
                @else
                    <span class="badge bg-success badge-status">Dikembalikan</span>
                @endif

                <div class="list-detail">Jumlah: {{ $peminjaman->jumlah }}</div>
                <div class="list-detail">Tanggal Pinjam: {{ $peminjaman->tanggal_pinjam }}</div>

                <div class="list-actions">
                    {{-- Detail --}}
                    <a href="{{ route('user.peminjaman.detail', $peminjaman->id) }}" class="btn-detail">
                        <i class="fas fa-eye me-1"></i> Detail
                    </a>

                    @if ($peminjaman->status == 'dipinjam')
                        <a href="{{ route('user.peminjaman.bukti', $peminjaman->id) }}" class="btn-kembalikan">
                            <i class="fas fa-undo me-1"></i> Ajukan Pengembalian
                        </a>
                    @endif

                    @if ($peminjaman->status != 'dipinjam')
                        <form action="{{ route('user.peminjaman.destroy', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus peminjaman ini?')" class="w-100 w-sm-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="fas fa-box-open fa-2x mb-2 text-secondary"></i><br>
                Tidak ada data peminjaman.
            </div>
        @endforelse

    </div>
</div>
@endsection
