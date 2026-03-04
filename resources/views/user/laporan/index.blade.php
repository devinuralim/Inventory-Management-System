@extends('layouts.user')

@section('content')
<h4>Laporan Saya</h4>

<a href="{{ route('user.laporan.create') }}" class="btn btn-primary mb-3">
  + Lapor Baru
</a>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Barang</th>
      <th>Jenis</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @if($laporan->count())
        @foreach($laporan as $item)
        <tr>
          <td>{{ $item->nama_barang }}</td>
          <td>{{ ucfirst($item->jenis_laporan) }}</td>
          <td>{{ ucfirst($item->status) }}</td>
        </tr>
        @endforeach
    @else
        <tr>
          <td colspan="3" class="text-center text-muted">
            Belum ada laporan.
          </td>
        </tr>
    @endif
  </tbody>
</table>

@endsection