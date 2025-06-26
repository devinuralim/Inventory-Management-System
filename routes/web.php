<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\HomeUserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\User\BarangController as UserBarangController;
use App\Http\Controllers\User\KaryawanController as UserKaryawanController;
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;

Route::get('/', function () {
    return view('welcome');
});

// Default dashboard route (bisa dihapus kalau gak dipakai)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ========================
// 🔐 AUTH ROUTE
// ========================
require __DIR__.'/auth.php';

// ========================
// 🔒 ADMIN ROUTES
// ========================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeAdminController::class, 'index'])->name('dashboard');

    // Barang
    Route::get('/barangs', [BarangController::class, 'index'])->name('barangs');
    Route::get('/barangs/create', [BarangController::class, 'create'])->name('barangs.create');
    Route::post('/barangs/save', [BarangController::class, 'save'])->name('barangs.save');
    Route::get('/barangs/edit/{id}', [BarangController::class, 'edit'])->name('barangs.edit');
    Route::put('/barangs/edit/{id}', [BarangController::class, 'update'])->name('barangs.update');
    Route::get('/barangs/delete/{id}', [BarangController::class, 'delete'])->name('barangs.delete');

    // Karyawan
    Route::get('/karyawans', [KaryawanController::class, 'index'])->name('karyawans.index');
    Route::get('/karyawans/create', [KaryawanController::class, 'create'])->name('karyawans.create');
    Route::post('/karyawans/save', [KaryawanController::class, 'save'])->name('karyawans.save');
    Route::get('/karyawans/edit/{id_pegawai}', [KaryawanController::class, 'edit'])->name('karyawans.edit');
    Route::put('/karyawans/edit/{id}', [KaryawanController::class, 'update'])->name('karyawans.update');
    Route::get('/karyawans/delete/{id}', [KaryawanController::class, 'delete'])->name('karyawans.delete');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::patch('/peminjaman/{id}/konfirmasi', [PeminjamanController::class, 'konfirmasiPengembalian'])->name('peminjaman.konfirmasi');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.delete');

    // Profil Admin
    Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================
// 👤 USER ROUTES
// ========================
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeUserController::class, 'index'])->name('dashboard');

    // Barang
    Route::get('/barang', [UserBarangController::class, 'index'])->name('barang.index');

    // Peminjaman
    Route::get('/peminjaman', [UserPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [UserPeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [UserPeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/kembalikan/{id}', [UserPeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

    // Profil User
    Route::get('/profile', [ProfileController::class, 'userProfile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
