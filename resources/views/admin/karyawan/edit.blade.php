@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">

                {{-- Header --}}
                <h1 class="text-2xl font-bold mb-4">Form Edit Karyawan</h1>

                {{-- Form Edit Karyawan --}}
                <form method="POST" action="{{ route('admin.karyawans.update', $karyawan->id_pegawai) }}">
                    @csrf
                    @method('PUT')

                    {{-- ID Pegawai --}}
                    <div class="mb-3">
                        <label for="id_pegawai" class="form-label">ID Pegawai</label>
                        <input type="text" name="id_pegawai" id="id_pegawai"
                               value="{{ old('id_pegawai', $karyawan->id_pegawai) }}"
                               class="form-control" readonly>
                        @error('id_pegawai')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap"
                               value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}"
                               class="form-control">
                        @error('nama_lengkap')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Bergabung --}}
                    <div class="mb-3">
                        <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                        <input type="date" name="tanggal_bergabung" id="tanggal_bergabung"
                               value="{{ old('tanggal_bergabung', $karyawan->tanggal_bergabung) }}"
                               class="form-control">
                        @error('tanggal_bergabung')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jabatan --}}
                    <div class="mb-4">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan"
                               value="{{ old('jabatan', $karyawan->jabatan) }}"
                               class="form-control">
                        @error('jabatan')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Submit --}}
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
