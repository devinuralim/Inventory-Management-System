<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::where('nama_peminjam', auth()->user()->name)->get();

        return view('user.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('user.peminjaman.create', compact('barangs'));
    }

public function store(Request $request)
{
    $validation = $request->validate([
        'nama_barang' => 'required',
        'jumlah' => 'required|integer|min:1',
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date',
    ]);

    $barang = Barang::where('nama_barang', $request->nama_barang)->first();
    if ($barang->stok < $request->jumlah) {
        return back()->with('error', 'Stok barang tidak cukup');
    }

    $barang->stok -= $request->jumlah;
    $barang->save();

    $peminjaman = Peminjaman::create([
        'nama_peminjam' => auth()->user()->name,
        'nama_barang' => $request->nama_barang,
        'jumlah' => $request->jumlah,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'tanggal_kembali' => $request->tanggal_kembali,
        'status' => 'dipinjam',
    ]);

    return redirect()->route('user.peminjaman.index')->with('success', 'Peminjaman berhasil');
}

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status == 'dipinjam') {
            $peminjaman->status = 'menunggu konfirmasi';
            $peminjaman->save();

            return redirect()->route('user.peminjaman.index')->with('success', 'Pengembalian barang telah diajukan, menunggu konfirmasi admin.');
        }
    
    }
}
