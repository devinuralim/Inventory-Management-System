@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">

                {{-- Header --}}
                <h1 class="text-2xl font-bold mb-6">Daftar Karyawan</h1>

                {{-- Tombol Tambah Karyawan --}}
                <div class="d-flex justify-content-between mb-4">
                    <a href="{{ route('admin.karyawans.create') }}" 
                       class="btn btn-dark px-4 py-2">
                        Tambah Karyawan
                    </a>
                </div>

                {{-- Pesan Sukses --}}
                @if(Session::has('success'))
                    <div class="alert alert-success mb-4">
                        {{ Session::get('success') }}
                    </div>
                @endif

                {{-- Daftar Karyawan --}}
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>ID Pegawai</th>
                                <th>Nama Lengkap</th>
                                <th>Tanggal Bergabung</th>
                                <th>Jabatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($karyawans as $karyawan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $karyawan->id_pegawai }}</td>
                                    <td>{{ $karyawan->nama_lengkap }}</td>
                                    <td>{{ $karyawan->tanggal_bergabung }}</td>
                                    <td>{{ $karyawan->jabatan }}</td>
                                    <td>
                                        <a href="{{ route('admin.karyawans.edit', $karyawan->id_pegawai) }}" 
                                           class="btn btn-warning btn-sm me-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.karyawans.delete', $karyawan->id_pegawai) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus karyawan ini?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada data karyawan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
