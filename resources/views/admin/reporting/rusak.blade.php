@extends('layouts.admin')

@section('content')
<div class="container">
    <h4>Laporan Barang Rusak / Hilang</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($laporan->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Barang</th>
                <th>Jenis</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
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
                <td>

                    <!-- UPDATE STATUS -->
                    <form action="{{ route('reporting.rusak.update', $item->id) }}" method="POST">
                        @csrf
                        <select name="status" onchange="this.form.submit()" class="form-control">
                            <option value="menunggu" {{ $item->status=='menunggu'?'selected':'' }}>Menunggu</option>
                            <option value="diproses" {{ $item->status=='diproses'?'selected':'' }}>Diproses</option>
                            <option value="selesai" {{ $item->status=='selesai'?'selected':'' }}>Selesai</option>
                        </select>
                    </form>

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