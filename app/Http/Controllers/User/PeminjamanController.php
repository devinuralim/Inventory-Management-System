<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;

class PeminjamanController extends Controller
{
    // Menampilkan daftar peminjaman oleh user
    public function index()
    {
        // Ambil peminjaman berdasarkan nama peminjam (user yang sedang login)
        $peminjamans = Peminjaman::where('nama_peminjam', auth()->user()->name)->get();

        return view('user.peminjaman.index', compact('peminjamans'));
    }

    // Menampilkan form peminjaman barang
    public function create()
    {
        $barangs = Barang::all();  // Ambil semua barang
        return view('user.peminjaman.create', compact('barangs'));
    }

    // Menyimpan peminjaman barang
    public function store(Request $request)
    {
        // Validasi input dari form
        $validation = $request->validate([
            'nama_peminjam' => 'required',
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
        ]);

        // Cek apakah stok barang cukup
        $barang = Barang::where('nama_barang', $request->nama_barang)->first();
        if ($barang->stok < $request->jumlah) {
            return back()->with('error', 'Stok barang tidak cukup');
        }

        // Kurangi stok barang
        $barang->stok -= $request->jumlah;
        $barang->save();

        // Simpan data peminjaman
        Peminjaman::create([
            'nama_peminjam' => $request->nama_peminjam,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam',
        ]);

        return redirect()->route('user.peminjaman.index')->with('success', 'Peminjaman berhasil');
    }

    // Mengembalikan barang yang dipinjam
    public function kembalikan($id)
    {
        // Ambil data peminjaman berdasarkan id
        $peminjaman = Peminjaman::findOrFail($id);

        // Cek apakah peminjaman benar milik user yang sedang login
        if ($peminjaman->nama_peminjam != auth()->user()->name) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengembalikan barang ini');
        }

        // Update status peminjaman menjadi 'dikembalikan'
        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();

        // Tambahkan kembali stok barang yang dikembalikan
        $barang = Barang::where('nama_barang', $peminjaman->nama_barang)->first();
        $barang->stok += $peminjaman->jumlah;
        $barang->save();

        return redirect()->route('user.peminjaman.index')->with('success', 'Barang telah berhasil dikembalikan');
    }
}
