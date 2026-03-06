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
    .dashboard-title { font-size: 1.75rem; font-weight: 700; color: var(--text-main); }
    .card-dashboard { border: 1px solid var(--border-color); border-radius: 16px; background: var(--card); transition: 0.3s; }
    .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
    
    /* CSS Status Badge - Memakai !important agar warna muncul */
    .status-badge { padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .bg-soft-blue { background-color: #eef2ff !important; color: #4f46e5 !important; }
    .bg-soft-green { background-color: #ecfdf5 !important; color: #10b981 !important; }
    .bg-soft-orange { background-color: #fffbeb !important; color: #f59e0b !important; }
    
    .table-modern thead th { background: #f8fafc; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); padding: 16px; border: none; }
    .table-modern tbody td { padding: 16px; border-bottom: 1px solid #f1f5f9; }
</style>

<div class="container-fluid py-4">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="dashboard-title mb-1">Inventory Dashboard</h1>
            <p class="text-muted mb-0">Overview of your warehouse assets and activities</p>
        </div>
    </div>

    {{-- STATISTICS --}}
    <div class="row g-3 mb-4">
        @foreach([['Total Barang', $barangCount, 'fa-box', 'blue'], ['Barang Masuk', $barangMasuk, 'fa-arrow-down', 'green'], ['Barang Keluar', $barangKeluar, 'fa-arrow-up', 'orange'], ['Sedang Dipinjam', $peminjamanCount, 'fa-handshake', 'red']] as $s)
        <div class="col-lg-3 col-md-6">
            <div class="card card-dashboard p-3 border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-soft-{{ $s[3] }} me-3"><i class="fas {{ $s[2] }}"></i></div>
                    <div>
                        <p class="text-muted small mb-0 fw-medium">{{ $s[0] }}</p>
                        <h3 class="fw-bold mb-0">{{ number_format($s[1]) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- BARANG MASUK TERBARU --}}
    <div class="card card-dashboard border-0 shadow-sm mb-4">
        <div class="p-4 border-bottom d-flex align-items-center">
            <div class="stat-icon bg-soft-green me-3" style="width: 40px; height: 40px; font-size: 1rem;"><i class="fas fa-boxes"></i></div>
            <h5 class="fw-bold mb-0">Barang Masuk Terbaru</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0">
                <thead><tr><th class="ps-4">Nama Barang</th><th>Stok</th><th>Ditambahkan</th></tr></thead>
                <tbody>
                    @forelse($barangs->take(10) as $brg)
                    <tr>
                        <td class="ps-4 fw-semibold">{{ $brg->nama_barang }}</td>
                        <td><span class="badge bg-light text-dark">{{ $brg->stok }}</span></td>
                        <td class="text-muted">{{ $brg->created_at ? $brg->created_at->format('d M Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center py-3 text-muted">Belum ada barang</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- AKTIVITAS PEMINJAMAN --}}
    <div class="card card-dashboard border-0 shadow-sm">
        <div class="p-4 border-bottom d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-soft-blue me-3" style="width: 40px; height: 40px; font-size: 1rem;"><i class="fas fa-history"></i></div>
                <h5 class="fw-bold mb-0">Aktivitas Peminjaman</h5>
            </div>
            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-sm btn-light rounded-pill px-3">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0">
                <thead><tr><th class="ps-4">Peminjam</th><th>Barang</th><th>Tanggal</th><th class="text-center">Status</th></tr></thead>
                <tbody>
                    @forelse($peminjamans->take(5) as $p)
                    <tr>
                        <td class="ps-4 fw-semibold">{{ $p->nama_peminjam }}</td>
                        <td>{{ $p->nama_barang }}</td>
                        <td class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                        <td class="text-center">
                            <span class="status-badge {{ $p->status == 'dipinjam' ? 'bg-soft-orange' : 'bg-soft-green' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-3 text-muted">Belum ada aktivitas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection