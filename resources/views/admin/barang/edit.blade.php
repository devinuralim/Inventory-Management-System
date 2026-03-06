@extends('layouts.admin')

@section('content')

<style>
    .page-title { font-weight: 700; font-size: 1.6rem; color: #0f172a; }
    
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
        <div class="page-title">Edit Barang</div>
        <p class="text-muted small">Perbarui data detail barang yang sudah terdaftar</p>
    </div>

    {{-- Form --}}
    <div class="form-wrapper">

        <form method="POST" action="{{ route('admin.barangs.update', $barang->id) }}" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" 
                       value="{{ old('nama_barang', $barang->nama_barang) }}" 
                       class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="jenis_barang" class="form-label">Jenis Barang</label>
                <input type="text" name="jenis_barang" id="jenis_barang" 
                       value="{{ old('jenis_barang', $barang->jenis_barang) }}" 
                       class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" id="stok" 
                       value="{{ old('stok', $barang->stok) }}" 
                       class="form-control" min="0" required>
            </div>

            <div class="col-md-6">
                <label for="seri" class="form-label">Seri / Model</label>
                <input type="text" name="seri" id="seri" 
                       value="{{ old('seri', $barang->seri) }}" 
                       class="form-control" required>
            </div>

            <div class="col-12">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ old('keterangan', $barang->keterangan) }}</textarea>
            </div>

            <div class="d-flex justify-content-between btn-group-flex mt-4 pt-2">
                <a href="{{ route('admin.barangs') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>

                <button type="submit" class="btn btn-primary rounded-pill">
                    <i class="fas fa-save me-1"></i> Perbarui Data
                </button>
            </div>

        </form>

    </div>
</div>

@endsection