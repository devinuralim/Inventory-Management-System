@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">

                {{-- Header --}}
                <h1 class="text-2xl font-bold mb-4">Form Tambah Karyawan</h1>

                {{-- Tampilkan error validasi jika ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form Tambah Karyawan --}}
                <form method="POST" action="{{ route('admin.karyawans.save') }}">
                    @csrf

                    {{-- ID Pegawai --}}
                    <div class="mb-3">
                        <label for="id_pegawai" class="form-label">ID Pegawai</label>
                        <input type="text" name="id_pegawai" id="id_pegawai" class="form-control" required>
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                    </div>

                    {{-- Tanggal Bergabung --}}
                    <div class="mb-3">
                        <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                        <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" class="form-control" required>
                    </div>

                    {{-- Jabatan --}}
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control" required>
                    </div>

                    {{-- Button Simpan --}}
                    <div>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
