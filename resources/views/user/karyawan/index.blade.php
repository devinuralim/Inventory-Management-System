@extends('layouts.user')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Pegawai</h2>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <table class="min-w-full mt-6 table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-center">No</th>
                            <th class="border px-4 py-2 text-left">ID Pegawai</th>
                            <th class="border px-4 py-2 text-left">Nama Lengkap</th>
                            <th class="border px-4 py-2 text-left">Tanggal Bergabung</th>
                            <th class="border px-4 py-2 text-left">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($karyawans as $index => $karyawan)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">{{ $karyawan->id_pegawai }}</td>
                                <td class="border px-4 py-2">{{ $karyawan->nama_lengkap }}</td>
                                <td class="border px-4 py-2">{{ $karyawan->created_at->format('d-m-Y') }}</td>
                                <td class="border px-4 py-2">{{ $karyawan->jabatan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border px-4 py-2 text-center text-gray-500">Belum ada data pegawai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
