@extends('layouts.admin')

@section('content')

<style>
    .page-title { font-weight: 700; font-size: 1.6rem; color: #0f172a; letter-spacing: -0.02em; }
    
    .form-wrapper {
        background: #ffffff;
        padding: 30px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .form-label { font-weight: 600; color: #334155; margin-bottom: 0.5rem; }
    .form-control { 
        border: 1px solid #cbd5e1;
        border-radius: 12px; 
        padding: 0.75rem 1rem;
        transition: all 0.2s;
    }
    .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }

    .btn-primary { background-color: #3b82f6; border: none; padding: 0.6rem 2rem; font-weight: 600; }
    .btn-primary:hover { background-color: #2563eb; }

    @media (max-width: 768px) {
        .form-wrapper { padding: 20px; }
        .btn-group-flex { flex-direction: column; gap: 10px; }
        .btn-group-flex a, .btn-group-flex button { width: 100%; justify-content: center; }
    }
</style>

<div class="container pt-3 pb-5">

    {{-- Header --}}
    <div class="mb-4">
        <div class="page-title">Tambah Barang</div>
        <small class="text-muted">Masukkan detail informasi barang baru ke dalam sistem</small>
    </div>

    {{-- Form --}}
    <div class="form-wrapper">

        <form method="POST" action="{{ route('admin.barangs.save') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control" placeholder="Contoh: Laptop HP" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jenis_barang" class="form-label">Jenis Barang</label>
                    <input type="text" name="jenis_barang" id="jenis_barang" class="form-control" placeholder="Contoh: Elektronik" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="stok" class="form-label">Jumlah Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" min="0" placeholder="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="seri" class="form-label">Seri</label>
                    <input type="text" name="seri" id="seri" class="form-control" placeholder="Contoh: HP-LPT-8892" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Tambahkan detail atau kondisi barang..."></textarea>
            </div>

            <div class="d-flex justify-content-between btn-group-flex pt-2">
                <a href="{{ route('admin.barangs') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>

                <button type="submit" class="btn btn-primary rounded-pill">
                    <i class="fas fa-save me-1"></i> Simpan Data
                </button>
            </div>

        </form>

    </div>
</div>

@endsection