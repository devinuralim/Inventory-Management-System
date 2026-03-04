<?php
namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoryExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Peminjaman::query();

        if ($this->request->status) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->barang) {
            $query->where('nama_barang', 'like', '%' . $this->request->barang . '%');
        }

        if ($this->request->peminjam) {
            $query->where('nama_peminjam', 'like', '%' . $this->request->peminjam . '%');
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['Nama', 'Barang', 'Jumlah', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status'];
    }
}