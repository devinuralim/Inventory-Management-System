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
        // Cari peminjaman berdasarkan ID
        $peminjaman = Peminjaman::findOrFail($id);

        // Pastikan status peminjaman adalah 'dipinjam'
        if ($peminjaman->status == 'dipinjam') {
            // Ubah status peminjaman menjadi 'menunggu konfirmasi'
            $peminjaman->status = 'menunggu konfirmasi';
            $peminjaman->save();

            // Kembali ke halaman daftar peminjaman dengan pesan sukses
            return redirect()->route('user.peminjaman.index')->with('success', 'Pengembalian barang telah diajukan, menunggu konfirmasi admin.');
        }
    
    }
}
