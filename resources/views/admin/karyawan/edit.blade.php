@extends('layouts.admin')

@section('content')
<div class="pt-4 pb-5 container">
    <div class="card shadow border-0 rounded-4 p-4">
        <h2 class="fw-bold text-dark d-flex align-items-center mb-4">
            <i class="fas fa-user-edit me-2 text-black"></i> Edit Data Karyawan
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

        <form action="{{ route('admin.karyawans.update', $karyawan->id_pegawai) }}" method="POST" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label for="id_pegawai" class="form-label">ID Pegawai</label>
                <input type="text" name="id_pegawai" class="form-control" value="{{ old('id_pegawai', $karyawan->id_pegawai) }}" required>
            </div>

            <div class="col-md-6">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}" required>
            </div>

            <div class="col-md-6">
                <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                <input type="date" name="tanggal_bergabung" class="form-control" value="{{ old('tanggal_bergabung', $karyawan->tanggal_bergabung) }}" required>
            </div>

            <div class="col-md-6">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $karyawan->jabatan) }}" required>
            </div>

            <div class="col-md-12">
                <label for="password" class="form-label">Password Baru (opsional)</label>
                <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengganti">
            </div>

            <div class="col-12 d-flex justify-content-between mt-4">
                <a href="{{ route('admin.karyawans.index') }}" class="btn btn-secondary rounded-pill">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success rounded-pill">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
