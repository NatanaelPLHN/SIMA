<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;

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
        'status',
        'department_id',

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
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'department_id');
    }
    public function peminjaman()
    {
        return $this->hasMany(Borrowing::class, 'aset_id');
    }

    public function stockOpnameDetails()
    {
        return $this->hasMany(StockOpnameDetail::class, 'aset_id');
    }
    public function usage()
    {
        return $this->hasMany(AssetUsage::class, 'asset_id');
    }

    public function currentUsage()
    {
        return $this->hasOne(AssetUsage::class, 'asset_id')
            ->where('status', 'dipakai')
            ->latest();
    }
}
