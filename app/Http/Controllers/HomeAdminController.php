<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeAdminController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->get();
        $barangCount = Barang::count();
        $karyawanCount = Karyawan::count();
        $peminjamanCount = Peminjaman::count();
        $peminjamans = Peminjaman::latest()->take(5)->get();

        $barangTerbanyak = Peminjaman::select('nama_barang', DB::raw('COUNT(*) as total'))
            ->groupBy('nama_barang')
            ->orderByDesc('total')
            ->first();

        $peminjamanPerBulan = Peminjaman::select(
                DB::raw('MONTH(tanggal_pinjam) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('tanggal_pinjam', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();


        $notifikasiCount = Peminjaman::where('status', 'menunggu konfirmasi')->count();

        return view('admin.dashboard', compact(
            'barangs',
            'barangCount',
            'karyawanCount',
            'peminjamanCount',
            'peminjamans',
            'barangTerbanyak',
            'peminjamanPerBulan',
            'notifikasiCount'
        ));
    }
}
