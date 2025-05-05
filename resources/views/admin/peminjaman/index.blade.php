@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">

                {{-- Judul Daftar Peminjaman Barang --}}
                <h2 class="text-2xl font-bold mb-4">Daftar Peminjaman Barang</h2>

                {{-- Menampilkan Notifikasi Success --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Menampilkan Notifikasi Error --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Tabel Peminjaman --}}
                <table class="table table-bordered mt-4">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Nama Barang</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 150px;">Aksi</th> <!-- Kolom Aksi Lebih Kecil -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamans as $peminjaman)
                            <tr>
                                <td>{{ $peminjaman->nama_peminjam }}</td>
                                <td>{{ $peminjaman->nama_barang }}</td>
                                <td>{{ $peminjaman->tanggal_pinjam }}</td>
                                <td>{{ $peminjaman->tanggal_kembali }}</td>
                                <td>
                                    <span class="badge {{ $peminjaman->status === 'dipinjam' ? 'bg-danger' : 'bg-success' }}">
                                        {{ ucfirst($peminjaman->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($peminjaman->status == 'menunggu konfirmasi')
                                        <form action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengonfirmasi pengembalian barang ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Konfirmasi Pengembalian
                                            </button>
                                        </form>
                                    @elseif($peminjaman->status == 'dikembalikan')
                                        <form action="{{ route('admin.peminjaman.delete', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Total Peminjaman --}}
                <div class="mt-4">
                    <strong>Total Peminjaman:</strong> {{ $total }}
                </div>
            </div>
        </div>
    </div>
@endsection
