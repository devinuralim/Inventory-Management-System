@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Form Tambah Karyawan</h1>

                    {{-- Tampilkan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.karyawans.save') }}">
                        @csrf

                        {{-- ID Pegawai --}}
                        <div class="mb-4">
                            <label for="id_pegawai" class="block text-sm font-medium text-gray-700">ID Pegawai</label>
                            <input type="text" name="id_pegawai" id="id_pegawai" class="form-input mt-1 block w-full" required>
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="mb-4">
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-input mt-1 block w-full" required>
                        </div>

                        {{-- Tanggal Bergabung --}}
                        <div class="mb-4">
                            <label for="tanggal_bergabung" class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                            <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" class="form-input mt-1 block w-full" required>
                        </div>

                        {{-- Jabatan --}}
                        <div class="mb-4">
                            <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan" class="form-input mt-1 block w-full" required>
                        </div>

                        <div>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                💾 Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
