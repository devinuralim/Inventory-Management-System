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
        $peminjamans = Peminjaman::where('nama_peminjam', auth()->user()->name)
                            ->latest()
                            ->get();

        return view('user.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('user.peminjaman.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string|distinct',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
        ]);

        foreach ($request->nama_barang as $index => $namaBarang) {
            $barang = Barang::where('nama_barang', $namaBarang)->first();

            if (!$barang || $barang->stok < $request->jumlah[$index]) {
                return back()->with('error', 'Stok tidak cukup untuk barang: ' . $namaBarang);
            }

            $barang->stok -= $request->jumlah[$index];
            $barang->save();

            Peminjaman::create([
                'nama_peminjam' => auth()->user()->name,
                'nama_barang' => $namaBarang,
                'jumlah' => $request->jumlah[$index],
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => null,
                'status' => 'dipinjam',
            ]);
        }

        return redirect()->route('user.peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status == 'dipinjam') {
            $peminjaman->status = 'menunggu konfirmasi';
            $peminjaman->save();

            return redirect()->route('user.peminjaman.index')->with('success', 'Pengembalian barang telah diajukan, menunggu konfirmasi admin.');
        }

        return redirect()->route('user.peminjaman.index')->with('error', 'Barang tidak dapat dikembalikan.');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status === 'dipinjam') {
            return redirect()->route('user.peminjaman.index')->with('error', 'Peminjaman tidak dapat dihapus karena masih berlangsung.');
        }

        $barang = Barang::where('nama_barang', $peminjaman->nama_barang)->first();
        if ($barang) {
            $barang->stok += $peminjaman->jumlah;
            $barang->save();
        }

        $peminjaman->delete();

        return redirect()->route('user.peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
