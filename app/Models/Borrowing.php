<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Borrowing extends Model
{
    use HasFactory;

    protected $table = 'borrowing';

    protected $fillable = [
        'asset_id',
        'borrowed_by',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'tujuan_penggunaan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];

    // Relasi dengan Asset
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id')->withDefault([
            'nama_aset' => 'Asset telah dihapus',
            'kode' => 'N/A'
        ]);
    }

    // Relasi dengan Karyawan
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'borrowed_by')->withDefault([
            'nama' => 'Karyawan telah dihapus',
            'nip' => 'N/A'
        ]);
    }
    // public function karyawan()
    // {
    //     return $this->belongsTo(Karyawan::class, 'borrowed_by');
    // }
}