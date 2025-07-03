@extends('layouts.user')

@section('content')
<style>
    .judul-section {
        border-bottom: 3px solid #1d3557;
        display: inline-block;
        padding-bottom: 6px;
    }
    .card-glass {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease-in-out;
    }
    .card-glass:hover {
        transform: scale(1.01);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    @media print {
        body * {
            visibility: hidden;
        }
        #print-section, #print-section * {
            visibility: visible;
        }
        #print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>

<div class="pt-4 pb-5 min-vh-100" style="background: linear-gradient(to bottom right, #e0f2f1, #ffffff);">
    <div class="container">
        <div class="text-center mb-4 animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-dark judul-section">
                <i class="fas fa-history me-2 text-black"></i>Riwayat Peminjaman
            </h2>
            <p class="text-muted mt-1">Berisi semua peminjaman yang pernah kamu lakukan</p>
        </div>

        {{-- Tombol Export --}}
        <div class="mb-3 d-flex justify-content-end gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-print me-1"></i> Print
            </button>
            <a href="{{ route('user.riwayat.export.pdf') }}" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-file-pdf me-1"></i> PDF
            </a>
            <a href="{{ route('user.riwayat.export.csv') }}" class="btn btn-outline-success btn-sm">
                <i class="fas fa-file-csv me-1"></i> CSV
            </a>
        </div>

        {{-- Tabel Riwayat --}}
        <div class="card card-glass border-0 rounded-4 animate__animated animate__fadeInUp" id="print-section">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center mb-0">
                        <thead style="background-color: #1d3557; color: white;">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamans as $peminjaman)
                                <tr>
                                    <td>{{ $peminjaman->nama_barang }}</td>
                                    <td>{{ $peminjaman->jumlah }}</td>
                                    <td>{{ $peminjaman->tanggal_pinjam }}</td>
                                    <td>
                                        @if ($peminjaman->status == 'dipinjam')
                                            <span class="badge bg-danger">Dipinjam</span>
                                        @elseif ($peminjaman->status == 'menunggu konfirmasi')
                                            <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fas fa-box-open fa-2x mb-2 text-secondary"></i><br>
                                        Belum ada riwayat peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
