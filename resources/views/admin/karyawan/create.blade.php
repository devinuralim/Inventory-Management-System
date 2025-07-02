@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Buat Akun Karyawan</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.karyawans.save') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_pegawai" class="form-label">ID Pegawai</label>
            <input type="text" name="id_pegawai" class="form-control" value="{{ old('id_pegawai') }}" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password Akun</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
            <input type="date" name="tanggal_bergabung" class="form-control" value="{{ old('tanggal_bergabung') }}" required>
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Akun Karyawan</button>
        <a href="{{ route('admin.karyawans.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
