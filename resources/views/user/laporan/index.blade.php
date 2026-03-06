@extends('layouts.user')

@section('content')
<div class="container">
    <h4>Laporan Barang</h4>

    <a href="{{ route('user.laporan.create') }}" class="btn btn-primary mb-3">Buat Laporan</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Barang</th>
                <th>Kondisi</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($laporan as $item)
                <tr>
                    <td>{{ $item->barang->nama_barang ?? 'Tidak ditemukan' }}</td>
                    <td>{{ ucfirst($item->jenis_laporan) }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>
                        <span class="badge bg-warning">
                            {{ $item->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Belum ada laporan yang masuk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection