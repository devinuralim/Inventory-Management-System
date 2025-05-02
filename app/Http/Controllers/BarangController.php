<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Tampilkan daftar barang
    public function index()
    {
        $barangs = Barang::all();
        return view('admin.barang.index', compact('barangs'));
    }

    // Form tambah barang
    public function create()
    {
        return view('admin.barang.create');
    }

    // Simpan barang baru
    public function save(Request $request)
    {
        $request->validate([
        'nama_barang' => 'required',
        'jenis_barang' => 'required',
        'stok' => 'required|integer',
        'seri' => 'required',
        'keterangan' => 'nullable',
        ]);

        Barang::create($request->all());

        return redirect()->route('admin.barangs')->with('success', 'Barang berhasil ditambahkan');
    }

    // Form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.edit', compact('barang'));
    }

    // Update barang
    public function update(Request $request, $id)
    {
        $request->validate([
        'nama_barang' => 'required',
        'jenis_barang' => 'required',
        'stok' => 'required|integer',
        'seri' => 'required',
        'keterangan' => 'nullable',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('admin.barangs')->with('success', 'Barang berhasil diperbarui');
    }

    // Hapus barang
    public function delete($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('admin.barangs')->with('success', 'Barang berhasil dihapus');
    }
}
