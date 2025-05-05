@extends('layouts.user')

@section('content')
<div class="py-12">
    <div class="container mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Pegawai</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>ID Pegawai</th>
                            <th>Nama Lengkap</th>
                            <th>Tanggal Bergabung</th>
                            <th>Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($karyawans as $index => $karyawan)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $karyawan->id_pegawai }}</td>
                                <td>{{ $karyawan->nama_lengkap }}</td>
                                <td>{{ $karyawan->created_at->format('d-m-Y') }}</td>
                                <td>{{ $karyawan->jabatan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500">Belum ada data pegawai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
