@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                {{-- Header --}}
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                    Edit Barang
                </h2>

                {{-- Form edit barang --}}
                <form method="POST" action="{{ route('admin.barangs.update', $barang->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Barang</label>
                        <input
                            type="text"
                            name="nama_barang"
                            value="{{ old('nama_barang', $barang->nama_barang) }}"
                            class="form-input w-full"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Jenis Barang</label>
                        <input
                            type="text"
                            name="jenis_barang"
                            value="{{ old('jenis_barang', $barang->jenis_barang) }}"
                            class="form-input w-full"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Stok</label>
                        <input
                            type="number"
                            name="stok"
                            value="{{ old('stok', $barang->stok) }}"
                            class="form-input w-full"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Seri</label>
                        <input
                            type="text"
                            name="seri"
                            value="{{ old('seri', $barang->seri) }}"
                            class="form-input w-full"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Keterangan</label>
                        <textarea
                            name="keterangan"
                            class="form-textarea w-full"
                        >{{ old('keterangan', $barang->keterangan) }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="bg-blue-500 text-white py-2 px-4 rounded-md"
                        >
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
