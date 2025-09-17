<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetBergerak extends Model
{
    protected $table = 'aset_bergerak';
    protected $primaryKey = 'aset_id';
    public $timestamps = false;

    protected $fillable = [
        'aset_id',
        'merk',
        'tipe',
        'nomor_serial',
        'tahun_produksi'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'aset_id');
    }
}
