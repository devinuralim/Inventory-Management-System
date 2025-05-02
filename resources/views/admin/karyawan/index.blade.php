@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Selamat datang di Dashboard Karyawan</h1>

                    <div class="flex justify-between mb-4">
                        <!-- Tombol Tambah Karyawan -->
                        <a href="{{ route('admin.karyawans.create') }}" 
                           class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition duration-200">
                            Tambah Karyawan
                        </a>
                    </div>

                    @if(Session::has('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    <h2 class="text-xl font-semibold mb-4">Daftar Karyawan</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100 border-b border-gray-300">
                                <tr>
                                    <th class="px-4 py-2 text-left">NO</th>
                                    <th class="px-4 py-2 text-left">ID Pegawai</th>
                                    <th class="px-4 py-2 text-left">Nama Lengkap</th>
                                    <th class="px-4 py-2 text-left">Tanggal Bergabung</th>
                                    <th class="px-4 py-2 text-left">Jabatan</th>
                                    <th class="px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($karyawans as $karyawan)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $karyawan->id_pegawai }}</td>
                                        <td class="px-4 py-2">{{ $karyawan->nama_lengkap }}</td>
                                        <td class="px-4 py-2">{{ $karyawan->tanggal_bergabung }}</td>
                                        <td class="px-4 py-2">{{ $karyawan->jabatan }}</td>
                                        <td class="px-4 py-2 space-x-2">
                                            <a href="{{ route('admin.karyawans.edit', $karyawan->id_pegawai) }}" 
                                               class="inline-block px-3 py-1 bg-yellow-300 text-gray-800 rounded hover:bg-yellow-400">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.karyawans.delete', $karyawan->id_pegawai) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                   class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                                   onclick="return confirm('Yakin ingin menghapus karyawan ini?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">Tidak ada data karyawan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
