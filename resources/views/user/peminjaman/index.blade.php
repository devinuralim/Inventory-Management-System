@extends('layouts.user')

@section('content')
<div class="py-12">
    <div class="container mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Peminjaman Anda</h2>

        <div class="card shadow-sm">
            <div class="card-body text-gray-900">
                @if(session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Tombol untuk menambah peminjaman -->
                <a href="{{ route('user.peminjaman.create') }}" class="btn btn-primary mb-4">
                    Tambah Peminjaman
                </a>

                <!-- Tabel Daftar Peminjaman -->
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th class="d-none">Tanggal Kembali</th> <!-- Kolom Tanggal Kembali disembunyikan -->
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamans as $peminjaman)
                            <tr>
                                <td>{{ $peminjaman->nama_barang }}</td>
                                <td>{{ $peminjaman->jumlah }}</td>
                                <td>{{ $peminjaman->tanggal_pinjam }}</td>
                                <td class="d-none">{{ $peminjaman->tanggal_kembali }}</td> <!-- Kolom Tanggal Kembali disembunyikan -->
                                <td>
                                    @if ($peminjaman->status == 'dipinjam')
                                        <span class="badge bg-danger">Dipinjam</span>
                                    @elseif ($peminjaman->status == 'menunggu konfirmasi')
                                        <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                    @else
                                        <span class="badge bg-success">Dikembalikan</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($peminjaman->status == 'dipinjam')
                                        <a href="{{ route('user.peminjaman.kembalikan', $peminjaman->id) }}" class="btn btn-success btn-sm">
                                            Kembalikan Barang
                                        </a>
                                    @else
                                        <span class="text-muted">Barang Sudah Dikembalikan</span>
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
@endsection
