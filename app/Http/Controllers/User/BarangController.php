<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $barangs = Barang::when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_barang', 'like', "%$search%")
                      ->orWhere('jenis_barang', 'like', "%$search%")
                      ->orWhere('seri', 'like', "%$search%");
                });
            })
            ->where('stok', '>', 0) // Hanya tampilkan yang stoknya masih ada
            ->orderBy('nama_barang')
            ->get();

        return view('user.barang.index', compact('barangs'));
    }
}
