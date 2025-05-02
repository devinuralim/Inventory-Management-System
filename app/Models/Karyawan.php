<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';
    protected $fillable = [
       'id_pegawai',
        'nama_lengkap',
        'tanggal_bergabung',
        'jabatan',
    ];
}
