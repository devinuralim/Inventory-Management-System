@extends('layouts.user')

@section('content')
<style>
    .detail-label {
        font-weight: 600;
        font-size: 0.95rem;
        color: #1d3557;
        margin-bottom: 2px;
    }

    .detail-value {
        font-size: 0.92rem;
        color: #333;
    }

    @media (max-width: 576px) {
        .container .card {
            padding: 1.25rem !important;
        }

        .detail-label,
        .detail-value {
            font-size: 0.9rem;
        }

        h4 {
            font-size: 1.25rem;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .text-end {
            text-align: center !important;
            margin-top: 1rem;
        }
    }
</style>

<div class="container pt-3 pb-5 d-flex flex-column justify-content-start align-items-center" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff); min-height: 85vh;">
    <div class="card shadow border-0 rounded-4 p-4 w-100" style="max-width: 600px;">
        <h4 class="text-center mb-4 fw-bold text-dark">
            <i class="fas fa-info-circle me-2"></i>Detail Peminjaman
        </h4>

        <div class="mb-3">
            <div class="detail-label">Nama Barang:</div>
            <div class="detail-value">{{ $peminjaman->nama_barang }}</div>
        </div>

        <div class="mb-3">
            <div class="detail-label">Jumlah:</div>
            <div class="detail-value">{{ $peminjaman->jumlah }}</div>
        </div>

        <div class="mb-3">
            <div class="detail-label">Tanggal Pinjam:</div>
            <div class="detail-value">{{ $peminjaman->tanggal_pinjam }}</div>
        </div>

        <div class="mb-3">
            <div class="detail-label">Tanggal Kembali:</div>
            <div class="detail-value">{{ $peminjaman->tanggal_kembali ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <div class="detail-label">Status:</div>
            <div class="detail-value">
                <span class="badge 
                    @if($peminjaman->status == 'dipinjam') bg-danger 
                    @elseif($peminjaman->status == 'menunggu konfirmasi') bg-warning text-dark 
                    @else bg-success 
                    @endif">
                    {{ ucfirst($peminjaman->status) }}
                </span>
            </div>
        </div>

        <div class="mb-3">
            <div class="detail-label">Keterangan:</div>
            <div class="detail-value">{{ $peminjaman->keterangan ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <div class="detail-label">Bukti Pengembalian:</div>
            <div class="detail-value">
                @if($peminjaman->bukti_pengembalian)
                    <img src="{{ asset('storage/' . $peminjaman->bukti_pengembalian) }}" class="img-fluid rounded shadow-sm mt-2" alt="Bukti Pengembalian">
                @else
                    <span class="text-muted">Belum ada</span>
                @endif
            </div>
        </div>

        <div class="text-end">
            <a href="{{ route('user.peminjaman.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
