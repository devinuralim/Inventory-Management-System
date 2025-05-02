@extends('layouts.user')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Barang</h2>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <table class="min-w-full mt-6 table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Nama Barang</th>
                            <th class="border px-4 py-2 text-left">Jenis Barang</th>
                            <th class="border px-4 py-2 text-center">Stok</th>
                            <th class="border px-4 py-2 text-left">Seri</th>
                            <th class="border px-4 py-2 text-left">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangs as $barang)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $barang->nama_barang }}</td>
                                <td class="border px-4 py-2">{{ $barang->jenis_barang }}</td>
                                <td class="border px-4 py-2 text-center">{{ $barang->stok }}</td>
                                <td class="border px-4 py-2">{{ $barang->seri }}</td>
                                <td class="border px-4 py-2">{{ $barang->keterangan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border px-4 py-2 text-center text-gray-500">Tidak ada data barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
