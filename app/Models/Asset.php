<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'aset';

    protected $fillable = [
        'kode',
        'nama_aset',
        'jenis_aset',
        'category_id',
        'jumlah',
        'tgl_pembelian',
        'nilai_pembelian',
        'lokasi_terakhir',
        'status'
    ];

    public function bergerak()
    {
        return $this->hasOne(AsetBergerak::class, 'aset_id');
    }

    public function tidakBergerak()
    {
        return $this->hasOne(AsetTidakBergerak::class, 'aset_id');
    }

    public function habisPakai()
    {
        return $this->hasOne(AsetHabisPakai::class, 'aset_id');
    }
    // Relasi dengan category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function peminjaman()
    {
        return $this->hasMany(Borrowing::class, 'aset_id');
    }
    // public function peminjaman()
    // {
    //     return $this->hasMany(Peminjaman::class, 'aset_id');
    // }

}
