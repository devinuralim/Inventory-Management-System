<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Karyawan;

class PeminjamanController extends Controller
{
    // Menampilkan semua peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::orderBy('id', 'desc')->get();
        $total = Peminjaman::count();
        return view('admin.peminjaman.index', compact(['peminjamans', 'total']));
    }

    // Menampilkan form untuk menambah peminjaman
    public function create()
    {
        $barangs = Barang::all();  // Ambil semua barang
        $karyawans = Karyawan::all();  // Ambil semua karyawan
        return view('admin.peminjaman.create', compact('barangs', 'karyawans'));
    }

    // Menyimpan peminjaman baru
    public function save(Request $request)
    {
        $validation = $request->validate([
            'nama_peminjam' => 'required',
            'nama_barang' => 'required',
            'jumlah' => 'required|integer',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
        ]);

        // Tambahkan status default 'dipinjam' saat membuat data
        $data = Peminjaman::create([
            'nama_peminjam' => $request->nama_peminjam,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam', // status dipinjam saat pertama kali
        ]);

        if ($data) {
            session()->flash('success', 'Peminjaman berhasil ditambahkan');
            return redirect(route('admin.peminjaman.index'));
        } else {
            session()->flash('error', 'Terjadi masalah saat menambahkan peminjaman');
            return redirect(route('admin.peminjaman.create'));
        }
    }

    // Menghapus peminjaman
    public function delete($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        if ($peminjaman) {
            session()->flash('success', 'Peminjaman berhasil dihapus');
            return redirect(route('admin.peminjaman.index'));
        } else {
            session()->flash('error', 'Peminjaman gagal dihapus');
            return redirect(route('admin.peminjaman.index'));
        }
    }

 // Konfirmasi pengembalian oleh admin
public function konfirmasiPengembalian($id)
{
    // Ambil data peminjaman berdasarkan id
    $peminjaman = Peminjaman::findOrFail($id);

    // Pastikan status peminjaman adalah 'menunggu konfirmasi' sebelum diubah
    if ($peminjaman->status !== 'menunggu konfirmasi') {
        return redirect()->route('admin.peminjaman.index')->with('error', 'Status peminjaman tidak valid untuk dikonfirmasi');
    }

    // Ubah status peminjaman menjadi 'dikembalikan'
    $peminjaman->status = 'dikembalikan';
    $peminjaman->status_konfirmasi = 'dikonfirmasi';  // Set status konfirmasi ke 'dikonfirmasi'

    if ($peminjaman->save()) {
        // Mengurangi stok barang jika sudah dikembalikan
        $barang = Barang::where('nama_barang', $peminjaman->nama_barang)->first();
        if ($barang) {
            $barang->stok += $peminjaman->jumlah;
            $barang->save();
        }

        return redirect()->route('admin.peminjaman.index')->with('success', 'Pengembalian barang telah dikonfirmasi');
    } else {
        return redirect()->route('admin.peminjaman.index')->with('error', 'Gagal mengonfirmasi pengembalian barang');
    }
}

}