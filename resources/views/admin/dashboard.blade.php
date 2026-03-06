@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary: #4f46e5;
        --bg: #f8fafc;
        --card: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    body { background-color: var(--bg); font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-main); }
    
    /* Responsive Title */
    .dashboard-title { font-size: 1.5rem; font-weight: 700; color: var(--text-main); }
    @media (min-width: 768px) { .dashboard-title { font-size: 1.85rem; } }

    .card-dashboard { 
        border: 1px solid var(--border-color); 
        border-radius: 16px; 
        background: var(--card); 
        transition: all 0.3s ease; 
    }
    
    .card-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }

    .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    
    /* Colors */
    .bg-soft-blue { background-color: #eef2ff !important; color: #4f46e5 !important; }
    .bg-soft-green { background-color: #ecfdf5 !important; color: #10b981 !important; }
    .bg-soft-orange { background-color: #fffbeb !important; color: #f59e0b !important; }
    .bg-soft-red { background-color: #fef2f2 !important; color: #ef4444 !important; }

    /* Modern Table */
    .table-modern thead th { background: #f8fafc; font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); padding: 12px 16px; border: none; white-space: nowrap; }
    .table-modern tbody td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.85rem; }
    
    .status-badge { padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 600; display: inline-block; white-space: nowrap; }

    /* Custom Scrollbar untuk Tabel HP */
    .table-responsive { border-radius: 0 0 16px 16px; }
    
    /* Utility */
    .text-truncate-custom {
        display: inline-block;
        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    @media (min-width: 768px) { .text-truncate-custom { max-width: 200px; } }
</style>

<div class="container-fluid px-2 px-md-4 py-3 py-md-4">
    {{-- HEADER DENGAN SAPAAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-4 px-2">
        <div class="mb-2 mb-md-0">
            @php
                $hour = date('H');
                $greeting = 'Selamat Pagi';
                if ($hour >= 12 && $hour < 15) $greeting = 'Selamat Siang';
                elseif ($hour >= 15 && $hour < 18) $greeting = 'Selamat Sore';
                elseif ($hour >= 18 || $hour < 5) $greeting = 'Selamat Malam';
            @endphp
            <h1 class="dashboard-title mb-1">{{ $greeting }}, {{ Auth::user()->name }}! </h1>
            <p class="text-muted small mb-0">Berikut adalah ringkasan aset & aktivitas inventaris hari ini.</p>
        </div>
        <div class="text-muted small fw-medium d-none d-sm-block bg-white px-3 py-2 rounded-pill shadow-sm border">
            <i class="far fa-calendar-alt me-1 text-primary"></i> {{ date('d M Y') }}
        </div>
    </div>

    {{-- STATISTICS --}}
    <div class="row g-2 g-md-3 mb-4">
        @php
            $stats = [
                ['Total Barang', $barangCount, 'fa-boxes-stacked', 'blue'],
                ['Barang Masuk', $barangMasuk, 'fa-arrow-trend-up', 'green'],
                ['Barang Keluar', $barangKeluar, 'fa-arrow-trend-down', 'orange'],
                ['Dipinjam', $peminjamanCount, 'fa-handshake', 'red']
            ];
        @endphp

        @foreach($stats as $s)
        <div class="col-6 col-md-3">
            <div class="card card-dashboard card-stat p-2 p-md-3 border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-soft-{{ $s[3] }} me-2 me-md-3">
                        <i class="fas {{ $s[2] }}"></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-muted small mb-0 fw-medium text-truncate" style="font-size: 0.7rem;">{{ $s[0] }}</p>
                        <h4 class="fw-bold mb-0" style="font-size: 1.1rem;">{{ number_format($s[1]) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-3">
        {{-- AKTIVITAS PEMINJAMAN --}}
        <div class="col-12 col-xl-7">
            <div class="card card-dashboard border-0 shadow-sm">
                <div class="p-3 p-md-4 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0"><i class="fas fa-history me-2 text-primary"></i> Aktivitas Peminjaman</h6>
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-sm btn-light rounded-pill px-3" style="font-size: 0.75rem;">Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3 ps-md-4">Peminjam</th>
                                <th>Barang</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamans->take(5) as $p)
                            <tr>
                                <td class="ps-3 ps-md-4">
                                    <span class="fw-semibold d-block">{{ $p->nama_peminjam }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M') }}</small>
                                </td>
                                <td><span class="text-truncate-custom">{{ $p->nama_barang }}</span></td>
                                <td class="text-center">
                                    <span class="status-badge {{ $p->status == 'dipinjam' ? 'bg-soft-orange' : 'bg-soft-green' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center py-4 text-muted small">Belum ada aktivitas</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- BARANG TERBARU --}}
        <div class="col-12 col-xl-5">
            <div class="card card-dashboard border-0 shadow-sm">
                <div class="p-3 p-md-4 border-bottom">
                    <h6 class="fw-bold mb-0"><i class="fas fa-plus me-2 text-success"></i> Barang Terbaru</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3 ps-md-4">Nama</th>
                                <th class="text-center">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangs->take(5) as $brg)
                            <tr>
                                <td class="ps-3 ps-md-4">
                                    <span class="fw-medium text-truncate-custom">{{ $brg->nama_barang }}</span>
                                </td>
                                <td class="text-center"><span class="badge rounded-pill bg-light text-dark px-2">{{ $brg->stok }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-center py-4 text-muted small">Belum ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection