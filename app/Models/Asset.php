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
        'kategori',
        'group_kategori',
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
}
