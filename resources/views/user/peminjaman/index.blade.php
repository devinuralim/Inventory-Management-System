@extends('layouts.user')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    :root {
        --primary-blue: #1d3557;
        --highlight: #00b4d8;
        --bg-soft: #f8fafc;
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
    }

    .table thead th {
        background-color: var(--bg-soft);
        color: var(--primary-blue);
        font-weight: 600;
        border-top: none;
        padding: 15px;
    }

    /* --- MOBILE VIEW (CARDS) --- */
    .mobile-card {
        display: none; 
        background: white;
        border-radius: 15px;
        padding: 18px;
        margin-bottom: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border-left: 5px solid var(--primary-blue);
        position: relative;
    }

    /* Status Badges */
    .badge-status {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    /* Action Buttons */
    .btn-action {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-view { background: #e3f2fd; color: #1565c0; border: 1px solid #bbdefb; }
    .btn-return { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
    .btn-delete { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }

    .btn-action:hover { transform: translateY(-2px); filter: brightness(0.9); }

    /* RESPONSIVE LOGIC */
    @media (max-width: 768px) {
        .table-container { display: none; }
        .mobile-card { display: block; }
    }
</style>

<div class="pt-4 pb-5 min-vh-100">
    <div class="container">

        {{-- Action Bar --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> 
            </a>
            <a href="{{ route('user.peminjaman.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-1"></i> 
            </a>
        </div>

        {{-- Judul --}}
        <div class="mb-4 animate__animated animate__fadeIn">
            <h2 class="judul-section">Pinjam Barang</h2>
            <p class="text-muted small mt-2">Pantau status dan kelola peminjaman barang Anda.</p>
        </div>

        {{-- Alert Notif --}}
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 animate__animated animate__shakeX">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- TAMPILAN PC (TABEL) --}}
        <div class="table-container animate__animated animate__fadeInUp">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th class="text-center">Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $peminjaman)
                            <tr>
                                <td class="fw-bold text-dark">{{ $peminjaman->nama_barang }}</td>
                                <td class="text-center">{{ $peminjaman->jumlah }} Unit</td>
                                <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d M Y') }}</td>
                                <td class="text-center">
                                    @if ($peminjaman->status == 'dipinjam')
                                        <span class="badge bg-danger badge-status">Dipinjam</span>
                                    @elseif ($peminjaman->status == 'menunggu konfirmasi')
                                        <span class="badge bg-warning text-dark badge-status">Menunggu</span>
                                    @else
                                        <span class="badge bg-success badge-status"></span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('user.peminjaman.detail', $peminjaman->id) }}" class="btn-action btn-view" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if ($peminjaman->status == 'dipinjam')
                                            <a href="{{ route('user.peminjaman.bukti', $peminjaman->id) }}" class="btn-action btn-return">
                                                <i class="fas fa-undo"></i> Kembalikan
                                            </a>
                                        @endif

                                        @if ($peminjaman->status != 'dipinjam')
                                            <form action="{{ route('user.peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada riwayat peminjaman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAMPILAN HP (KARTU) --}}
        <div class="animate__animated animate__fadeInUp">
            @foreach ($peminjamans as $peminjaman)
                <div class="mobile-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 1.1rem;">{{ $peminjaman->nama_barang }}</div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d M Y') }}</small>
                        </div>
                        @if ($peminjaman->status == 'dipinjam')
                            <span class="badge bg-danger badge-status">Dipinjam</span>
                        @elseif ($peminjaman->status == 'menunggu konfirmasi')
                            <span class="badge bg-warning text-dark badge-status">Menunggu</span>
                        @else
                            <span class="badge bg-success badge-status"></span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Jumlah Pinjam:</small>
                        <span class="fw-bold">{{ $peminjaman->jumlah }} Unit</span>
                    </div>

                    <div class="d-flex gap-2 border-top pt-3">
                        <a href="{{ route('user.peminjaman.detail', $peminjaman->id) }}" class="btn-action btn-view flex-fill justify-content-center">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        @if ($peminjaman->status == 'dipinjam')
                            <a href="{{ route('user.peminjaman.bukti', $peminjaman->id) }}" class="btn-action btn-return flex-fill justify-content-center">
                                <i class="fas fa-undo"></i> Balikin
                            </a>
                        @endif
                        @if ($peminjaman->status != 'dipinjam')
                            <form action="{{ route('user.peminjaman.destroy', $peminjaman->id) }}" method="POST" class="flex-fill">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete w-100 justify-content-center">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
            
            @if($peminjamans->isEmpty())
                <div class="text-center py-5 d-md-none">
                    <i class="fas fa-folder-open fa-3x text-light mb-3"></i>
                    <p class="text-muted">Kosong nih.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection