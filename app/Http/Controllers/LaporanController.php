<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanBarang;
use App\Models\Barang;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = LaporanBarang::with('barang')->latest()->get();
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