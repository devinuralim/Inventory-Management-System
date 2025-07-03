<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;         
use App\Models\Peminjaman;   

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'nama_barang',
        'jenis_barang',
        'stok',
        'seri',
        'keterangan',
    ];


    public function userFavorit()
    {
        return $this->belongsToMany(User::class, 'favorit_barang_user')->withTimestamps();
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'barang_id');
    }
}
