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
        <div class="page-title">Edit Data Karyawan</div>
        <p class="text-muted small">Perbarui informasi karyawan yang sudah terdaftar dalam sistem</p>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="form-wrapper">
        <form action="{{ route('admin.karyawans.update', $karyawan->id_pegawai) }}" method="POST" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label class="form-label">ID Pegawai</label>
                <input type="text" name="id_pegawai" class="form-control" value="{{ old('id_pegawai', $karyawan->id_pegawai) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal Bergabung</label>
                <input type="date" name="tanggal_bergabung" class="form-control" value="{{ old('tanggal_bergabung', $karyawan->tanggal_bergabung) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $karyawan->jabatan) }}" required>
            </div>

            <div class="col-12">
                <label class="form-label">
                    Password Baru <span class="text-muted fw-normal">(Opsional)</span>
                </label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Isi untuk mengganti password...">
                    <button type="button" class="btn btn-outline-secondary toggle-password" style="border-radius: 0 12px 12px 0;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between btn-group-flex mt-4 pt-2">
                <a href="{{ route('admin.karyawans.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary rounded-pill">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelector(".toggle-password").addEventListener("click", function () {
        const passwordInput = document.getElementById("password");
        const icon = this.querySelector("i");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.className = "fas fa-eye-slash";
        } else {
            passwordInput.type = "password";
            icon.className = "fas fa-eye";
        }
    });
</script>

@endsection