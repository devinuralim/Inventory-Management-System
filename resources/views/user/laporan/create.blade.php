@extends('layouts.user')

@section('content')
<div class="container">
    <h4>Buat Laporan Barang</h4>

    <form action="{{ route('user.laporan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Barang</label>
            <input
                list="barangList"
                name="nama_barang"
                class="form-control"
                required
                placeholder="Ketik nama barang..." />

            <datalist id="barangList">
                @foreach ($barangs as $barang)
                    <option value="{{ $barang->nama_barang }}"></option>
                @endforeach
            </datalist>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kondisi barang</label>
            <select name="jenis_laporan" class="form-control">
                <option value="rusak">Rusak</option>
                <option value="hilang">Hilang</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Kirim Laporan</button>
    </form>
</div>
@endsection