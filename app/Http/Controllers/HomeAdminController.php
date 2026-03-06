<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Peminjaman;
use App\Models\LaporanBarang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeAdminController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->get();
        $barangCount = Barang::count();
        $karyawanCount = Karyawan::count();

        // Barang yang sedang dipinjam (Status aktif)
        $peminjamanCount = Peminjaman::where('status', 'dipinjam')->count();

        $peminjamans = Peminjaman::latest()->take(5)->get();
        $stokRendah = Barang::where('stok', '<', 3)->get();

        // --- LOGIKA BULAN INI ---
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // BARANG MASUK (Barang yang baru diinput/dibuat bulan ini)
        $barangMasuk = Barang::whereMonth('created_at', $currentMonth)
                            ->whereYear('created_at', $currentYear)
                            ->sum('stok');

        // BARANG KELUAR (Total peminjaman yang terjadi bulan ini)
        $barangKeluar = Peminjaman::whereMonth('tanggal_pinjam', $currentMonth)
                                ->whereYear('tanggal_pinjam', $currentYear)
                                ->count();
        // -------------------------

        $barangTerbanyak = Peminjaman::select('nama_barang', DB::raw('COUNT(*) as total'))
            ->groupBy('nama_barang')
            ->orderByDesc('total')
            ->first();

        // Data statistik untuk list bulanan (mengganti grafik)
        $peminjamanPerBulan = Peminjaman::select(
                    DB::raw('MONTH(tanggal_pinjam) as bulan'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereYear('tanggal_pinjam', $currentYear)
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

        $notifikasiCount = Peminjaman::where('status', 'menunggu konfirmasi')->count();
        $notifikasiLaporan = LaporanBarang::where('status', 'menunggu')->count();

        return view('admin.dashboard', compact(
            'barangs',
            'barangCount',
            'karyawanCount',
            'peminjamanCount',
            'peminjamans',
            'barangTerbanyak',
            'peminjamanPerBulan',
            'notifikasiCount',
            'notifikasiLaporan',
            'stokRendah',
            'barangMasuk',
            'barangKeluar'
        ));
    }
}