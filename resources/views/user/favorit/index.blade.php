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
        border-left: 5px solid var(--highlight); /* Warna Kuning untuk membedakan dengan daftar umum */
        position: relative;
    }

    /* Badge Stok */
    .badge-stok {
        padding: 5px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .stok-aman { background-color: #dcfce7; color: #166534; }
    .stok-tipis { background-color: #fef9c3; color: #854d0e; }
    .stok-habis { background-color: #fee2e2; color: #991b1b; }

    /* Button Star */
    .btn-fav-active {
        border: none;
        background: none;
        color: var(--highlight);
        font-size: 1.2rem;
        transition: transform 0.2s;
    }
    .btn-fav-active:hover { transform: scale(1.2); }

    /* RESPONSIVE LOGIC */
    @media (max-width: 768px) {
        .table-container { display: none; }
        .mobile-card { display: block; }
    }
</style>

<div class="pt-4 pb-5 min-vh-100">
    <div class="container">

        {{-- Tombol Kembali --}}
        <div class="mb-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> 
            </a>
        </div>

        <div class="mb-4 animate__animated animate__fadeIn">
            <h2 class="judul-section">Barang Favorit</h2>
            <p class="text-muted small mt-2">Daftar perlengkapan yang sering Anda gunakan.</p>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
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
                        <th width="60" class="text-center">Hapus</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Nomor Seri</th>
                        <th class="text-center">Stok</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($favoritBarangs as $barang)
                        <tr>
                            <td class="text-center">
                                <form action="{{ route('user.favorit.toggle', $barang->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-fav-active" title="Hapus dari Favorit">
                                        <i class="fas fa-star"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="fw-bold text-dark">{{ $barang->nama_barang }}</td>
                            <td><span class="badge bg-light text-secondary border">{{ $barang->jenis_barang }}</span></td>
                            <td><code class="text-primary">{{ $barang->seri ?? '-' }}</code></td>
                            <td class="text-center">
                                <span class="badge-stok {{ $barang->stok > 5 ? 'stok-aman' : ($barang->stok > 0 ? 'stok-tipis' : 'stok-habis') }}">
                                    {{ $barang->stok }} Unit
                                </span>
                            </td>
                            <td class="small text-muted">{{ $barang->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada barang favorit.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TAMPILAN HP (KARTU) --}}
        <div class="animate__animated animate__fadeInUp">
            @foreach ($favoritBarangs as $barang)
                <div class="mobile-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 1.1rem;">{{ $barang->nama_barang }}</div>
                            <div class="text-muted small mb-2">{{ $barang->jenis_barang }}</div>
                        </div>
                        <form action="{{ route('user.favorit.toggle', $barang->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-fav-active">
                                <i class="fas fa-star"></i>
                            </button>
                        </form>
                    </div>
                    
                    <div class="row g-2 mt-1">
                        <div class="col-6">
                            <small class="text-muted d-block small text-uppercase" style="font-size: 0.65rem;">No. Seri:</small>
                            <code class="text-primary">{{ $barang->seri ?? '-' }}</code>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted d-block small text-uppercase" style="font-size: 0.65rem;">Stok:</small>
                            <span class="fw-bold {{ $barang->stok <= 0 ? 'text-danger' : 'text-success' }}">
                                {{ $barang->stok }} Unit
                            </span>
                        </div>
                    </div>

                    @if($barang->keterangan)
                        <div class="mt-2 pt-2 border-top small text-muted">
                            <i class="fas fa-info-circle me-1"></i> {{ $barang->keterangan }}
                        </div>
                    @endif
                </div>
            @endforeach
            
            @if($favoritBarangs->isEmpty())
                <div class="text-center py-5 d-md-none animate__animated animate__fadeIn">
                    <i class="far fa-star fa-3x mb-3 text-light"></i>
                    <p class="text-muted">Belum ada barang favorit.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection