<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanBarang extends Model
{
    protected $fillable = [
        'barang_id',
        'user_id',
        'jenis_laporan',
        'keterangan',
        'jumlah',
        'status',
        'tindakan_admin'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function index()
    {
        $notifikasiCount = LaporanBarang::where('status', 'menunggu')->count();

        return view('admin.dashboard', compact('notifikasiCount'));
    }
}