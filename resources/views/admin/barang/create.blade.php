@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">

                {{-- Header --}}
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                    Tambah Barang
                </h2>

                {{-- Form tambah barang --}}
                <form method="POST" action="{{ route('admin.barangs.save') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input
                            type="text"
                            name="nama_barang"
                            id="nama_barang"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="jenis_barang" class="form-label">Jenis Barang</label>
                        <input
                            type="text"
                            name="jenis_barang"
                            id="jenis_barang"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input
                            type="number"
                            name="stok"
                            id="stok"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="seri" class="form-label">Seri</label>
                        <input
                            type="text"
                            name="seri"
                            id="seri"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea
                            name="keterangan"
                            id="keterangan"
                            class="form-control"
                            rows="3"
                        ></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
