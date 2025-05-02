<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full mt-6 table-auto border-collapse">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Nama Barang</th>
                                <th class="border px-4 py-2">Jenis Barang</th>
                                <th class="border px-4 py-2">Stok</th>
                                <th class="border px-4 py-2">Seri</th>
                                <th class="border px-4 py-2">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $barang)
                                <tr>
                                    <td class="border px-4 py-2">{{ $barang->nama_barang }}</td>
                                    <td class="border px-4 py-2">{{ $barang->jenis_barang }}</td>
                                    <td class="border px-4 py-2">{{ $barang->stok }}</td>
                                    <td class="border px-4 py-2">{{ $barang->seri }}</td>
                                    <td class="border px-4 py-2">{{ $barang->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
