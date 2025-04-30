<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full mt-6 table-auto border-collapse">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Nama Karyawan</th>
                                <th class="border px-4 py-2">Email</th>
                                <th class="border px-4 py-2">No HP</th>
                                <th class="border px-4 py-2">Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawans as $karyawan)
                                <tr>
                                    <td class="border px-4 py-2">{{ $karyawan->nama_karyawan }}</td>
                                    <td class="border px-4 py-2">{{ $karyawan->email }}</td>
                                    <td class="border px-4 py-2">{{ $karyawan->no_hp }}</td>
                                    <td class="border px-4 py-2">{{ $karyawan->jabatan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
