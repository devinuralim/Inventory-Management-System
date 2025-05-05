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

        if ($search) {
            $barangs = Barang::where('nama_barang', 'like', '%' . $search . '%')
                ->orWhere('jenis_barang', 'like', '%' . $search . '%')
                ->orWhere('seri', 'like', '%' . $search . '%')
                ->get();
        } else {
            $barangs = Barang::all();
        }

        return view('user.barang.index', compact('barangs'));
    }
}
