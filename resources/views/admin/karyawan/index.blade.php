@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Daftar Akun Karyawan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.karyawans.create') }}" class="btn btn-primary mb-3">+ Buat Akun Karyawan</a>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>ID Pegawai</th>
                <th>Nama</th>
                <th>Tanggal Bergabung</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($karyawans as $index => $karyawan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $karyawan->id_pegawai }}</td>
                    <td>{{ $karyawan->nama_lengkap }}</td>
                    <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d M Y') }}</td>
                    <td>{{ $karyawan->jabatan }}</td>
                    <td>
                        <a href="{{ route('admin.karyawans.edit', $karyawan->id_pegawai) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.karyawans.delete', $karyawan->id_pegawai) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada akun karyawan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
