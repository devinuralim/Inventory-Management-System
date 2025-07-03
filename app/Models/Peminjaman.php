<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;
    
    protected $table = 'peminjaman';

    protected $fillable = [
        'nama_peminjam',
        'nama_barang',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluarans::class, 'peminjaman_id'); 
    }
}
