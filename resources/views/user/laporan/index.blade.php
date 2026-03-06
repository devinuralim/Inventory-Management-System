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
        border-left: 5px solid #ef4444; /* Warna Merah untuk indikasi laporan/masalah */
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

    /* RESPONSIVE LOGIC */
    @media (max-width: 768px) {
        .table-container { display: none; }
        .mobile-card { display: block; }
    }

    .btn-laporan {
        background-color: var(--primary-blue);
        color: white;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
    }

    .btn-laporan:hover {
        background-color: #2a4a75;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(29, 53, 87, 0.2);
    }
</style>

<div class="pt-4 pb-5 min-vh-100">
    <div class="container">

        {{-- Top Bar --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> 
            </a>
            <a href="{{ route('user.laporan.create') }}" class="btn-laporan shadow-sm animate__animated animate__fadeInRight">
                <i class="fas fa-plus-circle me-1"></i> 
            </a>
        </div>

        <div class="mb-4 animate__animated animate__fadeIn">
            <h2 class="judul-section">Laporan Barang</h2>
            <p class="text-muted small mt-2">Daftar laporan kerusakan atau kendala barang Anda.</p>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 animate__animated animate__flipInX" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- TAMPILAN PC (TABEL) --}}
        <div class="table-container animate__animated animate__fadeInUp">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Kondisi/Jenis</th>
                        <th class="text-center">Jumlah</th>
                        <th>Tanggal Lapor</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan as $item)
                        <tr>
                            <td class="fw-bold text-dark">{{ $item->barang->nama_barang ?? 'Tidak ditemukan' }}</td>
                            <td>
                                <span class="badge bg-light text-danger border border-danger-subtle px-2">
                                    {{ ucfirst($item->jenis_laporan) }}
                                </span>
                            </td>
                            <td class="text-center">{{ $item->jumlah }} Unit</td>
                            <td>
                                <span class="text-secondary small">
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusClass = match($item->status) {
                                        'menunggu' => 'bg-warning text-dark',
                                        'proses' => 'bg-info text-white',
                                        'selesai' => 'bg-success text-white',
                                        default => 'bg-secondary text-white'
                                    };
                                @endphp
                                <span class="badge-status {{ $statusClass }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada laporan yang diajukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TAMPILAN HP (KARTU) --}}
        <div class="animate__animated animate__fadeInUp">
            @foreach ($laporan as $item)
                <div class="mobile-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 1.1rem;">
                                {{ $item->barang->nama_barang ?? 'Barang Terhapus' }}
                            </div>
                            <div class="text-danger small fw-bold">
                                {{ ucfirst($item->jenis_laporan) }}
                            </div>
                        </div>
                        <span class="badge-status {{ $statusClass ?? 'bg-warning text-dark' }}">
                            {{ $item->status }}
                        </span>
                    </div>
                    
                    <div class="row g-2 mt-2 pt-2 border-top">
                        <div class="col-6">
                            <small class="text-muted d-block text-uppercase" style="font-size: 0.65rem;">Tanggal:</small>
                            <span class="small">{{ $item->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted d-block text-uppercase" style="font-size: 0.65rem;">Jumlah:</small>
                            <span class="fw-bold">{{ $item->jumlah }} Unit</span>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @if($laporan->isEmpty())
                <div class="mobile-card text-center py-4 text-muted d-md-none border-left-0">
                    Tidak ada data laporan.
                </div>
            @endif
        </div>

    </div>
</div>
@endsection