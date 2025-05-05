<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', [HomeAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/barangs', [BarangController::class, 'index'])->name('admin.barangs');
    Route::get('admin/barangs/create', [BarangController::class, 'create'])->name('admin.barangs.create');
    Route::post('admin/barangs/save', [BarangController::class, 'save'])->name('admin.barangs.save');
    Route::get('admin/barangs/edit/{id}', [BarangController::class, 'edit'])->name('admin.barangs.edit');
    Route::put('admin/barangs/edit/{id}', [BarangController::class, 'update'])->name('admin.barangs.update');
    Route::get('admin/barangs/delete/{id}', [BarangController::class, 'delete'])->name('admin.barangs.delete');

    Route::get('admin/karyawans', [KaryawanController::class, 'index'])->name('admin.karyawans.index');
    Route::get('admin/karyawans/create', [KaryawanController::class, 'create'])->name('admin.karyawans.create');
    Route::post('admin/karyawans/save', [KaryawanController::class, 'save'])->name('admin.karyawans.save');
    Route::get('admin/karyawans/edit/{id_pegawai}', [KaryawanController::class, 'edit'])->name('admin.karyawans.edit');
    Route::put('admin/karyawans/edit/{id}', [KaryawanController::class, 'update'])->name('admin.karyawans.update');
    Route::get('admin/karyawans/delete/{id}', [KaryawanController::class, 'delete'])->name('admin.karyawans.delete');

    Route::get('admin/peminjaman', [PeminjamanController::class, 'index'])->name('admin.peminjaman.index');
    Route::get('admin/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('admin.peminjaman.kembalikan');
});
//user
Route::middleware(['auth'])->group(function () {
    Route::get('user/dashboard', [HomeUserController::class, 'index'])->name('user.dashboard');

    Route::get('user/barang', [UserBarangController::class, 'index'])->name('user.barang.index'); 
    Route::get('user/karyawan', [UserKaryawanController::class, 'index'])->name('user.karyawan.index'); 
    Route::get('user/peminjaman', [UserPeminjamanController::class, 'index'])->name('user.peminjaman.index');
    Route::get('user/peminjaman/create', [UserPeminjamanController::class, 'create'])->name('user.peminjaman.create');
    Route::post('user/peminjaman', [UserPeminjamanController::class, 'store'])->name('user.peminjaman.store');   

    Route::get('user/peminjaman/kembalikan/{id}', [UserPeminjamanController::class, 'kembalikan'])->name('user.peminjaman.kembalikan');
    Route::patch('/admin/peminjaman/{id}/konfirmasi', [PeminjamanController::class, 'konfirmasiPengembalian'])->name('admin.peminjaman.konfirmasi');
    Route::delete('admin/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('admin.peminjaman.delete');
});



require __DIR__.'/auth.php';
