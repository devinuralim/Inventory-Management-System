@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit Data Karyawan</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.karyawans.update', $karyawan->id_pegawai) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id_pegawai" class="form-label">ID Pegawai</label>
            <input type="text" name="id_pegawai" class="form-control" value="{{ old('id_pegawai', $karyawan->id_pegawai) }}" required>
        </div>

        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
            <input type="date" name="tanggal_bergabung" class="form-control" value="{{ old('tanggal_bergabung', $karyawan->tanggal_bergabung) }}" required>
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $karyawan->jabatan) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('admin.karyawans.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
