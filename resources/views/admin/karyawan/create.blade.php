@extends('layouts.admin')

@section('content')
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
                <input type="password" name="password" class="form-control" required>
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
@endsection
