@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Form Edit Karyawan</h1>

                <form method="POST" action="{{ route('admin.karyawans.update', $karyawan->id_pegawai) }}">
                    @csrf
                    @method('PUT')

                    <!-- ID Pegawai (readonly jika tidak boleh diubah) -->
                    <div class="mb-4">
                        <label for="id_pegawai" class="block text-sm font-medium text-gray-700">ID Pegawai</label>
                        <input type="text" name="id_pegawai" id="id_pegawai"
                               value="{{ old('id_pegawai', $karyawan->id_pegawai) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               readonly>
                        @error('id_pegawai')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="mb-4">
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap"
                               value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('nama_lengkap')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Bergabung -->
                    <div class="mb-4">
                        <label for="tanggal_bergabung" class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                        <input type="date" name="tanggal_bergabung" id="tanggal_bergabung"
                               value="{{ old('tanggal_bergabung', $karyawan->tanggal_bergabung) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('tanggal_bergabung')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jabatan -->
                    <div class="mb-6">
                        <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan"
                               value="{{ old('jabatan', $karyawan->jabatan) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('jabatan')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            🔄 Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
