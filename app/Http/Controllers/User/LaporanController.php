<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanBarang;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = LaporanBarang::with('barang')->latest()->get();
        return view('user.laporan.index', compact('laporan'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('user.laporan.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jenis_laporan' => 'required',
            'deskripsi' => 'nullable',
            'jumlah' => 'required|numeric'
        ]);

        $barang = Barang::where('nama_barang', $request->nama_barang)->first();

        LaporanBarang::create([
            'barang_id' => $barang ? $barang->id : null,
            'user_id' => auth()->id(),
            'jenis_laporan' => $request->jenis_laporan,
            'keterangan' => $request->deskripsi,
            'jumlah' => $request->jumlah,
            'status' => 'menunggu',
            'tindakan_admin' => null
        ]);

        return redirect()->route('user.laporan.index')
            ->with('success', 'Laporan berhasil dikirim');
    }
}