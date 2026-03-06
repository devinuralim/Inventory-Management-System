@extends('layouts.user')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    :root {
        --primary-blue: #1d3557;
        --highlight: #00b4d8;
    }

    .judul-section {
        border-bottom: 3px solid var(--highlight);
        display: inline-block;
        padding-bottom: 6px;
        color: var(--primary-blue);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .detail-card {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .detail-header {
        background-color: #f8fafc;
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
        text-align: center;
    }

    .detail-body {
        padding: 30px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #64748b;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-weight: 700;
        color: var(--primary-blue);
        text-align: right;
    }

    .bukti-container {
        margin-top: 20px;
        padding: 15px;
        background: #f8fafc;
        border-radius: 12px;
        text-align: center;
    }

    .img-bukti {
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: 0.3s;
    }

    .img-bukti:hover {
        transform: scale(1.02);
    }

    @media (max-width: 576px) {
        .detail-row {
            flex-direction: column;
            text-align: left;
        }
        .detail-value {
            text-align: left;
            margin-top: 4px;
        }
        .btn-back {
            width: 100%;
        }
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);">
    <div class="container d-flex flex-column align-items-center">

        {{-- Judul Tanpa Icon --}}
        <div class="text-center mb-4 animate__animated animate__fadeIn">
            <h2 class="judul-section">Detail Peminjaman</h2>
        </div>

        <div class="detail-card w-100 animate__animated animate__zoomIn" style="max-width: 650px;">
            <div class="detail-header">
                <span class="badge px-3 py-2 rounded-pill 
                    @if($peminjaman->status == 'dipinjam') bg-danger 
                    @elseif($peminjaman->status == 'menunggu konfirmasi') bg-warning text-dark 
                    @else bg-success 
                    @endif">
                    {{ strtoupper($peminjaman->status) }}
                </span>
                <h4 class="mt-3 fw-bold mb-0" style="color: var(--primary-blue);">{{ $peminjaman->nama_barang }}</h4>
            </div>

            <div class="detail-body">
                <div class="detail-row">
                    <span class="detail-label">Jumlah Pinjam</span>
                    <span class="detail-value">{{ $peminjaman->jumlah }} Unit</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Tanggal Pinjam</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Tanggal Kembali</span>
                    <span class="detail-value">{{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->translatedFormat('d F Y') : '-' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Keterangan</span>
                    <span class="detail-value text-muted fw-normal">{{ $peminjaman->keterangan ?? 'Tidak ada keterangan' }}</span>
                </div>

                {{-- Bukti Pengembalian --}}
                <div class="mt-4">
                    <span class="detail-label d-block mb-2 text-center">Bukti Pengembalian</span>
                    <div class="bukti-container">
                        @if($peminjaman->bukti_pengembalian)
                            <img src="{{ asset('storage/' . $peminjaman->bukti_pengembalian) }}" class="img-bukti" alt="Bukti Pengembalian">
                            <p class="small text-muted mt-2 mb-0">Klik gambar untuk memperbesar</p>
                        @else
                            <div class="py-3">
                                <i class="fas fa-image fa-2x text-light d-block mb-2"></i>
                                <span class="text-muted small">Belum ada bukti yang diunggah</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <a href="{{ route('user.peminjaman.index') }}" class="btn btn-outline-secondary px-5 rounded-pill btn-back shadow-sm">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection