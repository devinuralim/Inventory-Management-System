<!-- resources/views/admin/peminjaman/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="min-w-full mt-6 table-auto border-collapse">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Nama Peminjam</th>
                                <th class="border px-4 py-2">Nama Barang</th>
                                <th class="border px-4 py-2">Tanggal Pinjam</th>
                                <th class="border px-4 py-2">Tanggal Kembali</th>
                                <th class="border px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $peminjaman)
                                <tr>
                                    <td class="border px-4 py-2">{{ $peminjaman->nama_peminjam }}</td>
                                    <td class="border px-4 py-2">{{ $peminjaman->nama_barang }}</td>
                                    <td class="border px-4 py-2">{{ $peminjaman->tanggal_pinjam }}</td>
                                    <td class="border px-4 py-2">{{ $peminjaman->tanggal_kembali }}</td>
                                    <td class="border px-4 py-2">
                                        <span class="{{ $peminjaman->status === 'dipinjam' ? 'text-red-700 font-bold' : 'text-green-600 font-semibold' }}">
                                            {{ ucfirst($peminjaman->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Total Peminjaman -->
                    <div class="mt-4">
                        <strong>Total Peminjaman:</strong> {{ $total }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
