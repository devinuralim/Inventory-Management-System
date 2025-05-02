@extends('layouts.admin')

@section('content')
    <div class="py-12 bg-gradient-to-br from-pink-100 to-purple-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-pink-200 shadow-lg rounded-xl p-6">
                
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold text-purple-700">📦 List Barang</h1>
                    <a href="{{ route('admin.barangs.create') }}" class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-full shadow-md transition duration-300">
                        ➕ Tambah Barang
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-pink-50 border border-purple-200 rounded-xl overflow-hidden shadow-md">
                        <thead class="bg-gradient-to-r from-pink-300 to-purple-300 text-purple-900">
                            <tr class="text-center font-semibold text-sm">
                                <th class="px-4 py-3 border">No</th>
                                <th class="px-4 py-3 border">Nama Barang</th>
                                <th class="px-4 py-3 border">Jenis Barang</th>
                                <th class="px-4 py-3 border">Stok</th>
                                <th class="px-4 py-3 border">Seri</th>
                                <th class="px-4 py-3 border">Keterangan</th>
                                <th class="px-4 py-3 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangs as $barang)
                                <tr class="text-center hover:bg-pink-100 transition duration-200">
                                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border">{{ $barang->nama_barang }}</td>
                                    <td class="px-4 py-2 border">{{ $barang->jenis_barang }}</td>
                                    <td class="px-4 py-2 border">{{ $barang->stok }}</td>
                                    <td class="px-4 py-2 border">{{ $barang->seri }}</td>
                                    <td class="px-4 py-2 border">{{ $barang->keterangan }}</td>
                                    <td class="px-4 py-2 border space-x-2">
                                        <a href="{{ route('admin.barangs.edit', $barang->id) }}" class="bg-yellow-300 hover:bg-yellow-400 text-gray-800 font-semibold px-3 py-1 rounded-full">
                                            ✏️ Edit
                                        </a>
                                        <a href="{{ route('admin.barangs.delete', $barang->id) }}" onclick="return confirm('Yakin ingin menghapus?')" class="bg-red-400 hover:bg-red-500 text-white font-semibold px-3 py-1 rounded-full">
                                            🗑️ Hapus
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-6 italic bg-pink-100 rounded-lg">
                                        😿 Tidak ada barang yang tersedia. Yuk, tambahkan barang dulu!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
