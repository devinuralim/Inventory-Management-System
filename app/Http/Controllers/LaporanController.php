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

        if ($request->tindakan_admin == 'kurangi_stok') {
            $barang->stok -= $laporan->jumlah;
            $barang->save();
        }

        $laporan->status = 'selesai';
        $laporan->tindakan_admin = $request->tindakan_admin;
        $laporan->save();

        return redirect()->back()->with('success', 'Laporan selesai diproses');
    }
}