<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanBarang;
use App\Models\Barang;

class LaporanController extends Controller
{
    // Tambahkan parameter Request $request di sini
    public function index(Request $request)
    {
        // Mulai query dari model
        $query = LaporanBarang::with('barang');

        // Filter Bulan (jika ada input bulan)
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter Tahun (jika ada input tahun)
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        // Eksekusi query
        $laporans = $query->latest()->get();

        return view('admin.laporan.index', compact('laporans'));
    }

    public function selesaikan(Request $request, $id)
{
    $laporan = LaporanBarang::findOrFail($id);
    $barang = Barang::findOrFail($laporan->barang_id);

    // 1. Ambil status dari input dropdown di View
    $statusBaru = $request->status;

    // 2. Logika Kurangi Stok: Hanya jalan kalau status diubah ke 'selesai'
    // Dan pastikan stok belum pernah dikurangi sebelumnya (biar tidak berkali-kali berkurang)
    if ($statusBaru == 'selesai' && $laporan->status != 'selesai') {
        // Cek jika tindakan admin adalah kurangi stok (atau buat default jika perlu)
        if ($request->tindakan_admin == 'kurangi_stok' || $laporan->jenis_laporan == 'hilang' || $laporan->jenis_laporan == 'rusak') {
            $barang->stok -= $laporan->jumlah;
            $barang->save();
        }
    }

    // 3. Update status sesuai pilihan dropdown
    $laporan->status = $statusBaru;
    
    // Simpan tindakan admin jika ada inputnya
    if ($request->filled('tindakan_admin')) {
        $laporan->tindakan_admin = $request->tindakan_admin;
    }
    
    $laporan->save();

    return redirect()->back()->with('success', 'Status laporan berhasil diperbarui menjadi ' . ucfirst($statusBaru));
}
}