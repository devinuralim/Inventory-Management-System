@extends('layouts.admin')

@section('content')

<style>
@media (max-width: 768px) {
    h2 {
        font-size: 1.25rem;
    }

    .form-label {
        font-size: 0.9rem;
    }

    .form-control {
        font-size: 0.9rem;
        padding: 8px 10px;
    }

    .btn {
        font-size: 0.9rem;
        padding: 8px 16px;
    }

    .card-body, .card {
        padding: 1.5rem 1rem;
    }

    .col-12.d-flex {
        flex-direction: column;
        gap: 10px;
        align-items: stretch;
    }

    .col-12.d-flex a, .col-12.d-flex button {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="pt-4 pb-5 container">
    <div class="card shadow border-0 rounded-4 p-4">
        <h2 class="fw-bold text-dark d-flex align-items-center mb-4">
            <i class="fas fa-user-plus me-2 text-black"></i> Buat Akun Karyawan
        </h2>

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.karyawans.save') }}" method="POST" class="row g-3">
            @csrf

            <div class="col-md-6">
                <label for="id_pegawai" class="form-label">ID Pegawai</label>
                <input type="text" name="id_pegawai" class="form-control" value="{{ old('id_pegawai') }}" required>
            </div>

            <div class="col-md-6">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">Password Akun</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-6">
                <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                <input type="date" name="tanggal_bergabung" class="form-control" value="{{ old('tanggal_bergabung') }}" required>
            </div>

            <div class="col-md-12">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" required>
            </div>

            <div class="col-12 d-flex justify-content-between mt-4">
                <a href="{{ route('admin.karyawans.index') }}" class="btn btn-secondary rounded-pill">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success rounded-pill">
                    <i class="fas fa-save me-1"></i> Simpan Akun Karyawan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Toggle Password Script --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.querySelector(".toggle-password");
        const passwordInput = document.getElementById("password");

        toggleBtn.addEventListener("click", function () {
            const icon = toggleBtn.querySelector("i");
            const isHidden = passwordInput.type === "password";

            passwordInput.type = isHidden ? "text" : "password";
            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        });
    });
</script>

@endsection
