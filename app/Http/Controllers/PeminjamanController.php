<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Karyawan;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::orderBy('id', 'desc')->get();
        $total = Peminjaman::count();
        return view('admin.peminjaman.index', compact(['peminjamans', 'total']));
    }

    public function create()
    {
        $barangs = Barang::all(); 
        $karyawans = Karyawan::all();
        return view('admin.peminjaman.create', compact('barangs', 'karyawans'));
    }

    public function save(Request $request)
    {
        $validation = $request->validate([
            'nama_peminjam' => 'required',
            'nama_barang' => 'required',
            'jumlah' => 'required|integer',
            'tanggal_pinjam' => 'required|date',
          'tanggal_kembali' => $request->tanggal_kembali ?: null,
        ]);

        $data = Peminjaman::create([
            'nama_peminjam' => $request->nama_peminjam,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
          'tanggal_kembali' => $request->tanggal_kembali ?: null,
            'status' => 'dipinjam', 
        ]);

        if ($data) {
            session()->flash('success', 'Peminjaman berhasil ditambahkan');
            return redirect(route('admin.peminjaman.index'));
        } else {
            session()->flash('error', 'Terjadi masalah saat menambahkan peminjaman');
            return redirect(route('admin.peminjaman.create'));
        }
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->delete()) {
            session()->flash('success', 'Peminjaman berhasil dihapus');
        } else {
            session()->flash('error', 'Peminjaman gagal dihapus');
        }

        return redirect(route('admin.peminjaman.index'));
    }

    public function konfirmasiPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu konfirmasi') {
            return redirect()->route('admin.peminjaman.index')->with('error', 'Status peminjaman tidak valid untuk dikonfirmasi');
        }

        $peminjaman->status = 'dikembalikan';

        if ($peminjaman->save()) {
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
