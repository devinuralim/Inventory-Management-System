@extends('layouts.admin')

@section('content')
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
                                <th class="border px-4 py-2">Aksi</th>
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
                                    <td class="border px-4 py-2">
                                        @if($peminjaman->status == 'menunggu konfirmasi')
                                            <form action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengonfirmasi pengembalian barang ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-blue-500 text-white py-1 px-4 rounded hover:bg-blue-700">
                                                    Konfirmasi Pengembalian
                                                </button>
                                            </form>
                                        @elseif($peminjaman->status == 'dikembalikan')
                                            <form action="{{ route('admin.peminjaman.delete', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 text-white py-1 px-4 rounded hover:bg-red-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <strong>Total Peminjaman:</strong> {{ $total }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
