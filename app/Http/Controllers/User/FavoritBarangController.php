<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;

class FavoritBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favoritBarangs = $user->favoritBarang()->get();

        return view('user.favorit.index', compact('favoritBarangs'));
    }

    public function toggle($barangId)
    {
        $user = Auth::user();

        if ($user->favoritBarang()->where('barang_id', $barangId)->exists()) {
            $user->favoritBarang()->detach($barangId);
            $message = 'Barang dihapus dari favorit.';
        } else {
            $user->favoritBarang()->attach($barangId);
            $message = 'Barang ditambahkan ke favorit.';
        }

        return redirect()->back()->with('success', $message);
    }
}
