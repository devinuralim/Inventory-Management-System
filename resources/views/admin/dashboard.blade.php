<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Selamat Datang di Dashboard Admin!</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Menu Barang -->
                        <a href="{{ route('admin.barangs') }}" 
                           class="block text-center bg-blue-300 hover:bg-blue-400 text-black font-bold py-6 rounded-lg shadow-lg">
                            Daftar Barang
                        </a>

                        <!-- Menu Karyawan -->
                        <a href="{{ route('admin.karyawans.index') }}" 
                           class="block text-center bg-green-300 hover:bg-green-400 text-black font-bold py-6 rounded-lg shadow-lg">
                           Daftar Karyawan
                        </a>

                        <!-- Menu Peminjaman -->
                        <a href="{{ route('admin.peminjaman.index') }}" 
                           class="block text-center bg-yellow-300 hover:bg-yellow-400 text-black font-bold py-6 rounded-lg shadow-lg">
                            Daftar Peminjaman Barang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
