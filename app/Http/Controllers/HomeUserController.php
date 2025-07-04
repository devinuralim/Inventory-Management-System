<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;

class HomeUserController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::where('tampilkan', true)
                                ->latest()
                                ->first(); // ambil satu yang terbaru saja

        return view('user.dashboard', compact('pengumuman'));
    }
}
