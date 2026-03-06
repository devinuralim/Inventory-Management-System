@extends('layouts.user')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    :root {
        --primary-blue: #1d3557;
        --highlight: #00b4d8;
        --secondary-slate: #64748b;
    }

    .judul-section {
        border-bottom: 3px solid var(--highlight);
        display: inline-block;
        padding-bottom: 6px;
        color: var(--primary-blue);
        font-weight: 700;
        text-transform: uppercase;
    }

    /* --- PC VIEW (TABLE) --- */
    .table-container {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
        display: block;
    }

    .table thead th {
        background-color: #f8fafc;
        color: var(--primary-blue);
        font-weight: 600;
        font-size: 0.85rem;
        padding: 15px;
        border-top: none;
    }

    /* --- MOBILE VIEW (CARDS) --- */
    .mobile-card {
        display: none; 
        background: white;
        border-radius: 15px;
        padding: 15px;
        margin-bottom: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border-left: 5px solid var(--primary-blue);
        position: relative;
    }

    /* Badge Status Custom */
    .badge-status {
        padding: 5px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }
    .status-dipinjam { background-color: #fee2e2; color: #991b1b; }
    .status-menunggu { background-color: #fef9c3; color: #854d0e; }
    .status-selesai { background-color: #dcfce7; color: #166534; }

    /* Filter Styling */
    .form-select-compact {
        width: auto;
        min-width: 140px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid #e2e8f0;
        padding: 0.4rem 0.75rem;
    }

    /* RESPONSIVE LOGIC */
    @media (max-width: 768px) {
        .table-container { display: none; } /* Sembunyikan Tabel di HP */
        .mobile-card { display: block; }    /* Munculkan Kartu di HP */
        .filter-wrapper { width: 100%; margin-top: 10px; }
        .form-select-compact { width: 100%; }
    }
</style>

<div class="pt-4 pb-5 min-vh-100">
    <div class="container">

        {{-- Top Bar: Kembali & Filter --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill shadow-sm">
                <i class="fas fa-arrow-left me-1"></i>
            </a>
            
            <div class="filter-wrapper animate__animated animate__fadeIn">
                <form action="{{ route('user.peminjaman.riwayat') }}" method="GET">
                    <select name="waktu" class="form-select form-select-compact shadow-sm" onchange="this.form.submit()">
                        <option value="">Semua Waktu</option>
                        <option value="7" {{ request('waktu') == '7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="30" {{ request('waktu') == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                        <option value="90" {{ request('waktu') == '90' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="mb-4 animate__animated animate__fadeIn">
            <h2 class="judul-section">Riwayat Peminjaman</h2>
            <p class="text-muted small mt-2">Daftar transaksi peminjaman barang Anda.</p>
        </div>

        {{-- TAMPILAN PC (TABEL) --}}
        <div class="table-container animate__animated animate__fadeInUp">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th class="text-center">Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th class="text-center">Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $peminjaman)
                        <tr>
                            <td class="fw-bold text-dark">{{ $peminjaman->nama_barang }}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-3">{{ $peminjaman->jumlah }} Unit</span>
                            </td>
                            <td>
                                <span class="text-secondary small">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d M Y') }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($peminjaman->status == 'dipinjam')
                                    <span class="badge-status status-dipinjam">Dipinjam</span>
                                @elseif ($peminjaman->status == 'menunggu konfirmasi')
                                    <span class="badge-status status-menunggu">Menunggu</span>
                                @else
                                    <span class="badge-status status-selesai">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.peminjaman.detail', $peminjaman->id) }}" class="btn btn-sm btn-light border rounded-pill px-3">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data riwayat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TAMPILAN HP (KARTU) --}}
        <div class="animate__animated animate__fadeInUp">
            @foreach ($peminjamans as $peminjaman)
                <div class="mobile-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 1.1rem;">{{ $peminjaman->nama_barang }}</div>
                            <div class="text-muted small">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d M Y') }}
                            </div>
                        </div>
                        @if ($peminjaman->status == 'dipinjam')
                            <span class="badge-status status-dipinjam">Dipinjam</span>
                        @elseif ($peminjaman->status == 'menunggu konfirmasi')
                            <span class="badge-status status-menunggu">Menunggu</span>
                        @else
                            <span class="badge-status status-selesai">Selesai</span>
                        @endif
                    </div>
                    
                    <div class="row g-2 mt-2 pt-2 border-top">
                        <div class="col-6">
                            <small class="text-muted d-block text-uppercase" style="font-size: 0.65rem;">Jumlah:</small>
                            <span class="fw-bold text-dark">{{ $peminjaman->jumlah }} Unit</span>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('user.peminjaman.detail', $peminjaman->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 mt-1">
                                Detail <i class="fas fa-chevron-right ms-1 small"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @if($peminjamans->isEmpty())
                <div class="mobile-card text-center py-4 text-muted d-md-none">
                    Data riwayat tidak ditemukan.
                </div>
            @endif
        </div>

    </div>
</div>
@endsection