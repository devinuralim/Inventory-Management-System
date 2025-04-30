<!-- resources/views/user/peminjaman/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peminjaman Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('error'))
                        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('user.peminjaman.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nama_peminjam" class="block text-sm font-medium text-gray-700">Nama Peminjam</label>
                            <input type="text" id="nama_peminjam" name="nama_peminjam" class="mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                            <select id="nama_barang" name="nama_barang" class="mt-1 block w-full" required>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->nama_barang }}">{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Barang</label>
                            <input type="number" id="jumlah" name="jumlah" class="mt-1 block w-full" min="1" required>
                        </div>
                        <div class="mb-4">
                            <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700">Tanggal pinjam</label>
                            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                            <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="mt-1 block w-full" required>
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Pinjam Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
