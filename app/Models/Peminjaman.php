<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'asset_id',
        'borrowed_by',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];

    // Relasi dengan Asset
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    // Relasi dengan Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Employee::class, 'borrowed_by');
    }
}
