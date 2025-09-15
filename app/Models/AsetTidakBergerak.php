<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetTidakBergerak extends Model
{
    protected $table = 'aset_tidak_bergerak';
    protected $primaryKey = 'aset_id';
    public $timestamps = false;

    protected $fillable = [
        'ukuran',
        'bahan',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'aset_id');
    }
}
