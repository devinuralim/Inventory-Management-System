<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        if ($search) {
            $barangs = Barang::where('nama_barang', 'like', '%' . $search . '%')
                ->orWhere('jenis_barang', 'like', '%' . $search . '%')
                ->orWhere('seri', 'like', '%' . $search . '%')
                ->get();
        } else {
            $barangs = Barang::all();
        }
    
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('admin.barang.create');
    }

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

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.edit', compact('barang'));
    }

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

    public function delete($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('admin.barangs')->with('success', 'Barang berhasil dihapus');
    }
}
