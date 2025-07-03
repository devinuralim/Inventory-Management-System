<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Barang::select('nama_barang', 'jenis_barang', 'stok', 'seri', 'keterangan')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Jenis Barang',
            'Stok',
            'Seri',
            'Keterangan',
        ];
    }
}
