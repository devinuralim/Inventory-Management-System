@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                {{-- Header --}}
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                    Tambah Barang
                </h2>

                {{-- Form tambah barang --}}
                <form method="POST" action="{{ route('admin.barangs.save') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Barang</label>
                        <input
                            type="text"
                            name="nama_barang"
                            class="form-input w-full"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Jenis Barang</label>
                        <input
                            type="text"
                            name="jenis_barang"
                            class="form-input w-full"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Stok</label>
                        <input
                            type="number"
                            name="stok"
                            class="form-input w-full"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Seri</label>
                        <input
                            type="text"
                            name="seri"
                            class="form-input w-full"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Keterangan</label>
                        <textarea
                            name="keterangan"
                            class="form-textarea w-full"
                        ></textarea>
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
