<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Karyawan; // Pastikan ini di-import

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::back()->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Tampilan Profile untuk Admin
     */
    public function adminProfile(): View
    {
        return view('admin.profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Tampilan Profile untuk User (Karyawan)
     */
    public function userProfile(): View
{
    $user = Auth::user();

    // Cari di tabel karyawans yang nama_lengkap-nya mengandung nama user
    // Kita gunakan 'like' agar pencarian lebih fleksibel
    $karyawan = \App\Models\Karyawan::where('nama_lengkap', 'LIKE', '%' . $user->name . '%')->first();

    return view('user.profile', [
        'user' => $user,
        'karyawan' => $karyawan
    ]);
}
}