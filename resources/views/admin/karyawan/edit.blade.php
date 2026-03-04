@extends('layouts.admin')

@section('content')

<style>
.page-title {
    font-weight: 600;
    font-size: 1.4rem;
}

.form-wrapper {
    background: #ffffff;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.form-label {
    font-weight: 500;
}

.form-control {
    border-radius: 12px;
}

.btn-primary {
    background-color: #0d6efd;
    border: none;
}

.btn-primary:hover {
    background-color: #0b5ed7;
}

@media (max-width: 768px) {
    .form-wrapper {
        padding: 18px;
    }

    .btn-group-flex {
        flex-direction: column;
        gap: 10px;
    }

    .btn-group-flex a,
    .btn-group-flex button {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="container pt-2 pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <div class="page-title">Edit Data Karyawan</div>
        <small class="text-muted">Perbarui informasi karyawan yang sudah terdaftar</small>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
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
                <input type="text"
                       name="id_pegawai"
                       class="form-control"
                       value="{{ old('id_pegawai', $karyawan->id_pegawai) }}"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nama Lengkap</label>
                <input type="text"
                       name="nama_lengkap"
                       class="form-control"
                       value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal Bergabung</label>
                <input type="date"
                       name="tanggal_bergabung"
                       class="form-control"
                       value="{{ old('tanggal_bergabung', $karyawan->tanggal_bergabung) }}"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Jabatan</label>
                <input type="text"
                       name="jabatan"
                       class="form-control"
                       value="{{ old('jabatan', $karyawan->jabatan) }}"
                       required>
            </div>

            <div class="col-md-12">
                <label class="form-label">
                    Password Baru
                    <small class="text-muted">(Opsional)</small>
                </label>

                <div class="input-group">
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           placeholder="Biarkan kosong jika tidak ingin mengganti">
                    <button type="button"
                            class="btn btn-outline-secondary toggle-password">
                        Lihat
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between btn-group-flex mt-4">
                <a href="{{ route('admin.karyawans.index') }}"
                   class="btn btn-outline-secondary rounded-pill">
                    Kembali
                </a>

                <button type="submit"
                        class="btn btn-primary rounded-pill px-4">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

{{-- Toggle Password --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.querySelector(".toggle-password");
    const passwordInput = document.getElementById("password");

    toggleBtn.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleBtn.textContent = "Sembunyikan";
        } else {
            passwordInput.type = "password";
            toggleBtn.textContent = "Lihat";
        }
    });
});
</script>

@endsection
