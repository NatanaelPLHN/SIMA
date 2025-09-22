<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'bidang';

    protected $fillable = [
        'nama',
        'kepala_bidang_id',
        'lokasi',
        'instansi_id',
    ];

    // Relasi dengan Instansi
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }

    // Relasi dengan Karyawan (Kepala Bidang)
    public function kepala()
    {
        return $this->belongsTo(Karyawan::class, 'kepala_bidang_id');
    }

    // Relasi dengan Karyawan (Anggota Bidang)
    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'department_id');
    }
}
