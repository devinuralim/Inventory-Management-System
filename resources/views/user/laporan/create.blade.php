@extends('layouts.user')

@section('content')
<div class="container">
    <h4>Laporan Barang Rusak / Hilang</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- FORM CREATE LAPORAN -->
    <form action="{{ route('reporting.rusak.store') }}" method="POST" class="mb-4">
        @csrf

        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jenis Laporan</label>
            <select name="jenis_laporan" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="rusak">Rusak</option>
                <option value="hilang">Hilang</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Laporan</label>
            <input type="date" name="tanggal_laporan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Kirim Laporan</button>
    </form>

    <hr>

    <!-- LIST LAPORAN USER (READ ONLY) -->
    <h5>Laporan Saya</h5>

    @if($laporan->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Barang</th>
                <th>Jenis</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
            <tr>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ ucfirst($item->jenis_laporan) }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d-m-Y') }}</td>
                <td>
                    <span class="badge
                        {{ $item->status=='menunggu'?'bg-warning text-dark':'' }}
                        {{ $item->status=='diproses'?'bg-info':'' }}
                        {{ $item->status=='selesai'?'bg-success':'' }}
                    ">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="alert alert-info">Belum ada laporan.</div>
    @endif

</div>
@endsection