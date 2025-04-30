<!-- resources/views/user/peminjaman/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Peminjaman Anda') }}
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

                    <!-- Tombol untuk menambah peminjaman -->
                    <a href="{{ route('user.peminjaman.create') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-3 rounded mb-4">
                        Tambah Peminjaman
                    </a>

                    <!-- Tabel Daftar Peminjaman -->
                    <table class="min-w-full mt-6 table-auto border-collapse">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Nama Barang</th>
                                <th class="border px-4 py-2">Jumlah</th>
                                <th class="border px-4 py-2">Tanggal Pinjam</th>
                                <th class="border px-4 py-2">Tanggal Kembali</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $peminjaman)
                                <tr>
                                    <td class="border px-4 py-2">{{ $peminjaman->nama_barang }}</td>
                                    <td class="border px-4 py-2">{{ $peminjaman->jumlah }}</td>
                                    <td class="border px-4 py-2">{{ $peminjaman->tanggal_pinjam }}</td>
                                    <td class="border px-4 py-2">{{ $peminjaman->tanggal_kembali }}</td>
                                    <td class="border px-4 py-2">
                                        @if ($peminjaman->status == 'dipinjam')
                                            <span class="text-red-500">Dipinjam</span>
                                        @elseif ($peminjaman->status == 'menunggu konfirmasi')
                                            <span class="text-yellow-500">Menunggu Konfirmasi</span>
                                        @else
                                            <span class="text-green-500">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if ($peminjaman->status == 'dipinjam')
                                            <a href="{{ route('user.peminjaman.kembalikan', $peminjaman->id) }}" class="text-green-600 no-underline hover:text-green-700 font-medium">
                                                Kembalikan Barang
                                            </a>
                                        @else
                                            <span class="text-gray-500">Barang Sudah Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
