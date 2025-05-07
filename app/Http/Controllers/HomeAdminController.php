<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Peminjaman;

class HomeAdminController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->get();
        $barangCount = Barang::count();
        $karyawanCount = Karyawan::count();
        $peminjamanCount = Peminjaman::count();
        $peminjamans = Peminjaman::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'barangs',
            'barangCount',
            'karyawanCount',
            'peminjamanCount',
            'peminjamans' 
        ));
    }
}
