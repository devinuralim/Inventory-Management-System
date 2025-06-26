@extends('layouts.admin')

@section('content')
<div class="pt-4 pb-5 container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <!-- Judul -->
            <h2 class="fw-bold text-dark mb-4 d-flex align-items-center">
                <i class="fas fa-user-plus me-2 text-black"></i> Form Tambah Karyawan
            </h2>

            <!-- Error Validasi -->
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm rounded-3">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Tambah -->
            <form method="POST" action="{{ route('admin.karyawans.save') }}">
                @csrf

                <div class="mb-3">
                    <label for="id_pegawai" class="form-label">ID Pegawai</label>
                    <input type="text" name="id_pegawai" id="id_pegawai" class="form-control"
                           value="{{ old('id_pegawai') }}" required>
                </div>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                           value="{{ old('nama_lengkap') }}" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                    <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" class="form-control"
                           value="{{ old('tanggal_bergabung') }}" required>
                </div>

                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control"
                           value="{{ old('jabatan') }}" required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4 rounded-pill">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
