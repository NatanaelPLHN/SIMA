<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetHabisPakai extends Model
{
    use HasFactory;
    
    protected $table = 'aset_habis_pakai';
    protected $primaryKey = 'aset_id';
    public $timestamps = false;

    protected $fillable = [
        'aset_id',
        'register',
        'satuan',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'aset_id');
    }
}
